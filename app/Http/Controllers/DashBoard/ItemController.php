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
use App\DeliveryGroupRelation;
use App\ItemImage;
use App\Setting;
use App\ItemStockChange;
use App\Icon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Symfony\Component\HttpFoundation\StreamedResponse;

use App\Http\Requests;

use Auth;
use Ctm;
use Storage;
use DateTime;

class ItemController extends Controller
{
    public function __construct(Admin $admin, Item $item, Tag $tag, Category $category, CategorySecond $categorySecond, TagRelation $tagRelation, Consignor $consignor, DeliveryGroup $dg, DeliveryGroupRelation $dgRel, ItemImage $itemImg, Setting $setting, ItemStockChange $itemSc, Icon $icon)
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
        $this->dgRel = $dgRel;
        $this->itemImg = $itemImg;
        $this->setting = $setting;
        $this->itemSc = $itemSc;
        $this->icon = $icon;
        
        $this->perPage = 20;
        
        // URLの生成
        //$url = route('dashboard');
        
        /* ************************************** */
        //env()ヘルパー：環境変数（$_SERVER）の値を取得 .env内の値も$_SERVERに入る
    }
    
    
    
    public function index()
    {
        
        //$itemObjs = Item::orderBy('id', 'desc')->paginate($this->perPage);
        $itemObjs = Item::orderBy('id', 'desc')->get();
        
        $cates= $this->category;
        $subCates= $this->categorySecond;
        $dgs = $this->dg;
        
        $recentObjs = $this->item->orderBy('updated_at', 'desc')->get()->take(5);
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        
        return view('dashboard.item.index', ['itemObjs'=>$itemObjs, 'cates'=>$cates, 'subCates'=>$subCates, 'dgs'=>$dgs, 'recentObjs'=>$recentObjs, ]);
    }
    
    public function potSetIndex()
    {
    	//$itemObjs = Item::orderBy('id', 'desc')->paginate($this->perPage);
        $itemObjs = $this->item->where('is_potset', 1)->orderBy('id', 'desc')->get();
        
        $items = $this->item;
        $cates= $this->category;
        $subCates= $this->categorySecond;
        $dgs = $this->dg;
        
        $recentObjs = $this->item->where('is_potset', 1)->orderBy('updated_at', 'desc')->get()->take(5);
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        
        return view('dashboard.item.indexPotSet', ['itemObjs'=>$itemObjs, 'items'=>$items, 'cates'=>$cates, 'subCates'=>$subCates, 'dgs'=>$dgs, 'recentObjs'=>$recentObjs, ]);
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
        
		$tagNames = $this->tagRelation->where(['item_id'=>$id])->orderBy('sort_num', 'asc')->get()->map(function($item) {
            return $this->tag->find($item->tag_id)->name;
        })->all();
        
        $allTags = $this->tag->get()->map(function($item){
            return $item->name;
        })->all();
        
        $setting = $this->setting->get()->first();
        $primaryCount = $setting->snap_primary;
        $imgCount = $setting->snap_secondary;
        
        $icons = $this->icon->all();
        
        return view('dashboard.item.form', ['item'=>$item, 'cates'=>$cates, 'subcates'=>$subcates, 'consignors'=>$consignors, 'dgs'=>$dgs, 'tagNames'=>$tagNames, 'allTags'=>$allTags, 'spares'=>$spares, 'snaps'=>$snaps, 'primaryCount'=>$primaryCount, 'imgCount'=>$imgCount, 'icons'=>$icons, 'id'=>$id, 'edit'=>1]);
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
        
        $icons = $this->icon->all();
        
//        $users = $this->user->where('active',1)->get();
        return view('dashboard.item.form', ['cates'=>$cates, 'consignors'=>$consignors, 'dgs'=>$dgs, 'allTags'=>$allTags, 'primaryCount'=>$primaryCount, 'imgCount'=>$imgCount, 'icons'=>$icons, ]);
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
        	'number' => 'required|unique:items,number,'.$editId,
            'title' => 'required|max:255',
            'cate_id' => 'required',
            
            'pot_sort' => [
            	'nullable',
            	'max:255',
                function($attribute, $value, $fail) {
                    if (strpos($value, '、') !== false) {
                        return $fail('「子ポット並び順」に全角のカンマがあります。');
                    }
                    else {
                    	$nums = explode(',', $value);
                        foreach($nums as $num) {
                        	if(! is_numeric($num)) {
                            	return $fail('「子ポット並び順」に全角の数字があります。');
                            }
                        }
                    }
                }
            ],
            
            //'dg_id' => 'required',
            'dg_id' => [ //dgに送料が入力されていない時
            	'required',
                
                function($attribute, $value, $fail) {
                	$result = 1;
                    
            		$feeObjs = $this->dgRel->where(['dg_id'=>$value])->get();
                    
                    if($feeObjs->isEmpty()) {
                    	$result = 0;
                    }
                    else {
                        foreach($feeObjs as $obj) {
                            if($obj->fee === null || $obj->fee == '') {
                                $result = 0;
                                break;
                            }
                        }
                    }
                    
                	if(! $result) {
                		return $fail('「配送区分」の都道府県別送料が未入力です。配送区分マスターを確認して下さい。');
                    }
                },
            ],
            
            'factor' => 'required|numeric',
            
            'price' => 'required|numeric',
            'cost_price' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
            'stock' => 'nullable|numeric',
            'stock_reset_month' => [
                function($attribute, $value, $fail) use($request) {
                    if($value == '') {
                        if($request->input('stock_type') == 1) {
                            return $fail('「在庫入荷月」を指定して下さい。');
                        } 
                    }
                    elseif(! is_numeric($value)) {
                    	return $fail('「在庫入荷月」は半角数字を入力して下さい。');
                    }
                    elseif ($value < 1 || $value > 12) {
                        return $fail('「在庫入荷月」は正しい月を入力して下さい。');
                    }
                },
            ],
            'stock_reset_count' => 'nullable|numeric',
            'point_back' => 'nullable|numeric',
            
            'pot_parent_id' =>'required_with:is_potset|nullable|numeric',
            'pot_count' =>'required_with:is_potset|nullable|numeric',
            
            //'main_img' => 'filenaming',
        ];
        
        if($request->has('is_potset')) {
        	unset($rules['cate_id']);
        }
        
        $messages = [
         	'title.required' => '「商品名」を入力して下さい。',
            'cate_id.required' => '「カテゴリー」を選択して下さい。',
            
            //'post_thumb.filenaming' => '「サムネイル-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'post_movie.filenaming' => '「動画-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'slug.unique' => '「スラッグ」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all();
        
//        print_r($data['icons']);
//		echo implode(',', $data['icons']);
//        exit;
        
        //status
//        $data['open_status'] = isset($data['open_status']) ? 0 : 1;
//        $data['is_secret'] = isset($data['is_secret']) ? 1 : 0;
        
        //stock_show
        $data['is_ensure'] = isset($data['is_ensure']) ? 1 : 0;
        $data['is_delifee'] = isset($data['is_delifee']) ? 1 : 0;
        $data['stock_show'] = isset($data['stock_show']) ? 1 : 0;
        $data['farm_direct'] = isset($data['farm_direct']) ? 1 : 0;
        $data['is_once'] = isset($data['is_once']) ? 1 : 0;
        $data['is_once_recom'] = isset($data['is_once_recom']) ? 1 : 0;
        $data['is_delifee_table'] = isset($data['is_delifee_table']) ? 1 : 0;
        $data['is_potset'] = isset($data['is_potset']) ? 1 : 0;
        
        $data['icon_id'] = isset($data['icons']) ? implode(',', $data['icons']) : '';
        
        //上書き制御用データ
        $forceUp = isset($data['force_up']) ? 1 : 0;
        $data['admin_id'] = Auth::guard('admin')->id();
        
        //ポットセットの時、親にtrueをセットする->不要にした
//        if($data['is_potset']) {
//            $pItem = $this->item->find($data['pot_parent_id']);
//            
//            if(! $pItem->is_pot_parent) {
//            	$pItem->is_pot_parent = 1;
//            	$pItem->save();
//            }
//        }
        
        if($editId) { //update（編集）の時
            $status = '商品が更新されました！';
            $item = $this->item->find($editId);
            
            //上書き更新の制御 ------------
            if(! $forceUp) {
            	
                $isAdmin = 0;
                $errorStr = '他の管理者さんが、';
                
                if(isset($item->admin_id)) { //管理者が自分でないことを確認 自分の場合は上書き制限をかけない
                	$admin = $this->admin->find($item->admin_id);
                    
                    $errorStr = $admin->name . 'さんが、';
                    $isAdmin = $admin->id == $data['admin_id'];
                }
                
                if(! $isAdmin) { //前回更新が自分でなければ上書き制限をかける
                    $upDate = new DateTime($item->updated_at);
                    $nowDate = new DateTime();
                    
                    $diff = $nowDate->diff($upDate); //$nowDateにmodifyをした後だと狂うので先にdiffを取得しておく
                    //print_r($diff);
                    //exit;
                    
                    $rewriteTime = $this->setting->first()->rewrite_time;
                    $limitDate = $nowDate->modify('-'.$rewriteTime.' minutes'); // 制限時間のDate Objを取得
                    
                    //Timestamp比較で
                    if($limitDate->format('U') < $upDate->format('U')) { // or $limit->getTimestamp()

                        $minute = $diff->h ? ($diff->h * 60) + $diff->i : $diff->i; //差が1時間以上であれば分にして足す
                        
                        $errorStr .= $minute . '分前に更新しています。上書きする場合は「強制更新」をONにして更新して下さい。';
                        
                        return back()->withInput()->with('rewriteError', $errorStr);
                    }
                }
            }
            //上書き更新の制御 END ------------
            

            //stockChange save 新着情報用
            if($item->stock < $data['stock']) { //在庫が増えた時のみにしている 増えた時のみitemStockChangeにsave
//            	$this->itemSc->updateOrCreate( //データがなければ各種設定して作成
//                	['item_id'=>$item->id], 
//                    ['is_auto'=>0]
//                );
                
            	$itemSc = $this->itemSc->firstOrCreate( ['item_id'=>$item->id], ['is_auto'=>0]); //あれば取得、なければ作成
                $itemSc->updated_at = date('Y-m-d H:i:s', time()); 
                $itemSc->save();
            }
            
            $item->update($data); //Item更新
            
        }
        else { //新規追加の時
            $status = '商品が追加されました！';            
            //$item = $this->item;
            $item = $this->item->create($data); //Item作成
            
            //stockChange save 新着情報用
            $this->itemSc->create(['item_id'=>$item->id, 'is_auto'=>0]);
        }
        
        //potsetの時 parentのpot_parent_idに0をセットする
        if($item->is_potset) {
        	$parentItem = $this->item->find($item->pot_parent_id);
            
            if(isset($parentItem) && ! isset($parentItem->pot_parent_id)) {
            	$parentItem->pot_parent_id = 0;
            	$parentItem->save();
            }
        }
        
//        $item->fill($data);
//        $item->save();
        $itemId = $item->id;
        
        
        
//        print_r($data['main_img']);
//        exit;
        
        //Main-img
        if(isset($data['del_mainimg']) && $data['del_mainimg']) { //削除チェックの時
            if($item->main_img !== null && $item->main_img != '') {
                Storage::delete($item->main_img); //Storageはpublicフォルダのあるところをルートとしてみる
                $item->main_img = null;
                $item->save();
            }
        }
        else {
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
        }
        
        
        //SpareImg Save ==================================================
        foreach($data['spare_count'] as $count) {
                        
            if(isset($data['del_spare'][$count]) && $data['del_spare'][$count]) { //削除チェックの時
                
                $spareModel = $this->itemImg->where(['item_id'=>$itemId, 'type'=>1, 'number'=>$count+1])->first();
                
                if($spareModel !== null) {
                	Storage::delete('public/'. $spareModel->img_path); //Storageはpublicフォルダのあるところをルートとしてみる
                    $spareModel ->delete();
                }
            
            }
            else {
            	//キャプションのupが必ず必要なので、画像数データを全て作成する
                $spareImg = $this->itemImg->updateOrCreate(
                    ['item_id'=>$itemId, 'type'=>1, 'number'=>$count+1],
                    [
                        'item_id'=>$itemId,
                        'caption'=>$data['caption'][$count],
                        'type' => 1,
                        'number'=> $count+1,
                    ]
                );

                
            	if(isset($data['spare_thumb'][$count])) {
                    /*
                    $spareImg = $this->itemImg->updateOrCreate(
                        ['item_id'=>$itemId, 'type'=>1, 'number'=>$count+1],
                        [
                            'item_id'=>$itemId,
                            'caption'=>$data['caption'][$count],
                            'type' => 1,
                            'number'=> $count+1,
                        ]
                    );
                    */
                
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
        
        //Spareのナンバーを振り直す
        foreach($spares as $spare) {
            $spare->number = $num;
            $spare->save();
            $num++;
        }
        
        //Spare END ===========================================
        
        //Snap Save ==================================================
        foreach($data['snap_count'] as $count) {
        
			/*
               	type:1->item spare
               	type:2->item snap(contents)
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

        
//        print_r($data['tags']);
//        exit;
        
        //タグのsave動作
        if(isset($data['tags'])) {
            
            $tagArr = $data['tags'];
            
            //タグ削除の動作
            if(isset($editId)) { //編集時のみ削除されたタグを消す
            	//現在あるtagRelを取得
                $tagRelIds = $this->tagRelation->where('item_id', $itemId)->get()->map(function($tagRelObj){
                    return $tagRelObj->tag_id;
                })->all();
                
                //入力されたtagのidを取得（新規のものは取得されない->する必要がない）
                $tagIds = $this->tag->whereIn('name', $tagArr)->get()->map(function($tagObj){
                    return $tagObj->id;
                })->all();
                
                //配列同士を比較(重複しないものは$tagRelIdsからreturnされる->これらが削除対象となる)
                $tagDiffs = array_diff($tagRelIds, $tagIds);
                
                //削除対象となったものを削除する
                if(count($tagDiffs) > 0) {
                    foreach($tagDiffs as $valTagId) {
                        $this->tagRelation->where(['item_id'=>$itemId, 'tag_id'=>$valTagId])->first()->delete();
                    }
                }
            }
            
        	$num = 1;
            
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
                $this->tagRelation->updateOrCreate(
                    ['tag_id'=>$tagId, 'item_id'=>$itemId],
                    ['sort_num'=>$num]
                );

				$num++;
                
                //tagIdを配列に入れる　削除確認用
                //$tagIds[] = $tagId;
            }
        
        	/*
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
            */
        }
        else { 
        	if(isset($editId)) {
        		$tagRels = $this->tagRelation->where('item_id', $itemId)->delete();
            }
            
//            if(isset($tagRels)) {
//            	$tagRels
//            }
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

    
    
    
    
    public function edit($id)
    {
        return redirect('dashboard/items/'.$id);
    }

    
    public function getCsv()
    {
//    	try {
//        	return  new StreamedResponse(
//                function () {
        
//    	$res = fopen($this->csvFilePath, 'a');
//        // 文字コード変換
//        mb_convert_variables('sjis-win', 'UTF-8', $records);
//        // ファイルに書き出し
//        fputcsv($res, $records);
//        fclose($res);
        
        //$csv = Item::all(['id', 'title', 'price'])->toArray();
/*
//        $keys = [
//        	'id'=>'id',
//            'ステータス' =>'open_status',
//            '商品番号' =>'number',
//            '商品名' =>'title',
//            'キャッチコピー' =>'catchcopy',
//            'カテゴリー' =>'cate_id',
//            '子カテゴリー' =>'subcate_id',
//            '枯れ保証' =>'is_ensure',
//            //'main_img',
//            '価格(税抜)' =>'price',
//            '価格(税込)' =>'price_with_tax',
//            '仕入れ値' =>'cost_price',
//            '出荷元' =>'consignor_id',
//            '配送区分' =>'dg_id',
//            '送料無料' =>'is_delifee',
//            '同梱包' =>'is_once',
//            '係数' =>'factor',
//            '代金引換設定' =>'cod',
//            '産地直送' =>'farm_direct',
//            '在庫数' =>'stock',
//            '在庫数の表示' =>'stock_show',
//            'ポイント還元率(%)' =>'point_back',
//            'キャッチ説明' =>'exp_first',
//            //'explain',
//            //'is_delifee_table',
//            //'about_ship',
//            //'contents',
//            'メタタイトル' =>'meta_title',
//            'メタ詳細' =>'meta_description',
//            'メタキーワード' =>'meta_keyword',
//            //'open_date',
//            'View数' =>'view_count',
//            '売上個数' =>'sale_count',
//            '作成日' =>'created_at',
//            //'updated_at',
//        
//        ];
*/
        
        $vals = [
        	'id',
            'open_status',
            'number',
            'title',
            'catchcopy',
            'cate_id',
            'subcate_id',
            'is_ensure',
            //'main_img',
            'price',
            //'価格(税込)' =>'price_with_tax',
            'cost_price',
            'consignor_id',
            'dg_id',
            'is_delifee',
            'is_once',
            'factor',
            'cod',
            'farm_direct',
            'stock',
            'stock_show',
            'point_back',
            'exp_first',
            //'explain',
            //'is_delifee_table',
            //'about_ship',
            //'contents',
            'meta_title',
            'meta_description',
            'meta_keyword',
            //'open_date',
            'view_count',
            'sale_count',
            'created_at',
            //'updated_at',
        
        ];
        
        $keys = [
        	'id',
            'ステータス',
            '商品番号',
            '商品名',
            'キャッチコピー',
            'カテゴリー',
            '子カテゴリー',
            '枯れ保証',
            //'main_img',
            '価格(税抜)',
            //'価格(税込)' =>'price_with_tax',
            '仕入れ値',
            '出荷元',
            '配送区分',
            '送料無料',
            '同梱包',
            '係数',
            '代金引換設定',
            '産地直送',
            '在庫数',
            '在庫数の表示',
            'ポイント還元率(%)',
            'キャッチ説明',
            //'explain',
            //'is_delifee_table',
            //'about_ship',
            //'contents',
            'メタタイトル',
            'メタ詳細',
            'メタキーワード',
            //'open_date',
            'View数',
            '売上個数',
            '作成日',
            //'updated_at',
        
        ];

		$items = $this->item->all($vals)->toArray();
        array_splice($keys, 9, 0, '価格(税込)'); //追加項目 keyに追加
        
        $taxPer = $this->setting->get()->first()->tax_per;
        
        $alls = array();
        foreach($items as $item) {
			
            $item['cate_id'] = '';
            $item['subcate_id'] = '';
            $item['consignor_id'] = '';
            $item['dg_id'] = '';
            
            if(isset($item['cate_id']) && $item['cate_id'] != '') {
            	$item['cate_id'] = $this->category->find($item['cate_id'])->name;
            }
            
            if(isset($item['subcate_id']) && $item['subcate_id'] != '') {
            	$item['subcate_id'] = $this->categorySecond->find($item['subcate_id'])->name;
            }
            
            if(isset($item['consignor_id']) && $item['consignor_id'] != '') {
            	$item['consignor_id'] = $this->consignor->find($item['consignor_id'])->name;
            }
            
            if(isset($item['dg_id']) && $item['dg_id'] != '') {
            	$item['dg_id'] = $this->dg->find($item['dg_id'])->name;
            }
            
            $priceWithTax = $item['price'] + ($item['price'] * $taxPer/100);
            array_splice($item, 9, 0, $priceWithTax); //追加項目 key名は0になるが関係ないので
            
            $alls[] = $item;
//            print_r($item);
//        	exit;
        }
        
        array_unshift($alls, $keys); //先頭にヘッダー(key)を追加
        
//        $ret = mb_convert_variables(mb_internal_encoding(), "ASCII,UTF-8,SJIS-win", $alls);
//        echo $ret;
//        exit;
        
        //$items = $items->toArray();
//        print_r($alls);
//        exit;

		$fileName = 'gr-items_'. date('Ymd', time()) .'.csv';
        
        try {
        	return  new StreamedResponse(
                function () use($alls) {
            
                    //$csv = Item::all(['id', 'title', 'price'])->toArray();
                    
//                    $items = $this->item->all();
//                    $keys = array_keys($csv[0]);
//                    
//                    foreach($items as $item) {
//                    	$item->cate_id = $this->cate->find($item->cate_id)->name;
//                    }
//                    
//                    print_r($items);
//                    exit;

                    $stream = fopen('php://output', 'w');
                    
                    //mb_convert_variables('UTF-8', "ASCII,UTF-8,SJIS-win", $alls); 
                    //fputcsv($stream, $keys);
                    
                    foreach ($alls as $line) {
                        //mb_convert_variables('UTF-8', "ASCII,UTF-8,SJIS-win", $line);
                        fputcsv($stream, $line);
                    }
                    fclose($stream);
                },
                200,
                [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                ]
            );
        }
        catch (Exception  $e) {
              //DB::rollback();
              unlink($this->csvFilePath);
              throw $e;
              print_r($e);
              exit;
        }
        
    }
    
    
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
