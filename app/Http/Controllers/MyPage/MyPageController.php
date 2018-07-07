<?php

namespace App\Http\Controllers\MyPage;

use App\User;
use App\UserNoregist;
use App\Item;
use App\Sale;
use App\SaleRelation;
use App\PayMethod;
use App\Prefecture;
use App\Favorite;
use App\Category;
use App\Receiver;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\Mail\Register;
use Mail;
use Auth;
use Ctm;

use Illuminate\Validation\Rule;

class MyPageController extends Controller
{
    public function __construct(Item $item, User $user, UserNoregist $userNor, Sale $sale, SaleRelation $saleRel, PayMethod $payMethod, Prefecture $pref, Favorite $favorite, Category $category, Receiver $receiver)
    {
        
        $this -> middleware('auth', ['except'=>['getRegister', 'postRegister', 'registerEnd']]);
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this ->item = $item;
        
        $this->user = $user;
        $this->userNor = $userNor;
        $this->sale = $sale;
        $this->saleRel = $saleRel;
        $this->payMethod = $payMethod;
        $this->pref = $pref;
        $this->favorite = $favorite;
        $this->category = $category;
    	$this-> receiver = $receiver;
        
//        $this->categorySecond = $categorySecond;
//        $this -> tag = $tag;
//        $this->tagRelation = $tagRelation;
//        $this->consignor = $consignor;
//        
        $this->perPage = 20;
        
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
        
        $sales = $this->sale->whereIn('salerel_id', $relIds)->orderBy('id', 'desc')->paginate($this->perPage);
        
        $saleRel = $this->saleRel;
        $item = $this->item;
        $pm = $this->payMethod;
        
     	return view('mypage.history', ['user'=>$user, 'saleRel'=>$saleRel, 'sales'=>$sales, 'item'=>$item, 'pm'=>$pm]);   
    }
    
    public function showHistory($saleId)
    {
        $uId = Auth::id();
        $user = $this->user->find($uId);
        
        $sale = $this->sale->find($saleId);
        
        $item = $this->item->find($sale->item_id);
        
        $saleRel = $this->saleRel->find($sale->salerel_id);
        $receiver = $this->receiver->find($saleRel->receiver_id);
        
        $relIds = $this->saleRel->where(['user_id'=>$uId, 'is_user'=>1])->get()->map(function($obj){
            return $obj->id;
        })->all();
        
//        print_r($relIds);
//        exit;
        
        $sales = $this->sale->where(['salerel_id'=>$relIds])->get();
        
        $saleRel = $this->saleRel;
        
        $pm = $this->payMethod;
        
         return view('mypage.historySingle', ['user'=>$user, 'sale'=>$sale, 'saleRel'=>$saleRel, 'receiver'=>$receiver, 'item'=>$item, 'pm'=>$pm]);   
    }
    
    
    public function getRegister(Request $request)
    {

        $prefs = $this->pref->all();
        
       if($request->is('mypage/*')) {
       		if(! Auth::check()) {
         		abort(404);
         	}
          	else {   
       			$uId = Auth::id();
        		$user = $this->user->find($uId);
       			$isMypage = 1;
         	}      
       }
       else {
       		$user = null;
       		$isMypage = 0;
       }
       
        //return view('auth.register', ['user'=>$user, 'prefs'=>$prefs, 'isMypage'=>1]);
    	return view('mypage.form', ['user'=>$user, 'prefs'=>$prefs, 'isMypage'=>$isMypage]);
    }
    
    public function registerConfirm(Request $request)
    {
    	
     
        
    }
    
    public function postRegister(Request $request)
    {
    	$isMypage = $request->is('mypage/*') ? 1 : 0;
    	
        $rules = [
            'user.name' => 'required|max:255',
            'user.hurigana' => 'required|max:255',
            'user.email' => 'required|email|max:255',
            'user.tel_num' => 'required|numeric',
//            'cate_id' => 'required',
            'user.post_num' => 'required|nullable|numeric|digits:7', //numeric|max:7
            'user.prefecture' => 'required',         
            'user.address_1' => 'required|max:255',
            'user.address_2' => 'required|max:255',  
            'user.password' => 'sometimes|required|min:8|confirmed', 
            'user.password_confirmation' => 'sometimes|required',                      
  
        ];
        
        //if(! $isMypage) {
        //    $rules['user.password'] = 'required|min:8|confirmed';
       //}
        
        //if(! Auth::check()) {
            //$rules['user.prefecture'] = 'required';
             
          if(! Ctm::isLocal()) {
              $rules['user.email'] = 'filled|email|unique:users,email|max:255';
          }   
               
        //}
        
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
        
        $request->flash();
        session()->put('registUser', $data['user']);
        
        $data = $data['user'];
        
        return view('mypage.formConfirm', ['data'=>$data, 'isMypage'=>$isMypage]);
    }
    
    public function registerEnd(Request $request)
    {
    	$isMypage = $request->is('mypage/*') ? 1 : 0;
     
         //print_r(session('registUser'));
        //exit;      
     
     	if(session('registUser') !== null) {
      		$data = session('registUser');
      	}
       	else {
        	abort(404);
        }            
        
        
    	if($isMypage) {
     		$uId = Auth::id();
            $user = $this->user->find($uId);
        }
        else {
           	$data['password'] = bcrypt($data['password']);
            $user = $this->user; 
        }
        
        $user->fill($data);
        $user->save();
        //$user->update($data['user']);
        
        if(! Ctm::isLocal()) {
        	session()->forget('registUser');
        }
        
        if($isMypage) {
        	$status = "会員登録情報が変更されました。";
        }
        else {
            $status = "会員情報が登録されました。";
        	Mail::to($user->email, $user->name)->send(new Register($user->id));
        	Auth::login($user);
        }
        
        return view('mypage.formEnd', ['isMypage'=>$isMypage, 'status'=>$status, ]);
   
    }
    
    public function getOptout()
    {
    	
     	return view('mypage.optout', []);   
    }
    
    public function postOptout(Request $request)
    {
    	$userId = Auth::id();
     	$userModel = $this->user->find($userId);   
        
    	$rules = [
            'email' => [
            	'required',
                'email',
                'max:255',
                function($attribute, $value, $fail) use($userModel) {
                    if ($value != $userModel->email) {
                        return $fail('登録された「メールアドレス」ではないようです。');
                    }
                },
            ],
            'password' => [
            	'required',
                'min:8',
                function($attribute, $value, $fail) use($userModel) {
                    if (! Hash::check($value, $userModel->password)) {
                        return $fail('登録された「パスワード」ではないようです。');
                    }
                },
            ],
        ];
        
        $messages = [
//            'title.required' => '「商品名」を入力して下さい。',

        ];
        
        $this->validate($request, $rules, $messages);
        $data = $request->all();
        
        //UserNoregistに移す
        $userArr = $userModel->toArray();
        $userArr['active'] = 2;
        $this->userNor->create($userArr);
        
        //Userから消す
        Auth::logout();
        $userModel->delete();

		$isMypage = 2;
  		$status = "会員の退会手続きが完了しました。<br>HOMEへお戻り下さい。";      
     	
        return view('mypage.formEnd', ['isMypage'=>$isMypage, 'status'=>$status, ]);   
    }
    
    public function favorite()
    {
    	$user = $this->user->find(Auth::id());
     	$itemIds = $this->favorite->where(['user_id'=>$user->id])->get()->map(function($obj){
         	return $obj->item_id;
        })->all();
      
      	$items = $this->item->whereIn('id', $itemIds)->orderBy('id', 'desc')->paginate($this->perPage); 
       
       	foreach($items as $item) {
        	$fav = $this->favorite->where(['user_id'=>$user->id, 'item_id'=>$item->id])->first();
            
         	if($fav->sale_id) {
          		$item->saleDate = $this->sale->find($fav->sale_id)->created_at;
          	}
            else {
            	$item->saleDate = 0;
            }       
        	//$item->saled = 1;
        }      
       
       	$cates = $this->category;   
      
        return view('mypage.favorite', ['user'=>$user, 'items'=>$items, 'cates'=>$cates, ]);   
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
