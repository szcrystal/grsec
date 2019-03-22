<?php

namespace App\Http\Controllers\Main;

use App\Item;
use App\Category;
use App\CategorySecond;
use App\Tag;
use App\TagRelation;
use App\Fix;
use App\Setting;
use App\ItemImage;
use App\Favorite;
use App\ItemStockChange;
use App\TopSetting;
use App\DeliveryGroup;
use App\DeliveryGroupRelation;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Ctm;
use Cookie;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    public function __construct(Item $item, Category $category, CategorySecond $cateSec, Tag $tag, TagRelation $tagRel, Fix $fix, Setting $setting, ItemImage $itemImg, Favorite $favorite, ItemStockChange $itemSc, TopSetting $topSet, DeliveryGroup $dg, DeliveryGroupRelation $dgRel, Auth $auth)
    {
        //$this->middleware('search');
        
        $this->item = $item;
        $this->category = $category;
        $this->cateSec = $cateSec;
        $this->tag = $tag;
        $this->tagRel = $tagRel;
        $this->fix = $fix;

        $this->setting = $setting;
        $this->itemImg = $itemImg;
        $this->favorite = $favorite;
        $this->itemSc = $itemSc;
        $this->topSet = $topSet;
        
        $this->dg = $dg;
        $this->dgRel = $dgRel;
                
        //ここでAuth::check()は効かない
        $this->whereArr = ['open_status'=>1, 'is_potset'=>0]; //こことSingleとSearchとCtm::isPotParentAndStockにある
                
        $this->perPage = env('PER_PAGE', Ctm::isAgent('sp') ? 21 : 20);
        
        //$this->itemPerPage = 15;
    }
    
    public function index(Request $request)
    {
//        $request->session()->forget('item.data');
//        $request->session()->forget('all');

        $cates = $this->category->all();
        
        $whereArr = $this->whereArr;
        
        
//        $tagIds = TagRelation::where('item_id', 1)->get()->map(function($obj){
//            return $obj->tag_id;
//        })->all();
//        
//        $strs = implode(',', $tagIds);
        
//        $placeholder = '';
//        foreach ($tagIds as $key => $value) {
//           $placeholder .= ($key == 0) ? $value : ','.$value;
//        }
//        //exit;
//        
//    //    $strs = "FIELD(id, $strs)";
//    //    echo $strs;
//        //exit;
//        
//        //->orderByRaw("FIELD(id, $sortIDs)"
//        $tags = Tag::whereIn('id', $tagIds)->orderByRaw("FIELD(id, $placeholder)")->take(2)->get();
//        print_r($tags);
//        exit;
        
//        $stateObj = null;
//        //$stateName = '';
//        
//        if(isset($state)) {
//            $stateObj = $this->state->where('slug', $state)->get()->first();
//            $whereArr['state_id'] = $stateObj->id;
//            $whereArrSec['state_id'] = $stateObj->id;
//            //$stateName = $stateObj->name;
//        }

		//Carousel
        $caros = $this->itemImg->where(['item_id'=>9999, 'type'=>6])->inRandomOrder()->get();

		//FirstItem =======================
        $getNum = Ctm::isAgent('sp') ? 3 : 4;
		
        //New
        $newItems = null;
        
        $scIds = $this->itemSc->orderBy('updated_at','desc')->get()->map(function($isc){
        	return $isc->item_id;
        })->all();
        
        if(count($scIds) > 0) {
            $scIdStr = implode(',', $scIds);
            $newItems = $this->item->whereIn('id', $scIds)->where($whereArr)->orderByRaw("FIELD(id, $scIdStr)")->take($getNum)->get()->all();
        }
        
        //Ranking
        $rankItems = $this->item->where($whereArr)->orderBy('sale_count', 'desc')->take($getNum)->get()->all();
        
        //Recent 最近見た
        $cookieArr = array();
        $cookieItems = null;
        //$getNum = Ctm::isAgent('sp') ? 6 : 7;
        
        $cookieIds = Cookie::get('item_ids');
        
        if(isset($cookieIds) && $cookieIds != '') {
            $cookieArr = explode(',', $cookieIds); //orderByRowに渡すものはString
          	$cookieItems = $this->item->whereIn('id', $cookieArr)->where($whereArr)->orderByRaw("FIELD(id, $cookieIds)")->take($getNum)->get()->all();  
        }
        
        /*
        if(cache()->has('item_ids')) {
        	
        	$cacheIds = cache('item_ids');
            
            $caches = implode(',', $cacheIds); //orderByRowに渡すものはString
            
          	$cacheItems = $this->item->whereIn('id', $cacheIds)->where($whereArr)->orderByRaw("FIELD(id, $caches)")->take($getNum)->get()->all();  
        }
        */
        
        //array
        $firstItems = [
        	'新着情報'=> $newItems,
            '人気ランキング'=> $rankItems,
            '最近チェックしたアイテム'=> $cookieItems,
        ];
        //FirstItem END ================================
        
        
        //おすすめ情報 RecommendInfo (cate & cateSecond & tag)
        $tagRecoms = $this->tag->where(['is_top'=>1])->orderBy('updated_at', 'desc')->get()->all();
        $cateRecoms = $this->category->where(['is_top'=>1])->orderBy('updated_at', 'desc')->get()->all();
        $subCateRecoms = $this->cateSec->where(['is_top'=>1])->orderBy('updated_at', 'desc')->get()->all();
        
        $res = array_merge($tagRecoms, $cateRecoms, $subCateRecoms);
        
//        $books = array(
//        	$tagRecoms,
//            $cateRecoms,
//            $subCateRecoms
//        );
        
        $collection = collect($res);
        $allRecoms = $collection->sortByDesc('updated_at');
        
//        print_r($allRecoms);
//        exit;

        //$allRecoms = $this->item->where($whereArr)->orderBy('created_at', 'desc')->take(10)->get(); 

		//category
        $itemCates = array();
        foreach($cates as $cate) { //カテゴリー名をkeyとしてatclのかたまりを配列に入れる
        
            $whereArr['cate_id'] = $cate->id;
            
            $as = $this->item->where($whereArr)->orderBy('created_at','DESC')->take(8)->get()->all();
            
            if(count($as) > 0) {
                $itemCates[$cate->id] = $as;
            }
        }
        
//        $items = $this->item->where(['open_status'=>1])->orderBy('created_at','DESC')->get();
//        $items = $items->groupBy('cate_id')->toArray();

		//head news
        $setting = $this->topSet->get()->first();
        
		$newsCont = $setting->contents;
		
        $metaTitle = $setting->meta_title;
        $metaDesc = $setting->meta_description;
        $metaKeyword = $setting->meta_keyword;
        
        //For this is top
        $isTop = 1;
        

        return view('main.home.index', ['firstItems'=>$firstItems, 'allRecoms'=>$allRecoms, 'itemCates'=>$itemCates, 'cates'=>$cates, 'newsCont'=>$newsCont, 'metaTitle'=>$metaTitle, 'caros'=>$caros, 'metaDesc'=>$metaDesc, 'metaKeyword'=>$metaKeyword, 'isTop'=>$isTop,]);
    }
    
    
    //NewItem Ranking RecentCheck
    public function uniqueArchive(Request $request)
    {
    	$path = $request->path();
        
        $whereArr = $this->whereArr;
        
        $items = null;
        
        $orgItem = null;
        $title = '';
        
        if($path == 'new-items') {
        
            $scs = $this->itemSc->orderBy('updated_at','desc')/*->take(100)*/->get();
//            ->map(function($isc){
//                	return $isc->item_id;
//            })->all();
            
            $scIds = array();
            $n = 0;
            
            foreach($scs as $sc) {
            	if($n > 99) break;
                
            	$i = $this->item->whereIn('id', [$sc->item_id])->where($whereArr)->get();
                if($i->isNotEmpty()) {
                	$scIds[] = $sc->item_id;
                    $n++;
                }
            }
            
            if(count($scIds) > 0) {
            	//$scIds = array_slice($scIds, 0, 100);
                $scIdStr = implode(',', $scIds);
                $items = $this->item->whereIn('id', $scIds)/*->where($whereArr)*/->orderByRaw("FIELD(id, $scIdStr)")/*->take(100)*/->paginate($this->perPage); //paginateにtake()が効かない  
            }
            
            $title = '新着情報';
        }
        elseif($path == 'ranking') {
        	$rankItemIds = $this->item->where($whereArr)->orderBy('sale_count', 'desc')->limit(100)->get()->map(function($obj){
            	return $obj->id;
            })->all();
            
            $items= $this->item->whereIn('id', $rankItemIds)->orderBy('sale_count', 'desc')->paginate($this->perPage); //ここで更にorderByする必要がある
            //$items = $this->item->where($whereArr)->orderBy('sale_count', 'desc')->take(100)->paginate($this->perPage);
            
            $title = '人気ランキング';
        }
        elseif($path == 'recent-items') {
        	$cookieArr = array();
            
            $cookieIds = Cookie::get('item_ids');
        
        	if(isset($cookieIds) && $cookieIds != '') {
                $cookieArr = explode(',', $cookieIds); //orderByRowに渡すものはString
                $items = $this->item->whereIn('id', $cookieArr)->where($whereArr)->orderByRaw("FIELD(id, $cookieIds)")->paginate($this->perPage);  
            }
            
            /*
            if(cache()->has('item_ids')) {
                $cacheIds = cache('item_ids');
                $caches = implode(',', $cacheIds); //orderByRowに渡すものはString
                $items = $this->item->whereIn('id', $cacheIds)->where($whereArr)->orderByRaw("FIELD(id, $caches)")->paginate($this->perPage);  
            }
            */
            
            $title = '最近チェックしたアイテム';               
        }
        
        elseif($path == 'item/packing') { //同梱包可能商品レコメンド -> 同じ出荷元で同梱包可能なもの の一覧用
        	
            $orgId = $request->query('orgId');
            $orgItem = $this->item->find($orgId);
            
            if(isset($orgId) && isset($orgItem) && $orgItem->is_once) {
            	$whereArr = array_merge($whereArr, ['consignor_id'=>$orgItem->consignor_id, 'is_once'=>1, 'is_once_recom'=>0]);
            
                $items = $this->item->whereNotIn('id', [$orgItem->id])->where($whereArr)->orderBy('updated_at','desc')->paginate($this->perPage);

                //ページネーションのリンクにqueryをつける
                $items->appends(['orgId' => $orgId]);
                                
                $title = '"' . $orgItem->title . '" ' . 'と同梱包可能な商品';
            }
            else {
               abort(404); 
            }
 
        }
        
        $metaTitle = $title;
        $metaDesc = '';
        $metaKeyword = '';
        
        if(! isset($items)) {
        	abort(404);
        }
        
        return view('main.archive.index', ['items'=>$items, 'type'=>'unique', 'title'=>$title, 'metaTitle'=>$metaTitle, 'metaDesc'=>$metaDesc, 'metaKeyword'=>$metaKeyword, 'orgItem'=>$orgItem]);
 
    }
    
    
    
    //RecommendInfo : Cate/SubCate/Tag
    public function recomInfo(Request $request)
    {
    	$items = null;
        
        $path = $request->path();
        
    	if($path == 'recommend-info') {

        	$tagRecoms = $this->tag->where(['is_top'=>1])->orderBy('updated_at', 'desc')->get()->all();
            $cateRecoms = $this->category->where(['is_top'=>1])->orderBy('updated_at', 'desc')->get()->all();
            $subCateRecoms = $this->cateSec->where(['is_top'=>1])->orderBy('updated_at', 'desc')->get()->all();
            
            //$concat = $tagRecoms->concat($cateRecoms)->concat($cateRecoms);
            
//            $aaa = $tagRecoms->merge($cateRecoms);
//            $b = $aaa->paginate($this->perPage);
            
            
            $res = array_merge($tagRecoms, $cateRecoms, $subCateRecoms);
            
            $collection = collect($res);
            $sorts = $collection->sortByDesc('updated_at')->toArray();
            
            //Custom Pagination
            $perPage = $this->perPage;
            $total = count($sorts);
            $chunked = array();
            
            if($total) {
                $chunked = array_chunk($sorts, $perPage);
                $current_page = $request->page ? $request->page : 1;
                $chunked = $chunked[$current_page - 1]; //現在のページに該当する配列を$chunkedに入れる
            }
            
            $items = new LengthAwarePaginator($chunked, $total, $perPage); //pagination インスタンス作成
            $items -> setPath($path); //url pathセット
            //$allResults -> appends(['s' => $search]); //get url set
            //Custom pagination END
            
//            print_r($items);
//            exit;
            
            $title = 'おすすめ情報';
        }
        
        $metaTitle = $title;
        $metaDesc = '';
        $metaKeyword = '';
        
        return view('main.archive.recomInfo', ['items'=>$items, 'type'=>'unique', 'title'=>$title, 'metaTitle'=>$metaTitle, 'metaDesc'=>$metaDesc, 'metaKeyword'=>$metaKeyword,]);
    }
    
    
    
    
	//FIx Page =====================
    public function getFix(Request $request)
    {
        $path = $request->path();
        $fix = $this->fix->where('slug', $path)->first();
        
        if(!isset($fix)) {
            abort(404);
        }
        
        
        $title = $fix->title;
        $type = 'fix';
        
        $metaTitle = isset($fix->meta_title) ? $fix->meta_title : $title;
//        $metaDesc = $item->meta_description;
//        $metaKeyword = $item->meta_keyword;
        
        return view('main.home.fix', ['fix'=>$fix, 'metaTitle'=>$metaTitle, 'title'=>$title, 'type'=>$type]);
    }
    
    //Category ==============================
    //Parent
    public function category($slug)
    {
    	$cate = $this->category->where('slug', $slug)->first();
        
        $whereArr = $this->whereArr;
        
        if(!isset($cate)) {
            abort(404);
        }
        
        $itemObjs = $this->item->where($whereArr)->where(['cate_id'=>$cate->id])->get();
        
        //在庫有りなしでソートしたidを取得
        $stockIds = $this->getStockSepIds($itemObjs); //$itemObjsはコレクション

        //Controller内でないと下記のダブルクオーテーションで囲まないと効かない(tag.blade.phpに記載あり)
        $strs = implode(',', $stockIds); //$strs = '"'. implode('","', $stockIds) .'"';

        $items = $this->item->whereIn('id', $stockIds)->orderByRaw("FIELD(id, $strs)")->paginate($this->perPage);
        //$items = $this->item->where(['cate_id'=>$cate->id, 'open_status'=>1, 'is_potset'=>0])->orderBy('id', 'desc')->paginate($this->perPage);
        //$items = $this->cateSec->where(['parent_id'=>$cate->id, ])->orderBy('updated_at', 'desc')->paginate($this->perPage);
        
        //Upper取得
        $upperRelArr = Ctm::getUpperArr($cate->id, 'cate');
        
        //Meta
        $metaTitle = isset($cate->meta_title) ? $cate->meta_title : $cate->name;
        $metaDesc = $cate->meta_description;
        $metaKeyword = $cate->meta_keyword;
        
        $cate->timestamps = false;
        $cate->increment('view_count');
        
        return view('main.archive.index', ['items'=>$items, 'cate'=>$cate, 'type'=>'category', 'upperRelArr'=>$upperRelArr, 'metaTitle'=>$metaTitle, 'metaDesc'=>$metaDesc, 'metaKeyword'=>$metaKeyword,]);
    }
    
    
    //Sub Category Child
    public function subCategory($slug, $subSlug)
    {
    	$cate = $this->category->where('slug', $slug)->first();
        $subcate = $this->cateSec->where('slug', $subSlug)->first();
        
        $whereArr = $this->whereArr;
        
        if(!isset($cate) || !isset($subcate)) {
            abort(404);
        }
        
        //$whereArr['subcate_id'] = $subcate->id;
        $itemObjs = $this->item->where($whereArr)->where(['subcate_id'=>$subcate->id])->get();
        
        //在庫有りなしでソートしたidを取得
        $stockIds = $this->getStockSepIds($itemObjs); //$itemObjsはコレクション

        //Controller内でないと下記のダブルクオーテーションで囲まないと効かない(tag.blade.phpに記載あり)
        $strs = implode(',', $stockIds); //$strs = '"'. implode('","', $stockIds) .'"';

        $items = $this->item->whereIn('id', $stockIds)->orderByRaw("FIELD(id, $strs)")->paginate($this->perPage);
        //$items = $this->item->where(['subcate_id'=>$subcate->id, 'open_status'=>1, 'is_potset'=>0])->orderBy('id', 'desc')->paginate($this->perPage);
        
        //Upper取得
        $upperRelArr = Ctm::getUpperArr($subcate->id, 'subcate');
        
        //Meta
        $metaTitle = isset($subcate->meta_title) ? $subcate->meta_title : $subcate->name;
        $metaDesc = $subcate->meta_description;
        $metaKeyword = $subcate->meta_keyword;
        
        $subcate->timestamps = false;
        $subcate->increment('view_count');
        
        return view('main.archive.index', ['items'=>$items, 'cate'=>$cate, 'subcate'=>$subcate, 'type'=>'subcategory', 'upperRelArr'=>$upperRelArr, 'metaTitle'=>$metaTitle, 'metaDesc'=>$metaDesc, 'metaKeyword'=>$metaKeyword,]);
    }
    
    
    //Tag
    public function tag($slug)
    {
    	$tag = $this->tag->where('slug', $slug)->first();
        
        $whereArr = $this->whereArr;
        
        if(!isset($tag)) {
            abort(404);
        }
        
        $tagItemIds = $this->tagRel->where('tag_id',$tag->id)->get()->map(function($obj){
        	return $obj -> item_id;
        })->all();
        
        $itemObjs = $this->item->whereIn('id', $tagItemIds)->where($whereArr)->get();
        
        //在庫有りなしでソートしたidを取得
        $stockIds = $this->getStockSepIds($itemObjs); //$itemObjsはコレクション

        //orderByRaw用の文字列
        $strs = implode(',', $stockIds); //$strs = '"'. implode('","', $stockIds) .'"';

        $items = $this->item->whereIn('id', $stockIds)->orderByRaw("FIELD(id, $strs)")->paginate($this->perPage);
        //$items = $this->item->whereIn('id',$itemIds)->where(['open_status'=>1, 'is_potset'=>0])->orderBy('id', 'desc')->paginate($this->perPage);
        
        //Upper取得
        $upperRelArr = Ctm::getUpperArr($tag->id, 'tag');
        
        $metaTitle = isset($tag->meta_title) ? $tag->meta_title : $tag->name;
        $metaDesc = $tag->meta_description;
        $metaKeyword = $tag->meta_keyword;
        
        $tag->timestamps = false;
        $tag->increment('view_count');
        
        return view('main.archive.index', ['items'=>$items, 'tag'=>$tag, 'type'=>'tag', 'upperRelArr'=>$upperRelArr, 'metaTitle'=>$metaTitle, 'metaDesc'=>$metaDesc, 'metaKeyword'=>$metaKeyword,]);
    }
    
    
    private function getStockSepIds($itemObjs)
    {
        //ここで渡される$itemObjsはコレクションなので、以下記述がいつもと異なることに注意
        //$itemObjs = $itemObjs->where('open_status', 1)->where('is_potset', 0);とすることも可能
        
        //ORG : $whereArr = ['open_status'=>1, 'is_potset'=>0];
        //$stockTrues = $this->item->where($whereArr)->whereNotIn('stock', [0])->orderBy('id', 'desc')->get()->map(function($obj){
        
        $stockTrues = $itemObjs->whereNotIn('stock', [0])->sortByDesc('id')->map(function($obj){
        	return $obj->id;
        })->all();
                
        $stockFalses = $itemObjs->where('stock', 0)->sortByDesc('id')->map(function($objSec){
        	return $objSec->id;
        })->all();
        
        $stockIds = array_merge($stockTrues, $stockFalses);
        $potsStockFalses = array();
        
        //pot親の時にpotの子のstockを見る
        foreach($stockIds as $stockId) {
        	$switchArr = Ctm::isPotParentAndStock($stockId); //親ポットか、Stockあるか、その子ポットのObjsを取る
            
            //親ポットで子ポットの在庫が全て0の時
            if($switchArr['isPotParent'] && ! $switchArr['isStock']) {
            	$potsStockFalses[] = $stockId;
            }
/*        	
//            $pots = $this->item->where(['is_potset'=>1, 'pot_parent_id'=>$stockId])->get();
//            
//            if($pots->isNotEmpty()) {
//            	$switch = 0;
//            	foreach($pots as $pot) {
//                	if($pot->stock) {
//                    	$switch = 1;
//                    	break;
//                    }
//                }
//                
//                if(! $switch) {
//                	$potsStockFalses[] = $stockId;
//                }
//            }
*/
        }
        
        //potSetの親はstockTrue,stockFalseどちらにも入る可能性があるので両方から重複idを取り除く
        $stockTrues = array_diff($stockTrues, $potsStockFalses); //stockTrueから重複IDを削除
        $stockFalses = array_diff($stockFalses, $potsStockFalses); //stockFalseから重複IDを削除
        
        $stockFalses = array_merge($stockFalses, $potsStockFalses); //stockFalseにmergeして、その中でsortする
        rsort($stockFalses); //降順 3,2,1,
        
        return array_merge($stockTrues, $stockFalses); //重複を削除したstockTrueとstockFalseをmergeする
        
    }
    
    
    //送料区分別 送料表のページ
    public function showDeliFeeTable($dgId)
    {
    	$dg = $this->dg->find($dgId);
        
        if(! isset($dg) || $dg->table_name == '' ) {
            abort(404);
        }
        
    	$dgRel = $this->dgRel->where('dg_id', $dgId)->get();
        
        return view('main.home.deliFee', ['dg'=>$dg, 'dgRel'=>$dgRel, 'dgId'=>$dgId ]);
        
    }
    
    
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

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
