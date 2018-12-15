<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\Item;
use App\Category;
use App\CategorySecond;
use App\Tag;
use App\TagRelation;
use App\ItemUpper;
use App\ItemUpperRelation;


//use App\Consignor;
//use App\DeliveryGroup;
//use App\DeliveryGroupRelation;
use App\ItemImage;
use App\Setting;
use App\ItemStockChange;
//use App\Icon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Storage;
use File;

class ItemUpperController extends Controller
{
    
    public function __construct(Admin $admin, Item $item, Tag $tag, Category $category, CategorySecond $categorySecond, TagRelation $tagRelation, ItemUpper $itemUpper, ItemUpperRelation $itemUpperRel, ItemImage $itemImg, Setting $setting, ItemStockChange $itemSc)
    {
        
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this-> item = $item;
        $this->category = $category;
        $this->categorySecond = $categorySecond;
        $this -> tag = $tag;
        $this->tagRelation = $tagRelation;
        
        $this->itemUpper = $itemUpper;
        $this->itemUpperRel = $itemUpperRel;
        
        $this->itemImg = $itemImg;
        
        $this->set = Setting::get()->first();
        
        $this->itemSc = $itemSc;
        
        $this->perPage = 20;
        
        // URLの生成
        //$url = route('dashboard');
        
        /* ************************************** */
        //env()ヘルパー：環境変数（$_SERVER）の値を取得 .env内の値も$_SERVERに入る
    }
    
    
    
    public function getItemUpper($itemId, Request $request)
    {


    }
    
    public function postItemUpper(Request $request)
    {
    	if($request->has('iId')) {
        	$itemId = $request->input('iId');
            
            
        }
        else {
        	
        }
        
        
        
    }
    
    
    public function index()
    {
        //
    }

    public function show($id, Request $request)
    {
        if(! $request->has('type')) {
        	return view('errors.dashboard');
        	//return view('dashboard.item.formUpper')->withErrors(['e'=>'abcde']);    
            
        }

        $type = $request->input('type');
        
        if($type == 'item') {
        	$orgObj = $this->item->find($id);
        }
        elseif($type == 'cate') {
        	$orgObj = $this->category->find($id);
        }
        elseif($type == 'subcate') {
        	$orgObj = $this->categorySecond->find($id);
        }
        elseif($type == 'tag') {
        	$orgObj = $this->tag->find($id);
        }
        else {
        	return view('errors.dashboard');
        }
        
        if(!isset($orgObj)) {
        	return view('errors.dashboard');
        }
        
        $upper = $this->itemUpper->where(['type_code'=>$type, 'parent_id'=>$id])->first();
        //$upperRel = null;
        $relArr = ['a'=>array(), 'b'=>array(), 'c'=>array()];
        
        if(isset($upper) && $upper !== null) { //編集
        	$edit = 1;
        	
            $upperRels = $this->itemUpperRel->where(['upper_id'=>$upper->id])->orderBy('sort_num', 'asc')->get()/*->keyBy('block')*/;
            
            if($upperRels->isNotEmpty()) {
            	$relArr = array();
                foreach($upperRels as $upperRel) {
                	if($upperRel->is_section) {
                    	$relArr[$upperRel->block]['section'] = $upperRel;
                    }
                    else {
                    	$relArr[$upperRel->block][] = $upperRel;
                    }
                }
            }
            
        }
        else { //新規作成
        	$edit = 0;
        }
        
        
        $blockCount = [
        	'a' => $this->set->snap_block_a,
            'b' => $this->set->snap_block_b,
            'c' => $this->set->snap_block_c,
        ];
        
        //$icons = $this->icon->all();
        
        return view('dashboard.item.formUpper', ['orgObj'=>$orgObj, 'type'=>$type, 'upper'=>$upper, 'relArr'=>$relArr, 'blockCount'=>$blockCount, 'id'=>$id, 'edit'=>$edit]);
    }
    
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $editId = $request->input('edit_id');
        $type = $request->input('type');
        
    	$rules = [
//        	'number' => 'required|unique:items,number,'.$editId,
            //'block.a.0.title' => 'required|max:255',
          
//            'price' => 'required|numeric',
//            'stock' => 'nullable|numeric',
//            'stock_reset_month' => [
//                function($attribute, $value, $fail) use($request) {
//                    if($value == '') {
//                        if($request->input('stock_type') == 1) {
//                            return $fail('「在庫入荷月」を指定して下さい。');
//                        } 
//                    }
//                    elseif(! is_numeric($value)) {
//                    	return $fail('「在庫入荷月」は半角数字を入力して下さい。');
//                    }
//                    elseif ($value < 1 || $value > 12) {
//                        return $fail('「在庫入荷月」は正しい月を入力して下さい。');
//                    }
//                },
//            ],

        ];

        
        $messages = [
         	'block.a.0.title.required' => '「商品名」を入力して下さい。',
            'cate_id.required' => '「カテゴリー」を選択して下さい。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all();
        
        
        //status
        $data['open_status'] = isset($data['open_status']) ? 0 : 1;
        
//        echo $data['open_status'];
//        exit;
        
        $itemUpper = $this->itemUpper->updateOrCreate(
        	['parent_id'=>$editId, 'type_code'=>$type],
        	['open_status'=>$data['open_status']]
        );
        
//        print_r($data);
//        exit;

		$status = '上部コンテンツが編集されました。';

		foreach($data['block'] as $blockKey => $blockArr) {
        	
            $num = 0;
            
            foreach($blockArr as $key => $vals) {
                
				$isSection = $key === 'section' ? 1 : 0; //大タイトルの時かブロックかを判別する
                
                if(isset($vals['del_block']) && $vals['del_block'] && $vals['rel_id']) { //block削除の時
                	$upperRel = $this->itemUpperRel->find($vals['rel_id']);
                    
                    if(isset($upperRel->img_path)) {
                    	Storage::delete('public/'. $upperRel->img_path);
                    }
                    
                    $upperRel->delete();
                    
                    //$status .= "\n". '「' . $blockKey . 'ブロック-' . ($vals['count']+1) . '」が削除されました。';
                }
                else {
                    //relationのidをinput-hiddenに設定し（0ならcreate）$vals['rel_id']でupdateOrCreateする方法もあり
                    $upperRel = $this->itemUpperRel->updateOrCreate(
                        [
                            'id' => $vals['rel_id'],
                        ],
                        [
                            'upper_id'=> $itemUpper->id, 
                            'block'=> $blockKey, 
                            'title'=> $vals['title'],
                            'detail'=> $isSection ? null : $vals['detail'],
                            'is_section'=> $isSection ? 1 : 0,
                            'sort_num'=> $isSection ? 0 : $num+1,
                        ]
                    );

					//sort_numでデータを照合してupdateOrCreateする方法もあり
                    /*
                    $upperRel = $this->itemUpperRel->updateOrCreate(
                        [
                            'upper_id'=> $itemUpper->id, 
                            'block'=> $blockKey, 
                            'is_section'=> $isSection ? 1 : 0,
                            'sort_num'=> $isSection ? 0 : $vals['count']+1,
                        ],
                        [
                            'title'=> $vals['title'],
                            'detail'=> $isSection ? null : $vals['detail'],
                            'sort_num'=> $isSection ? 0 : $num+1,
                        ]
                    );
                    */
                    
                    
                    if(isset($vals['del_img']) && $vals['del_img']) { //削除チェックの時
                        Storage::delete('public/'. $upperRel->img_path); //Storageはpublicフォルダのあるところをルートとしてみる
                        
                        $upperRel->img_path = null;
                        $upperRel->save();
                    }
                    else {
                        if(isset($vals['img'])) {
                        
                            $filename = $vals['img']->getClientOriginalName();
                            $filename = str_replace(' ', '_', $filename);
                            
                            //$aId = $editId ? $editId : $rand;
                            //$pre = time() . '-';
                            $pre = mt_rand(0, 99999) . '-';
                            
                            $filename = 'upper/' . $type . '/' . $editId . '/' . $blockKey . '/' . $pre . $filename;
                            //$dirName = 'upper/' . $type . '/' . $editId . '/' . $blockKey;

                            //new File()は画像情報を取得するためのもの。 new File('aaa.jpg')とすると、$vals['img'] or $request->file('img')と同じものになる
                            
                            //$path = $vals['img']->store($dirName); //ファイル名が自動生成される
                            //Storage::putFile($dirName, $vals['img']); //上と同じ
                            
                            //$path = $vals['img']->storeAs($dirName, 'abc'); //ファイル名を独自指定(拡張子が付かない)
                            $path = $vals['img']->storeAs('public', $filename);
                            
                            //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
                            //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
                                                    
                            $upperRel->img_path = $filename;
                            $upperRel->save();
                        }
                    }
                    
                    if(! $isSection) $num++;
                }

            }
            
        }
		
                
        
//        if($editId) { //update（編集）の時
//            $status = '上部コンテンツが更新されました！';
//            //$itemUpper = $this->itemUpper->where(['parent_id'=>$editId, 'type_code'=>$type])->first();
//            //echo date('Y-m-d H:i:s', time());
//
//            
//            
//        }
//        else { //新規追加の時
//            $status = '上部コンテンツが追加されました！';            
//            
//        }
        

        
        
        
        
        return redirect('dashboard/upper/'. $editId . '?type=' . $type)->with('status', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
