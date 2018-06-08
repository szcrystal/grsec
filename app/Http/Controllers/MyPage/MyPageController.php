<?php

namespace App\Http\Controllers\MyPage;

use App\User;
use App\Item;
use App\Sale;
use App\SaleRelation;
use App\PayMethod;
use App\Prefecture;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

class MyPageController extends Controller
{
    public function __construct(Item $item, User $user, Sale $sale, SaleRelation $saleRel, PayMethod $payMethod, Prefecture $pref)
    {
        
        $this -> middleware('auth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this ->item = $item;
        
        $this->user = $user;
//        $this->userNor = $userNor;
        $this->sale = $sale;
        $this->saleRel = $saleRel;
        $this->payMethod = $payMethod;
        $this->pref = $pref;
//        $this->receiver = $receiver;
        
//        $this-> prefecture = $prefecture;
//        $this->category = $category;
//        $this->categorySecond = $categorySecond;
//        $this -> tag = $tag;
//        $this->tagRelation = $tagRelation;
//        $this->consignor = $consignor;
//        
//        $this->perPage = 20;
        
    }
    
    
    
    public function index()
    {
        
//        $itemObjs = Item::orderBy('id', 'desc')->paginate($this->perPage);
//        
//        $cates= $this->category;
        
        $uId = Auth::id();
        $user = $this->user->find($uId);
        
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('mypage.index', ['user'=>$user, ]);
    }
    
    public function history()
    {
    	$uId = Auth::id();
        $user = $this->user->find($uId);
        
        $relIds = $this->saleRel->where(['user_id'=>$uId, 'is_user'=>1])->get()->map(function($obj){
        	return $obj->id;
        })->all();
        
//        print_r($relIds);
//        exit;
        
        $sales = $this->sale->where(['salerel_id'=>$relIds])->get();
        
        $saleRel = $this->saleRel;
        $item = $this->item;
        $pm = $this->payMethod;
        
     	return view('mypage.history', ['user'=>$user, 'saleRel'=>$saleRel, 'sales'=>$sales, 'item'=>$item, 'pm'=>$pm]);   
    }
    
    public function showHistory($saleId)
    {
        $uId = Auth::id();
        $user = $this->user->find($uId);
        
        $relIds = $this->saleRel->where(['user_id'=>$uId, 'is_user'=>1])->get()->map(function($obj){
            return $obj->id;
        })->all();
        
//        print_r($relIds);
//        exit;
        
        $sales = $this->sale->where(['salerel_id'=>$relIds])->get();
        
        $saleRel = $this->saleRel;
        $item = $this->item;
        $pm = $this->payMethod;
        
         return view('mypage.history', ['user'=>$user, 'saleRel'=>$saleRel, 'sales'=>$sales, 'item'=>$item, 'pm'=>$pm]);   
    }
    
    public function getRegister()
    {
    	$uId = Auth::id();
        $user = $this->user->find($uId);
        
        $prefs = $this->pref->all();
        
    	return view('mypage.form', ['user'=>$user, 'prefs'=>$prefs, ]);
    }
    
    public function postRegister(Request $request)
    {
    	$rules = [
            'user.name' => 'filled|max:255',
            'user.hurigana' => 'filled|max:255',
            'user.email' => 'filled|email|max:255',
            'user.tel_num' => 'filled|numeric',
//            'cate_id' => 'required',
            'user.post_num' => 'filled|nullable|numeric|digits:7', //numeric|max:7
            'user.prefecture' => 'required',         
               'user.address_1' => 'filled|max:255',
              'user.address_2' => 'filled|max:255',  
            //'user.password' => 'filled|min:8|confirmed',                      
                       
            
        ];
        
        //
        if(! Auth::check()) {
            $rules['user.prefecture'] = 'required';
             
              if($request->input('regist') && ! Ctm::isLocal()) {
                  $rules['user.email'] = 'filled|email|unique:users,email|max:255';
              }   
               
        }
        
         $messages = [
//            'title.required' => '「商品名」を入力して下さい。',
//            'cate_id.required' => '「カテゴリー」を選択して下さい。',
//            'destination.required_without' => '「配送先」を入力して下さい。', //登録先住所に配送の場合は「登録先住所に配送する」にチェックをして下さい。
//            'pay_method.required' => '「お支払い方法」を選択して下さい。',
//            'use_point.max' => '「ポイント」が保持ポイントを超えています。',
            //'post_thumb.filenaming' => '「サムネイル-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'post_movie.filenaming' => '「動画-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'slug.unique' => '「スラッグ」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        $data = $request->all();
        
        $data['user']['magazine'] = isset($data['user']['magazine']) ? 1 : 0;
        
//        $data['user']['birth_year'] = $data['user']['birth_year'] ? $data['user']['birth_year'] : null;
//        $data['user']['birth_month'] = $data['user']['birth_month'] ? $data['user']['birth_month'] : null;
//        $data['user']['birth_day'] = $data['user']['birth_day'] ? $data['user']['birth_day'] : null;
        
        $uId = Auth::id();
        $user = $this->user->find($uId);
        
        $user->update($data['user']);
        
        $status = "会員登録情報が変更されました。";
        
        return redirect('mypage/register')->with('status', $status);
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
