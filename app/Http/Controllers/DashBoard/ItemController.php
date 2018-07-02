<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\Item;
use App\Category;
use App\CategorySecond;
use App\Tag;
use App\TagRelation;
use App\Consignor;
use App\DeliveryGroup;
use App\ItemImage;
use App\Setting;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;

use Storage;

class ItemController extends Controller
{
    public function __construct(Admin $admin, Item $item, Tag $tag, Category $category, CategorySecond $categorySecond, TagRelation $tagRelation, Consignor $consignor, DeliveryGroup $dg, ItemImage $itemImg, Setting $setting)
    {
        
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this-> item = $item;
        $this->category = $category;
        $this->categorySecond = $categorySecond;
        $this -> tag = $tag;
        $this->tagRelation = $tagRelation;
        $this->consignor = $consignor;
        $this->dg = $dg;
        $this->itemImg = $itemImg;
        $this->setting = $setting;
        
        $this->perPage = 20;
        
        // URLの生成
        //$url = route('dashboard');
        
        /* ************************************** */
        //env()ヘルパー：環境変数（$_SERVER）の値を取得 .env内の値も$_SERVERに入る
    }
    
    
    
    public function index()
    {
        
        $itemObjs = Item::orderBy('id', 'desc')->paginate($this->perPage);
        
        $cates= $this->category;
        $subCates= $this->categorySecond;
        $dgs = $this->dg;
        
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.item.index', ['itemObjs'=>$itemObjs, 'cates'=>$cates, 'subCates'=>$subCates, 'dgs'=>$dgs]);
    }

    public function show($id)
    {
        $item = $this->item->find($id);
        $cates = $this->category->all();
        $subcates = $this->categorySecond->where(['parent_id'=>$item->cate_id])->get();
        $consignors = $this->consignor->all();
        $dgs = $this->dg->all();
        
        $spares = $this->itemImg->where(['item_id'=>$id, 'type'=>1])->get();
        $snaps = $this->itemImg->where(['item_id'=>$id, 'type'=>2])->get();
        
        //$users = $this->user->where('active',1)->get();
        
		$tagNames = $this->tagRelation->where(['item_id'=>$id])->get()->map(function($item) {
            return $this->tag->find($item->tag_id)->name;
        })->all();
        
        $allTags = $this->tag->get()->map(function($item){
            return $item->name;
        })->all();
        
        $setting = $this->setting->get()->first();
        $primaryCount = $setting->snap_primary;
        $imgCount = $setting->snap_secondary;
        
        return view('dashboard.item.form', ['item'=>$item, 'cates'=>$cates, 'subcates'=>$subcates, 'consignors'=>$consignors, 'dgs'=>$dgs, 'tagNames'=>$tagNames, 'allTags'=>$allTags, 'spares'=>$spares, 'snaps'=>$snaps, 'primaryCount'=>$primaryCount, 'imgCount'=>$imgCount, 'id'=>$id, 'edit'=>1]);
    }
   
    public function create()
    {
        $cates = $this->category->all();
        $consignors = $this->consignor->all();
        $dgs = $this->dg->all();
        
        $allTags = $this->tag->get()->map(function($item){
        	return $item->name;
        })->all();
        
        $setting = $this->setting->get()->first();
        $primaryCount = $setting->snap_primary;
        $imgCount = $setting->snap_secondary;
        
//        $users = $this->user->where('active',1)->get();
        return view('dashboard.item.form', ['cates'=>$cates, 'consignors'=>$consignors, 'dgs'=>$dgs, 'allTags'=>$allTags, 'primaryCount'=>$primaryCount, 'imgCount'=>$imgCount, ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$editId = $request->has('edit_id') ? $request->input('edit_id') : 0;
        
    	$rules = [
            'title' => 'required|max:255',
            //'cate_id' => 'required',
            //'main_img' => 'filenaming',
        ];
        
         $messages = [
         	'title.required' => '「商品名」を入力して下さい。',
            'cate_id.required' => '「カテゴリー」を選択して下さい。',
            
            //'post_thumb.filenaming' => '「サムネイル-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'post_movie.filenaming' => '「動画-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'slug.unique' => '「スラッグ」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all();
        
        //status
        $data['open_status'] = isset($data['open_status']) ? 0 : 1;
        
        //stock_show
        $data['is_delifee'] = isset($data['is_delifee']) ? 1 : 0;
        $data['stock_show'] = isset($data['stock_show']) ? 1 : 0;
        $data['farm_direct'] = isset($data['farm_direct']) ? 1 : 0;
        $data['is_once'] = isset($data['is_once']) ? 1 : 0;
        
        
        if($editId) { //update（編集）の時
            $status = '商品が更新されました！';
            $item = $this->item->find($editId);
        }
        else { //新規追加の時
            $status = '商品が追加されました！';
            //$data['model_id'] = 1;
            
            $item = $this->item;
        }
        
        $item->fill($data);
        $item->save();
        $itemId = $item->id;
        
//        print_r($data['main_img']);
//        exit;
        
        //Main-img
        if(isset($data['main_img'])) {
                
            //$filename = $request->file('main_img')->getClientOriginalName();
            $filename = $data['main_img']->getClientOriginalName();
            $filename = str_replace(' ', '_', $filename);
            
            //$aId = $editId ? $editId : $rand;
            //$pre = time() . '-';
            $filename = 'item/' . $itemId . '/main/'/* . $pre*/ . $filename;
            //if (App::environment('local'))
            $path = $data['main_img']->storeAs('public', $filename);
            //else
            //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
            //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
            
            $item->main_img = $path;
            $item->save();
        }
        
        
        //SpareImg Save ==================================================
        foreach($data['spare_count'] as $count) {
                        
            if(isset($data['del_spare'][$count]) && $data['del_spare'][$count]) { //削除チェックの時
                
                $spareModel = $this->itemImg->where(['item_id'=>$itemId, 'type'=>1, 'number'=>$count+1])->first();
                
                if($spareModel !== null) {
                	Storage::delete('public/'.$snapModel->img_path); //Storageはpublicフォルダのあるところをルートとしてみる
                    $spareModel ->delete();
                }
            
            }
            else {
            	if(isset($data['spare_thumb'][$count])) {
                    
                    $spareImg = $this->itemImg->updateOrCreate(
                        ['item_id'=>$itemId, 'type'=>1, 'number'=>$count+1],
                        [
                            'item_id'=>$itemId,
                            'type' => 1,
                            'number'=> $count+1,
                        ]
                    );
                
                
                    $filename = $data['spare_thumb'][$count]->getClientOriginalName();
                    $filename = str_replace(' ', '_', $filename);
                    
                    //$aId = $editId ? $editId : $rand;
                    //$pre = time() . '-';
                    $filename = 'item/' . $itemId . '/spare/'/* . $pre*/ . $filename;
                    //if (App::environment('local'))
                    $path = $data['spare_thumb'][$count]->storeAs('public', $filename);
                    //else
                    //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
                    //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
                
                    //$data['model_thumb'] = $filename;
                    
                    $spareImg->img_path = $filename;
                    $spareImg->save();
                }
            }
            
        } //foreach
        
        $num = 1;
        $spares = $this->itemImg->where(['item_id'=>$itemId, 'type'=>1])->get();
        
        //Snapのナンバーを振り直す
        foreach($spares as $spare) {
            $spare->number = $num;
            $spare->save();
            $num++;
        }
        
        //Spare END ===========================================
        
        //Snap Save ==================================================
        foreach($data['snap_count'] as $count) {
        
			/*
               	type:1->item main
               	type:2->item spare
              	type:3->category
            	type:4->sub category
            	type:5->tag                              
           */
 
            if(isset($data['del_snap'][$count]) && $data['del_snap'][$count]) { //削除チェックの時
                //echo $count . '/' .$data['del_snap'][$count];
                //exit;
                
                $snapModel = $this->itemImg->where(['item_id'=>$itemId, 'type'=>2, 'number'=>$count+1])->first();
                
                if($snapModel !== null) {
                	Storage::delete('public/'.$snapModel->img_path); //Storageはpublicフォルダのあるところをルートとしてみる
                    $snapModel ->delete();
                }
            
            }
            else {
            	if(isset($data['snap_thumb'][$count])) {
                    
                    $snapImg = $this->itemImg->updateOrCreate(
                        ['item_id'=>$itemId, 'type'=>2, 'number'=>$count+1],
                        [
                            'item_id'=>$itemId,
                            //'snap_path' =>'',
                            'type' => 2,
                            'number'=> $count+1,
                        ]
                    );

                    $filename = $data['snap_thumb'][$count]->getClientOriginalName();
                    $filename = str_replace(' ', '_', $filename);
                    
                    //$aId = $editId ? $editId : $rand;
                    //$pre = time() . '-';
                    $filename = 'item/' . $itemId . '/snap/'/* . $pre*/ . $filename;
                    //if (App::environment('local'))
                    $path = $data['snap_thumb'][$count]->storeAs('public', $filename);
                    //else
                    //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
                    //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
                
                    //$data['model_thumb'] = $filename;
                    
                    $snapImg->img_path = $filename;
                    $snapImg->save();
                }
            }
            
        } //foreach
        
        $num = 1;
        $snaps = $this->itemImg->where(['item_id'=>$itemId, 'type'=>2])->get();
//            $snaps = $this->modelSnap->where(['model_id'=>$modelId])->get()->map(function($obj) use($num){
//                
//                return true;
//            });
        
        //Snapのナンバーを振り直す
        foreach($snaps as $snap) {
            $snap->number = $num;
            $snap->save();
            $num++;
        }
        
        //Snap END ===========================================

        
        //タグのsave動作
        if(isset($data['tags'])) {
            $tagArr = $data['tags'];
        
            foreach($tagArr as $tag) {
                
                //Tagセット
                $setTag = Tag::firstOrCreate(['name'=>$tag]); //既存を取得 or なければ作成
                
                if(!$setTag->slug) { //新規作成時slugは一旦NULLでcreateされるので、その後idをセットする
                    $setTag->slug = $setTag->id;
                    $setTag->save();
                }
                
                $tagId = $setTag->id;
                $tagName = $tag;


                //tagIdがRelationになければセット ->firstOrCreate() ->updateOrCreate()
                $tagRel = $this->tagRelation->firstOrCreate(
                    ['tag_id'=>$tagId, 'item_id'=>$itemId]
                );
                /*
                $tagRel = $this->tagRelation->where(['tag_id'=>$tagId, 'item_id'=>$itemId])->get();
                if($tagRel->isEmpty()) {
                    $this->tagRelation->create([
                        'tag_id' => $tagId,
                        'item_id' => $itemId,
                    ]);
                }
                */

                //tagIdを配列に入れる　削除確認用
                $tagIds[] = $tagId;
            }
        
            //編集時のみ削除されたタグを消す
            if(isset($editId)) {
                //元々relationにあったtagがなくなった場合：今回取得したtagIdの中にrelationのtagIdがない場合をin_arrayにて確認
                $tagRels = $this->tagRelation->where('item_id', $itemId)->get();
                
                foreach($tagRels as $tagRel) {
                    if(! in_array($tagRel->tag_id, $tagIds)) {
                        $tagRel->delete();
                    }
                }
            }
        }
        
        
        return redirect('dashboard/items/'. $itemId)->with('status', $status);
        
        
        //Spare-img ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
//        if(isset($data['spare_img'])) {
//            $spares = $data['spare_img'];
//            
////            print_r($spares);
////            exit;
//            
//            foreach($spares as $key => $spare) {
//                if($spare != '') {
//            
//                    $filename = $spare->getClientOriginalName();
//                    $filename = str_replace(' ', '_', $filename);
//                    
//                    //$aId = $editId ? $editId : $rand;
//                    //$pre = time() . '-';
//                    $filename = 'item/' . $itemId . '/thumbnail/'/* . $pre*/ . $filename;
//                    //if (App::environment('local'))
//                    $path = $spare->storeAs('public', $filename);
//                    //else
//                    //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
//                    //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
//                    
//                    //$item->spare_img .'_'. $ii = $path;
//                    $item['spare_img_'. $key] = $path;
//                    $item->save();
//                }
//
//            }
//        }
//        
//        //spare画像の削除
//        if(isset($data['del_spareimg'])) {
//            $dels = $data['del_spareimg'];     
//             
//              foreach($dels as $key => $del) {
//                   if($del) {
//                     $imgName = $item['spare_img_'. $key];
//                       if($imgName != '') {
//                         Storage::delete($imgName);
//                     }
//                    
//                       $item['spare_img_'. $key] = '';
//                    $item->save();
//                 }   
//           }
//        }
        
    }

	public function postScript(Request $request)
    {
        $cate_id = $request->input('selectValue');
        
//        $allTags = $this->tag->get()->map(function($item){
//            return $item->name;
//        })->all();
        
        $subCates = $this->categorySecond->where(['parent_id'=>$cate_id, ])->get()->map(function($obj) {
        	return [ $obj->id => $obj->name ];
        })->all();
        
        //$array = [1, 11, 12, 13, 14, 15];
         
        return response()->json(array('subCates'=> $subCates)/*, 200*/); //200を指定も出来るが自動で200が返される  
          //return view('dashboard.script.index', ['val'=>$val]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect('dashboard/items/'.$id);
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
        $name = $this->category->find($id)->name;
        
        $atcls = $this->item->where('cate_id', $id)->get()->map(function($item){
            $item->cate_id = 0;
            $item->save();
        });
        
        $cateDel = $this->category->destroy($id);
        
        $status = $cateDel ? '商品「'.$name.'」が削除されました' : '商品「'.$name.'」が削除出来ませんでした';
        
        return redirect('dashboard/items')->with('status', $status);
    }
}
