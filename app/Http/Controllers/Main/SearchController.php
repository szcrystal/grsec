<?php

namespace App\Http\Controllers\Main;

use App\Item;
use App\User;
use App\Tag;
use App\TagRelation;
use App\Category;

use Ctm;
use DB;
use Schema;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function __construct(Item $item, User $user, Tag $tag, TagRelation $tagRelation, Category $category)
    {
        //$this->middleware('search');
        
        $this->item = $item;
        $this->user = $user;
        $this->tag = $tag;
        $this->tagRelation = $tagRelation;
        //$this->tagGroup = $tagGroup;
        $this->category = $category;
        
        $this->whereArr = ['open_status'=>1, 'is_secret'=>0, 'is_potset'=>0]; //こことSingleとSearchとCtm::isPotParentAndStockにある
        
        $this->perPage = env('PER_PAGE', Ctm::isAgent('sp') ? 21 : 20);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchs = $request->s;
        //exit();
        
        $whereArr = $this->whereArr;
        
        $objs = $this->returnSearchObj($searchs);
        extract($objs); //$allResultはコレクション->all()で配列になっている -> 該当するIDを配列で取得に変更
        
        /*
        //Custom Pagination
        $perPage = $this->perPage;
        $total = count($allResults);
        $chunked = array();
        
        if($total) {
            $chunked = array_chunk($allResults, $perPage);
            $current_page = $request->page ? $request->page : 1;
            $chunked = $chunked[$current_page - 1]; //現在のページに該当する配列を$chunkedに入れる
        }
        
        $allResults = new LengthAwarePaginator($chunked, $total, $perPage); //pagination インスタンス作成
        $allResults -> setPath('search'); //url pathセット
        $allResults -> appends(['s' => $search]); //get url set
        //Custom pagination END
        */
        
        $allResults = $this->item->whereIn('id', $allResIds)->where($whereArr)->orderBy('created_at','DESC')->paginate($this->perPage);
        
//        $allResults = $this->item->whereIn('id', $allResIds)->where(['open_status'=>1, 'is_potset'=>0
//            //['open_status', '=', 1], ['del_status', '=', 0], ['owner_id', '>', 0]
//        ])->orderBy('created_at','DESC')->paginate($this->perPage);
        
        //Sidebar
//        $rankName = '全体';
//        $rightRanks = Ctm::getArgForView('', 'all');
        //extract($arg);
        
        //$groupModel = $this->tagGroup;
        
        return view('main.archive.index', ['items'=>$allResults, 'searchStr' => $search, 'type'=>'search'/*, 'rightRanks'=>$rightRanks, 'rankName'=>$rankName*/]);
    }
    
    
    //検索関数 on private
    private function returnSearchObj($search)
    {
        //全角スペース時半角スペースに置き換える
        if( str_contains($search, '　')) {
            $search = str_replace('　', ' ', $search);
        }
    
        //article
        //category
        $table_name = 'tags';
        
        //query取得
        $query = DB::table($table_name);
        
        
        //検索queryをカラムごとに繰り返すメイン関数
        function queryWhere($array, $qry, $word) {
            foreach($array as $column) {
                if($column != 'created_at' && $column != 'updated_at') {
                    
                    if($column == 'job_number' || $column == 'user_number') { 
                        $qry -> orWhere($column, $word);
                    }
                    elseif(
                    	$column == 'name' || 
                        $column == 'title' || 
                        $column == 'catchcopy' || 
                        $column == 'exp_first' || 
                        $column == 'explain' || 
                        $column == 'about_ship' || 
                        $column == 'detail'
                        ) {
                        	$qry -> orWhere($column, 'like', $word);
                    }

                    //産地直送ワード
                    elseif($column == 'farm_direct') {
                        //if($word == "%産地%" || $word == "%直送%" || $word == "%産地直送%") {
                        if(strpos($word, '産地') !== false || strpos($word, '直送') !== false ) {
                            $qry -> orWhere($column, 1);
                        }
                    }

                }
            }
        }        
        
        //カラム名の全てを取得
        $arr = Schema::getColumnListing($table_name); //これでカラム取得が出来る
        
        
        if(str_contains($search, ' ')) { //半角スペース AND検索
            $searchs = explode(' ', $search);
            
            //Tag Search ---
            foreach($searchs as $val) {
                $val = "%".$val."%";
                
                //Tag Search ---
                $query ->where( function($query) use($arr, $val) { //絞り込み検索の時はwhereクロージャを使う。別途の引数はuse()を利用。
                    queryWhere($arr, $query, $val);
                });
            }
                
            $tagIds = array();
            if($query->count() > 0) {
                $tagIds = $query->get()->map(function($tag){
                    return $tag->id;
                })->all();
            }
            
            //get article by tag id
            $itemIds = DB::table('tag_relations') ->whereIn('tag_id', $tagIds)->get()->map(function($tr){
                return $tr->item_id;
            })->all();
            
            //tag result
            $first = DB::table('items')->whereIn('id', $itemIds);
                
            
            //Category Search ---
            $table_name = 'categories';
            $query = DB::table($table_name);
            $columnArr = Schema::getColumnListing($table_name);
            
            foreach($searchs as $val) {
                $val = "%".$val."%";
                $query ->where( function($query) use($columnArr, $val) {
                    queryWhere($columnArr, $query, $val);
                });
            }
                
            $ids = array();
            if($query->count() > 0) {
                $ids = $query->get()->map(function($arg){
                    return $arg->id;
                })->all();
            }
            
            //cate search result
//            $atclIds = DB::table('cate_relations') ->whereIn('cate_id', $ids)->get()->map(function($tr){
//                return $tr->atcl_id;
//            })->all();
            
            $second = DB::table('items')->whereIn('cate_id', $ids);
                
                
            //Item search ---
            $itemQuery = DB::table('items');
            $columnArr = Schema::getColumnListing('items');
            
            foreach($searchs as $val) {
                $val = "%".$val."%";
                $itemQuery ->where( function($qry) use($columnArr, $val) {
                    queryWhere($columnArr, $qry, $val);
                });
            }
                
            //union使用（結合）なのでコレクションにする必要がある（paginationが使えない）
            //$allResults = $first->union($second)->union($atclQuery)->get()->where('open_status', 1)->all();
                
        }
        else { //1word検索
            $val = "%".$search."%";
            
            //Tag search
            queryWhere($arr, $query, $val);
            
            $tagIds = array();
            if($query->count() > 0) {
                $tagIds = $query->get()->map(function($tag){
                    return $tag->id;
                })->all();
            }
            
            //tag search result
            $itemIds = DB::table('tag_relations') ->whereIn('tag_id', $tagIds)->get()->map(function($tr){
                return $tr->item_id;
            })->all();
            
            $first = DB::table('items')->whereIn('id', $itemIds);
            
            //print_r($atclIds);
            
            
            //Category Search
            $table_name = 'categories';
            $query = DB::table($table_name);
            $columnArr = Schema::getColumnListing($table_name);
            queryWhere($columnArr, $query, $val);
            
            $ids = array();
            if($query->count() > 0) {
                $ids = $query->get()->map(function($arg){
                    return $arg->id;
                })->all();
            }
            
            //cate search result
//            $atclIds = DB::table('cate_relations') ->whereIn('cate_id', $ids)->get()->map(function($tr){
//                return $tr->atcl_id;
//            })->all();
            
            $second = DB::table('items')->whereIn('cate_id', $ids);
            
            
            //Article Search
            $itemQuery = DB::table('items');
            $columnArr = Schema::getColumnListing('items');
            queryWhere($columnArr, $itemQuery, $val);
            
            //$atclQuery->where('open_status',1);
            
            //$allResults = $first->union($second)->union($atclQuery)->get()->where('open_status', 1)->all();
            
        } //1word Else
        
        
        //All Result: union使用（結合）なのでコレクションにする必要がある（paginationが使えない）
        //union()->where()が効かない
        //$allResults = $first->union($second)->union($atclQuery)->get()->where('open_status', 1)->all();
        
        /* ORG *****
        $allResults = $first->union($second)->union($atclQuery)->get()
                        ->sortByDesc('open_date')
                        ->map(function($item){
                            if($item->del_status == 0 && $item->open_status == 1 && $item->owner_id > 0) {
                                return $item;
                            }
                        })
                        ->all();
        //print_r($allResults);
        
        $allResults = array_filter($allResults); //空要素を削除
        $allResults = array_merge($allResults); //indexを振り直す
        ***** ORG END */
        
        $allResIds = $first->union($second)->union($itemQuery)->get()->map(function($item){
            return $item->id;
        })->all();
        
//        print_r($allResIds);
//        exit();
        
        
        //$count = $query->count();
        //$pages = $query->paginate($this->pg);
        //$pages -> appends(['s' => $search]); //paginateのヘルパー：urlを付ける
        
        //return compact('allResults', 'search');
        return compact('allResIds', 'search');
        //return [$pages, $search];
    }
}
