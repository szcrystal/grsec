<?php

namespace App\Http\Controllers\Main;

use App\Item;
use App\Category;
use App\CategorySecond;
use App\Tag;
use App\TagRelation;
use App\ItemImage;
use App\Favorite;
use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

use Auth;
use Ctm;

class SingleController extends Controller
{
    public function __construct(Item $item, Category $category, CategorySecond $subCate, Tag $tag, TagRelation $tagRel, ItemImage $itemImg, Favorite $favorite, User $user)
    {
        //$this->middleware('search');
        
        $this->item = $item;
        $this->category = $category;
        $this->subCate = $subCate;
        $this->tag = $tag;
        $this->tagRel = $tagRel;
        $this->itemImg = $itemImg;
        $this->favorite = $favorite;
        $this->user = $user;
//        $this->tag = $tag;
//        $this->tagRelation = $tagRelation;
//        $this->tagGroup = $tagGroup;
//        $this->category = $category;
//        $this->item = $item;
//        $this->fix = $fix;
//        $this->totalize = $totalize;
//        $this->totalizeAll = $totalizeAll;
        
        //$this->perPage = env('PER_PAGE', 21);
        $this->itemPerPage = 15;
        
    }
    
    public function index($id)
    {
        $item = $this->item->find($id);
        
        if(!isset($item)) {
            abort(404);
        }
        else {
            if($item->is_potset || ! $item->open_status)
            	abort(404);
        }
        
        $cate = $this->category->find($item->cate_id);
        $subCate = $this->subCate->find($item->subcate_id);
        
        $whereArr = ['open_status'=>1, 'is_potset'=>0];
        
        //ポットセットがある場合
        $potSets = $this->item->where(['open_status'=>1, 'pot_parent_id'=>$item->id])->orderBy('pot_count', 'asc')->get();
        
        
        //Other Atcl
        $otherItem = $this->item->where($whereArr)->whereNotIn('id', [$id])->orderBy('created_at','DESC')->take(5)->get();
        
        //Tag
        $tags = null;
        $tagRels = array();
        $sortIDs = array();
        
        $tagRels = $this->tagRel->where('item_id', $item->id)->orderBy('id','asc')->get()->map(function($obj){
            return $obj->tag_id;
        })->all();
        
        if(count($tagRels) > 0) {
			$sortIDs = implode(',', $tagRels);
        	$tags = $this->tag->whereIn('id', $tagRels)->orderByRaw("FIELD(id, $sortIDs)")->get();
        }
        
        //商品画像
        $imgsPri = $this->itemImg->where(['item_id'=>$id, 'type'=>1])->orderBy('number', 'asc')->get();
        //セカンド画像
        $imgsSec = $this->itemImg->where(['item_id'=>$id, 'type'=>2])->orderBy('number', 'asc')->get();
        
        
        //お気に入り確認
        $isFav = 0;
        if(Auth::check()) {
	        $fav = $this->favorite->where(['user_id'=>Auth::id(), 'item_id'=>$id])->first();
        	
            if(isset($fav)) $isFav = 1;   
        }
        
        //View Count
        $item->timestamps = false;
        $item->increment('view_count');
        
        //レコメンド ===========================
        //同梱包可能商品レコメンド -> 同じ出荷元で同梱包可能なもの
        $isOnceItems = null;
        $getNum = Ctm::isAgent('sp') ? 6 : 6;
        $chunkNum = $getNum/2;
        
        if($item->is_once) {
        	$isOnceItems = $this->item->whereNotIn('id', [$item->id])->where(['consignor_id'=>$item->consignor_id, 'is_once'=>1, 'is_once_recom'=>0, 'open_status'=>1, 'is_potset'=>0])->inRandomOrder()->take($getNum)->get()->chunk($chunkNum);
            //->inRandomOrder()->take()->get() もあり クエリビルダに記載あり
        }
        
        // レコメンド：同カテゴリー
        $recomCateItems = $this->item->whereNotIn('id', [$item->id])->where(['cate_id'=>$item->cate_id, 'open_status'=>1, 'is_potset'=>0])->inRandomOrder()->take($getNum)->get()->chunk($chunkNum);
        
        // レコメンド：同カテゴリーのランキング
        $recomCateRankItems = $this->item->whereNotIn('id', [$item->id])->where(['cate_id'=>$item->cate_id, 'open_status'=>1, 'is_potset'=>0])->orderBy('view_count', 'desc')->take($getNum)->get()->chunk($chunkNum);
        
        
        //Recommend レコメンド 先頭タグと同じものをレコメンド ==============
        $recommends = null;
        //$getNum = Ctm::isAgent('sp') ? 3 : 3;
        
        if(isset($tagRels[1])) {
        	$ar = [$tagRels[1]];
            
            if(isset($tagRels[2])) {
            	$ar[] = $tagRels[2];
            }
            
            if(isset($tagRels[3])) {
            	$ar[] = $tagRels[3];
            }
            
        	$idWithTag = $this->tagRel->whereIn('tag_id', $ar)->get()->map(function($obj){
            	return $obj->item_id;
            })->all(); 
            
//            $tempIds = $idWithTag;
//            $tempIds[] = $item->id;
            
            $idWithCate = $this->item/*->whereNotIn('id', $tempIds)*/->where('subcate_id', $item->subcate_id)->get()->map(function($obj){
            	return $obj->id;
            })->all();
            
            $res = array_merge($idWithTag, $idWithCate);
            $res = array_unique($res); //重複要素を削除
            
			//shuffle($res);
            //$res = array_rand($res, 5);
//            print_r($res);
//            exit;
            
            $recommends = $this->item->whereNotIn('id', [$item->id])->whereIn('id', $res)->where($whereArr)->inRandomOrder()->take($getNum)->get()->chunk($chunkNum);
            //->inRandomOrder()->take()->get() もあり クエリビルダに記載あり
        }
        else {
        	$recommends = $this->item->whereNotIn('id', [$item->id])->where(['subcate_id'=>$item->subcate_id, 'open_status'=>1, 'is_potset'=>0])->inRandomOrder()->take($getNum)->get();
            //->inRandomOrder()->take()->get() もあり クエリビルダに記載あり
        }
        
//        print_r($recommends);
//        exit;

		$recomArr = [
        	'同梱包可能なおすすめ商品' => $isOnceItems,
            'この商品を見た人におすすめの商品' => $recomCateItems,
            'カテゴリーランキング' => $recomCateRankItems,
            '他にもこんな商品が買われています' => $recommends,
        ];
        
        
        //Cache 最近見た ===================
        $cacheIds = array();
        $cacheItems = null;
        $getNum = Ctm::isAgent('sp') ? 8 : 8;
        
        //cache()->forget('cacheIds');
        
        if(cache()->has('cacheIds')) {
        	
        	$cacheIds = cache('cacheIds'); //pullで元キャッシュを一旦削除する必要がある
            $caches = implode(',', $cacheIds); //順を逆にする
            
            $chunkNum = Ctm::isAgent('sp') ? $getNum/2 : $getNum;
          	
            $cacheItems = $this->item->whereIn('id', $cacheIds)->whereNotIn('id', [$item->id])->where($whereArr)->orderByRaw("FIELD(id, $caches)")->take($getNum)->get()->chunk($chunkNum);
            
//            print_r($cacheItems);
//            exit;  
        }
        
        if(! in_array($item->id, $cacheIds)) { //配列にidがない時 or cachIdsが空の時
        	$count = array_unshift($cacheIds, $item->id); //配列の最初に追加
         	
          	if($count > 16) {
            	$cacheIds = array_slice($cacheIds, 0, 15); //16個分を切り取る
        	}      
        }
        else { //配列にidがある時  
        	//print_r($cacheIds);   
                   
        	$index = array_search($item->id, $cacheIds); //key取得
            
            //$split = array_splice($cacheIds, $index, 1); //keyからその要素を削除
            unset($cacheIds[$index]);
            $cacheIds = array_values($cacheIds);
//            print_r($cacheIds);
//            
//            cache()->forget('cacheIds');
//            cache(['cacheIds'=>$cacheIds], env('CACHE_TIME', 360));
//            print_r(cache('cacheIds'));

            //exit;
            
        	$count = array_unshift($cacheIds, $item->id); //配列の最初に追加
        }

		cache()->forget('cacheIds');
        cache(['cacheIds'=>$cacheIds], env('CACHE_TIME', 360)); //putのはず? 上書きではなく後ろに追加されている
        
//        print_r(cache('cacheIds'));
//        exit;
		
        $metaTitle = isset($item->meta_title) ? $item->meta_title : $item->title;
        $metaDesc = $item->meta_description;
        $metaKeyword = $item->meta_keyword;
        
        
        return view('main.home.single', ['item'=>$item, 'potSets'=>$potSets, 'otherItem'=>$otherItem, 'cate'=>$cate, 'subCate'=>$subCate, 'tags'=>$tags, 'imgsPri'=>$imgsPri, 'imgsSec'=>$imgsSec, 'isFav'=>$isFav, 'recomArr'=>$recomArr, 'cacheItems'=>$cacheItems, 'recommends'=>$recommends, 'metaTitle'=>$metaTitle, 'metaDesc'=>$metaDesc, 'metaKeyword'=>$metaKeyword, 'type'=>'single']);
    }
    
    
    public function postForm(Request $request)
    {
    	$data = $request->all();
     
     	$buyItem = $this->item->find($data['item_id']);
      
         
        return view('main.cart.index', ['data'=>$data ]);
    }
    
    
    public function postCart(Request $request)
    {
    	$data = $request->all();
     
        $buyItem = $this->item->find($data['item_id']);
        
//        $per = env('TAX_PER');
//        $per = $per/100;
//        
//        $tax = floor($item->price * $per);
//        $price = $item->price + $tax;
     	
      	//$title = $this->item->find($data['item_id'])->title;   
      //ここでsessionに入れる必要がある
         
    	
        return view('main.cart.single', ['buyItem'=>$buyItem, 'tax'=>$data['tax'], 'count'=>$data['count'], 'name'=>$data['name'] ]); 
        
    }
    
    //お気に入り ajax
    public function postScript(Request $request)
    {
        $itemId = $request->input('itemId');
        $isOn = $request->input('isOn');
        
        $user = $this->user->find(Auth::id());
        $str = '';
        
		//Favorite Save ==================================================
        //foreach($data['spare_count'] as $count) {
                        
            if(!$isOn) { //お気に入り解除の時
                $favModel = $this->favorite->where(['user_id'=>$user->id, 'item_id'=>$itemId])->first();
                
                if($favModel !== null) {
                    $favModel ->delete();
                }
                
                $str = "お気に入りから削除されました";
            }
            else {
                    
                $favModel = $this->favorite->updateOrCreate(
                    ['user_id'=>$user->id, 'item_id'=>$itemId],
                    [
                        'user_id'=>$user->id,
                        'item_id'=>$itemId,
//                            'type' => 1,
//                            'number'=> $count+1,
                    ]
                );
				
    			$str = "お気に入りに登録されました";       
            }
            
        //} //foreach
        
//        $num = 1;
//        $spares = $this->itemImg->where(['item_id'=>$itemId, 'type'=>1])->get();
        
        //Snapのナンバーを振り直す
//        foreach($spares as $spare) {
//            $spare->number = $num;
//            $spare->save();
//            $num++;
//        }
        

        return response()->json(['str'=>$str]/*, 200*/); //200を指定も出来るが自動で200が返される  
          //return view('dashboard.script.index', ['val'=>$val]);
        //return response()->json(array('subCates'=> $subCates)/*, 200*/);
    }
    
    public function endCart()
    {
    	return view('main.cart.end');
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
