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
use App\FavoriteCookie;

use App\ItemUpper;
use App\ItemUpperRelation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

use Auth;
use Ctm;
use Cookie;
use DateTime;

class SingleController extends Controller
{
    public function __construct(Item $item, Category $category, CategorySecond $subCate, Tag $tag, TagRelation $tagRel, ItemImage $itemImg, Favorite $favorite, User $user, ItemUpper $itemUpper, ItemUpperRelation $itemUpperRel, FavoriteCookie $favCookie)
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
        
        $this->upper = $itemUpper;
        $this->upperRel = $itemUpperRel;
        $this->favCookie = $favCookie;
//        $this->tag = $tag;
//        $this->tagRelation = $tagRelation;
//        $this->tagGroup = $tagGroup;
//        $this->category = $category;
//        $this->item = $item;
//        $this->fix = $fix;
//        $this->totalize = $totalize;
//        $this->totalizeAll = $totalizeAll;
        
        $this->whereArr = ['open_status'=>1, 'is_potset'=>0]; //こことSingleとSearchとCtm::isPotParentAndStockにある
        
        $this->itemPerPage = 15;
        
    }
    
    public function index($id)
    {
        $item = $this->item->find($id);
        
        $whereArr = $this->whereArr;
        
        if(!isset($item)) {
            abort(404);
        }
        else {
            if($item->is_potset || ! $item->open_status) // || $item->is_secret
            	abort(404);
        }
        
        $cate = $this->category->find($item->cate_id);
        $subCate = $this->subCate->find($item->subcate_id);
        

        //ポットセットがある場合
        $potWhere = ['open_status'=>1, 'is_potset'=>1, 'pot_parent_id'=>$item->id];
        
        if(isset($item->pot_sort) && $item->pot_sort != '') {
        	$potSorts = $item->pot_sort;
        	$potSets = $this->item->where($potWhere)->orderByRaw("FIELD(id, $potSorts)")->get();
        }
        else {
        	$potSets = $this->item->where($potWhere)->orderBy('pot_count', 'asc')->get();
        }
        
        //Other Atcl
        $otherItem = $this->item->where($whereArr)->whereNotIn('id', [$id])->orderBy('created_at','DESC')->take(5)->get();
        
        //Tag
        $tags = null;
        $tagRels = array();
        $sortIDs = array();
        
        $tagRels = $this->tagRel->where('item_id', $item->id)->orderBy('sort_num','asc')->get()->map(function($obj){
            return $obj->tag_id;
        })->all();
        
        if(count($tagRels) > 0) { //tagのget ->main.shared.tagの中でも指定しているのでここでは不要だが入れておく
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
        else { //Cookie確認
        	$favKey = Cookie::get('fav_key');
//        echo $favKey;
//        exit;
			$favCookie = $this->favCookie->where(['key'=>$favKey, 'item_id'=>$item->id])->first();
            
            if(isset($favCookie)) $isFav = 1;
        }
        
        //View Count
        $item->timestamps = false;
        $item->increment('view_count');
        
        //レコメンド ===========================
        //同梱包可能商品レコメンド -> 同じ出荷元で同梱包可能なもの
        $isOnceItems = null;
        $recomCateItems = null;
        $recomCateRankItems = null;
        $recommends = null;
        
        $getNum = Ctm::isAgent('sp') ? 6 : 6;
        $chunkNum = $getNum/2;
        
        //在庫がないIDを取得する 以下のwhereNotInで使用する ===========
        $noStockIds = $this->item->whereNotIn('id', [$item->id])->where($whereArr)->get()->map(function($obj) {
            $switchArr = Ctm::isPotParentAndStock($obj->id); //親ポットか、Stockあるか、その子ポットのObjsを取る。$switchArr['isPotParent'] ! $switchArr['isStock']
            if($switchArr['isPotParent']) {
                if(! $switchArr['isStock'])
                    return $obj->id;
            }
            else {
                if(! $obj->stock)
                    return $obj->id;
            }
        })->all();
    
        $noStockIds = array_filter($noStockIds);
        $noStockIds[] = $item->id;
        //在庫がないID END ===========
        
        if($item->is_once) {
        	$isOnceItems = $this->item->whereNotIn('id', $noStockIds)->where($whereArr)->where(['consignor_id'=>$item->consignor_id, 'is_once'=>1, 'is_once_recom'=>0])->inRandomOrder()->take($getNum)->get()->chunk($chunkNum);
            //->inRandomOrder()->take()->get() もあり クエリビルダに記載あり
        }
        
        // レコメンド：同カテゴリー 植木庭木の時のみsubcateに合わせる
        $cateArr = ($item->cate_id == 1) ? ['subcate_id' => $item->subcate_id] : ['cate_id' => $item->cate_id];
                
        $recomCateItems = $this->item->whereNotIn('id', $noStockIds)->where($whereArr)->where($cateArr)->inRandomOrder()->take($getNum)->get()->chunk($chunkNum);
        
        // レコメンド：同カテゴリーのランキング
        $recomCateRankItems = $this->item->whereNotIn('id', $noStockIds)->where($whereArr)->where($cateArr)->orderBy('view_count', 'desc')->take($getNum)->get()->chunk($chunkNum);
        
        
        //Recommend レコメンド 先頭タグと同じものをレコメンド ==============
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
            
            $recommends = $this->item->whereNotIn('id', $noStockIds)->whereIn('id', $res)->where($whereArr)->inRandomOrder()->take($getNum)->get()->chunk($chunkNum);
            //->inRandomOrder()->take()->get() もあり クエリビルダに記載あり
        }
        else {
        	$recommends = $this->item->whereNotIn('id', $noStockIds)->where($whereArr)->where(['subcate_id'=>$item->subcate_id])->inRandomOrder()->take($getNum)->get()->chunk($chunkNum);
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
        $cookieArr = array();
        $cacheItems = null;
        $getNum = Ctm::isAgent('sp') ? 8 : 8;
        
        
        $cookieIds = Cookie::get('item_ids');
//        echo $cookieIds;
//        exit;
        
        if(isset($cookieIds) && $cookieIds != '') {
	        $cookieArr = explode(',', $cookieIds); 
            
	        $chunkNum = Ctm::isAgent('sp') ? $getNum/2 : $getNum;
          	
	        $cacheItems = $this->item->whereIn('id', $cookieArr)->whereNotIn('id', [$item->id])->where($whereArr)->orderByRaw("FIELD(id, $cookieIds)")->take($getNum)->get()->chunk($chunkNum);
		}
        
        if(! in_array($item->id, $cookieArr)) { //配列にidがない時 or cachIdsが空の時
        	$count = array_unshift($cookieArr, $item->id); //配列の最初に追加
         	
          	if($count > 16) {
            	$cookieArr = array_slice($cookieArr, 0, 16); //16個分を切り取る
        	} 
        }
        else { //配列にidがある時 
        	$index = array_search($item->id, $cookieArr); //key取得
            
            //$split = array_splice($cacheIds, $index, 1); //keyからその要素を削除
            unset($cookieArr[$index]);
            $cookieArr = array_values($cookieArr);
            
        	$count = array_unshift($cookieArr, $item->id); //配列の最初に追加
        }
        
        $cookieIds = implode(',', $cookieArr);
        
        Cookie::queue(Cookie::make('item_ids', $cookieIds, env('COOKIE_TIME', 43200) ));
        
        
        /*
        if(cache()->has('item_ids')) {
        	
        	$cacheIds = cache()->pull('item_ids'); //pullで元キャッシュを一旦削除する必要がある
            $caches = implode(',', $cacheIds); //順を逆にする
            
            $chunkNum = Ctm::isAgent('sp') ? $getNum/2 : $getNum;
          	
            $cacheItems = $this->item->whereIn('id', $cacheIds)->whereNotIn('id', [$item->id])->where($whereArr)->orderByRaw("FIELD(id, $caches)")->take($getNum)->get()->chunk($chunkNum);
            
//            print_r($cacheItems);
//            exit;  
        }
        
        if(! in_array($item->id, $cacheIds)) { //配列にidがない時 or cachIdsが空の時
        	$count = array_unshift($cacheIds, $item->id); //配列の最初に追加
         	
          	if($count > 16) {
            	$cacheIds = array_slice($cacheIds, 0, 16); //16個分を切り取る
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

		cache()->forget('item_ids');
        cache(['item_ids'=>$cacheIds], env('CACHE_TIME', 43200)); //put 上書きではなく後ろに追加されている
        */


		//ItemUpper
//        $upperRels = null;
//        $upperRelArr = array();
//        $upper = $this->upper->where(['parent_id'=>$id, 'type_code'=>'item', 'open_status'=>1])->first();
//		
//        if(isset($upper)) {
//        	$upperRels = $this->upperRel->where(['upper_id'=>$upper->id, ])->orderBy('sort_num', 'asc')->get();
//            
//            if($upperRels->isNotEmpty()) {
//            	foreach($upperRels as $upperRel) {
//                	if($upperRel->is_section) {
//                    	$upperRelArr[$upperRel->block]['section'] = $upperRel;
//                    }
//                    else {
//                    	$upperRelArr[$upperRel->block]['block'][] = $upperRel;
//                    }
//                }
//            }
//        }
        
        $upperRelArr = Ctm::getUpperArr($id, 'item');
        
//        print_r($upperRelArr);
//        exit;

		
        $metaTitle = isset($item->meta_title) ? $item->meta_title : $item->title;
        $metaDesc = $item->meta_description;
        $metaKeyword = $item->meta_keyword;
        
        
        return view('main.home.single', ['item'=>$item, 'potSets'=>$potSets, 'otherItem'=>$otherItem, 'cate'=>$cate, 'subCate'=>$subCate, 'tags'=>$tags, 'imgsPri'=>$imgsPri, 'imgsSec'=>$imgsSec, 'isFav'=>$isFav, 'recomArr'=>$recomArr, 'cacheItems'=>$cacheItems, 'recommends'=>$recommends, 'upperRelArr'=>$upperRelArr, 'metaTitle'=>$metaTitle, 'metaDesc'=>$metaDesc, 'metaKeyword'=>$metaKeyword, 'type'=>'single']);
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
    
    
    public function favIndex()
    {
    	if(Auth::check()) {
        	return redirect('mypage/favorite');
        }
        
    	$items = null;
        $getNum = Ctm::isAgent('sp') ? 8 : 8;
        
        $favKey = Cookie::get('fav_key');
        
        if(isset($favKey)) {
        	Cookie::queue(Cookie::make('fav_key', $favKey, env('FAV_COOKIE_TIME', 129600) )); //分指定 3ヶ月 2month->86400 このfavIndxを開いた時に更新する
        }
//        }
//        else {
//            $favKey = Ctm::getOrderNum(30);
//            Cookie::queue(Cookie::make('fav_key', $favKey, env('FAV_COOKIE_TIME', 86400) )); //分指定 2ヶ月
//        }
        
//        echo $favKey;
//        exit;
        
        $itemIds = $this->favCookie->where(['key'=>$favKey])->orderBy('created_at', 'desc')->get()->map(function($obj){
        	return $obj->item_id;
        })->all();
        
        $itemIdStr = implode(',', $itemIds);
        
        if(count($itemIds)) {
            
	        $chunkNum = Ctm::isAgent('sp') ? $getNum/2 : $getNum;
          	
	        $items = $this->item->whereIn('id', $itemIds)->where($this->whereArr)->orderByRaw("FIELD(id, $itemIdStr)")->paginate(20);
            //->orderByRaw("FIELD(id, $cookieIds)")->take($getNum)->get()->chunk($chunkNum);
            
            foreach($items as $item) {
            	$fav = $this->favCookie->where(['key'=>$favKey, 'item_id'=>$item->id])->first();
                
                $item->fav_id = $fav->id;
            	$item->fav_created_at = $fav->created_at;
            }
            
		} 
       
//       	foreach($items as $item) {
//        	$fav = $this->favorite->where(['user_id'=>$user->id, 'item_id'=>$item->id])->first();
//            
//         	if($fav->sale_id) {
//          		$item->saleDate = $this->sale->find($fav->sale_id)->created_at;
//          	}
//            else {
//            	$item->saleDate = 0;
//            }       
//        	//$item->saled = 1;
//        }      
       
       	$metaTitle = 'お気に入り一覧' . '｜植木買うならグリーンロケット';
        $metaDesc = '';
        $metaKeyword = '';
      
        return view('mypage.favorite', ['items'=>$items, 'metaTitle'=>$metaTitle]); 
    
    }
    
    //fav一覧からのfav delete
    public function postFavDel(Request $request)
    {
    	$favDelId = $request->input('fav_del_id');
        
        if(Auth::check()) {
        	$this->favorite->destroy($favDelId);
            $redirectUrl = 'mypage/favorite';
        }
        else {
        	$this->favCookie->destroy($favDelId);
            $redirectUrl = 'favorite';
        }
        
        
        return redirect($redirectUrl);
 
    }
    
    
    //お気に入り ajax
    public function postScript(Request $request)
    {
        $itemId = $request->input('itemId');
        $isOn = $request->input('isOn');
        
        
        if(Auth::check()) {
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
                $this->favorite->create([
                    'user_id'=>$user->id,
                    'item_id'=>$itemId,
                ]);
                
                $str = "お気に入りに登録されました";       
            }
                
            //} //foreach
            // Favorite END ========================================================
        }
        else {
            //Cookie お気に入り DB ===================
            
            if(Cookie::has('fav_key')) {
            	$favKey = Cookie::get('fav_key');
            }
            else {
                $favKey = Ctm::getOrderNum(30);
            }
            
			Cookie::queue(Cookie::make('fav_key', $favKey, env('FAV_COOKIE_TIME', 129600) )); //分指定 3ヶ月 2month->86400　ここの操作後に2ヶ月更新するようにしている 
            
            if(! $isOn) { //お気に入り解除の時
            	$favModel = $this->favCookie->where(['key'=>$favKey, 'item_id'=>$itemId])->first();
                
                if($favModel !== null) 
                    $favModel->delete();
                
                $str = "お気に入りから削除されました";
            }
            else {
                $this->favCookie->create([
                    'key'=> $favKey,
                    'item_id'=> $itemId,
                    'type'=> 'favorite',
                    
                ]);
                
                $str = "お気に入りに登録されました"; 
            }
        
        }
        

        return response()->json(['str'=>$str]/*, 200*/); //200を指定も出来るが自動で200が返される  
          //return view('dashboard.script.index', ['val'=>$val]);
        //return response()->json(array('subCates'=> $subCates)/*, 200*/);
    }
    
    public function endCart()
    {
    	return view('main.cart.end');
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
