<?php

namespace App\Http\Controllers\Cart;

use App\Item;
use App\Setting;
use App\User;
use App\UserNoregist;
use App\Sale;
use App\SaleRelation;
use App\Receiver;
use App\PayMethod;
use App\Prefecture;
use App\DeliveryGroup;
use App\DeliveryGroupRelation;
use App\Favorite;

use App\Mail\OrderEnd;
use App\Mail\Register;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Ctm;
use Mail;
use Auth;

class CartController extends Controller
{
    public function __construct(Item $item, Setting $setting, User $user, UserNoregist $userNor, Sale $sale, SaleRelation $saleRel, Receiver $receiver, PayMethod $payMethod, Prefecture $prefecture, DeliveryGroup $dg, DeliveryGroupRelation $dgRel, Favorite $favorite)
    {
        
        //$this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this ->item = $item;
        $this ->setting = $setting;
        $this ->set = $this->setting->get()->first();
        
        $this->user = $user;
        $this->userNor = $userNor;
        $this->sale = $sale;
        $this->saleRel = $saleRel;
        $this->receiver = $receiver;
        $this->payMethod = $payMethod;
        $this-> prefecture = $prefecture;
        $this->dg = $dg;
        $this->dgRel = $dgRel;
        $this->favorite = $favorite;
//        $this->category = $category;
//        $this->categorySecond = $categorySecond;
//        $this -> tag = $tag;
//        $this->tagRelation = $tagRelation;
//        $this->consignor = $consignor;
//        
//        $this->perPage = 20;
        
        // URLの生成
        //$url = route('dashboard');
        
        /* ************************************** */
        //env()ヘルパー：環境変数（$_SERVER）の値を取得 .env内の値も$_SERVERに入る
    }
    
    
    
    public function index()
    {
        
        $itemObjs = Item::orderBy('id', 'desc')->paginate($this->perPage);
        
        $cates= $this->category;
        
        
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.item.index', ['itemObjs'=>$itemObjs, 'cates'=>$cates,  ]);
    }

    public function show($id)
    {
        $item = $this->item->find($id);
        $cates = $this->category->all();
        $subcates = $this->categorySecond->where(['parent_id'=>$item->cate_id])->get();
        $consignors = $this->consignor->all();
        //$users = $this->user->where('active',1)->get();
        
        $tagNames = $this->tagRelation->where(['item_id'=>$id])->get()->map(function($item) {
            return $this->tag->find($item->tag_id)->name;
        })->all();
        
        $allTags = $this->tag->get()->map(function($item){
            return $item->name;
        })->all();
        
        return view('dashboard.item.form', ['item'=>$item, 'cates'=>$cates, 'subcates'=>$subcates, 'consignors'=>$consignors, 'tagNames'=>$tagNames, 'allTags'=>$allTags, 'id'=>$id, 'edit'=>1]);
    }
   
    public function create()
    {
        $cates = $this->category->all();
        $consignors = $this->consignor->all();
        
        $allTags = $this->tag->get()->map(function($item){
            return $item->name;
        })->all();
//        $users = $this->user->where('active',1)->get();
        return view('dashboard.item.form', ['cates'=>$cates, 'consignors'=>$consignors, 'allTags'=>$allTags]);
    }
    
    public function getClear(Request $request)
    {
    	$request->session()->forget('item');
        $request->session()->forget('all');
        
        return redirect('/');
    }
    
    public function getThankyou(Request $request)
    {
    	$data = $request->all();
     
//         print_r(session('all'));
//         print_r(session('item.data'));
//         exit;

		
        $itemData = session('item.data');
     	$all = session('all'); //session(all): regist, allPrice
      	$allData = $all['data']; //session(all.data): destination, pay_method, user, receiver  
     	
      	$regist = $all['regist']; 
       	$allPrice = $all['all_price']; 
        $deliFee = $all['deli_fee'];
        $codFee = $all['cod_fee'];
        $usePoint = $all['use_point'];      
      	$addPoint = $all['add_point'];
          
        $destination = isset($allData['destination']) ? 1 : 0;
        $pm = $allData['pay_method'];
        
        $userData = Auth::check() ? $this->user->find(Auth::id()) : $allData['user']; //session(all.data.user)
      	$receiverData = $allData['receiver']; //session('all.data.receiver');
      	
       
       	//print_r($userData);
		//exit;
    
      
      	//User登録処理
      	$userId = 0;
        $isUser = 0;
        
       	if(Auth::check()) { 
        	$uObj = $this->user->find(Auth::id());
        	$userId = $uObj->id;
         	
          	$uObj->increment('point', $addPoint);
//              $uObj->point += $addPoint;
//               $uObj->save();
                     
         	$isUser = 1;   
        }
        else {   
            $userData['magazine'] = isset($userData['magazine']) ? $userData['magazine'] : 0;
            session('all.data.user.magazine', $userData['magazine']); //session入れ　不要？？
            
            if($regist) {   
                $userData['password'] = bcrypt($userData['password']);
      			$userData['point'] = $addPoint;
//                $userData['birth_year'] = $userData['birth_year'] ? $userData['birth_year'] : null;
//                $userData['birth_month'] = $userData['birth_month'] ? $userData['birth_month'] : null;
//                $userData['birth_day'] = $userData['birth_day'] ? $userData['birth_day'] : null;
                
                $user = $this->user;
                $user->fill($userData);
                $user->save();
                
                $userId = $user->id;
                $isUser = 1;
                //ポイントの処理が必要
            }
            else {
                $userNor = $this->userNor;
                $userNor->fill($userData);
                $userNor->save();
                
                $userId = $userNor->id;
            }
        } //AuthCheck
        
        
        //配送先登録 Receiver 別先であってもなくても登録
        $isEmpty = 1;
        foreach($receiverData as $receive) {
        	if(empty($receive)) { //空の時はTrueになる
         		$isEmpty = 0;
           		break;      
         	}    
        }
       
       //if($isEmpty && ! $destination) { //receiveDataが入力されている時
       $receiverData['user_id'] = $userId;
       $receiverData['regist'] = $regist;
       $receiverData['order_number'] = $all['order_number'];
       //$receiverData['is_user'] = $isUser;
       
       if($destination) {
       		$receiverData['name'] = $userData['name'];
         	$receiverData['hurigana'] = $userData['hurigana'];      
       		$receiverData['tel_num'] = $userData['tel_num'];
         	$receiverData['post_num'] = $userData['post_num'];
          	$receiverData['prefecture'] = $userData['prefecture'];
          	$receiverData['address_1'] = $userData['address_1'];
           	$receiverData['address_2'] = $userData['address_2']; 
            $receiverData['address_3'] = $userData['address_3'];               	  
        }
        
        $receiver = $this->receiver;
        $receiver->fill($receiverData);
        $receiver->save();
        
        $receiverId = $receiver->id;
        //配送先END -----------------------------------------------
   
       
       //paymentCode ネットバンクとGMOのみ
       $payPaymentCode = null;
       if($pm == 3) {
       		if($data['payment_code'] == 4)
         		$payPaymentCode = 'ジャパンネットバンク';
         	elseif($data['payment_code'] == 5) 
          		$payPaymentCode = '楽天銀行';
            elseif($data['payment_code'] == 17)  
            	$payPaymentCode = 'SBIネット銀行';     
       }
       elseif($pm == 4) {
       		$payPaymentCode = 'GMO後払い';
       }
       
       
       //SaleRelationのcreate
        $saleRel = $this->saleRel->create([
            'order_number' => $all['order_number'], //コンビニなし
            'regist' =>$all['regist'],
            'user_id' =>$userId,
            'is_user' => $isUser,
            'receiver_id' => $receiverId, 
            'pay_method' => $pm,
            
            'deli_fee' => $deliFee,
            'cod_fee' => $codFee,
            'use_point' => $usePoint,
            'all_price' => $allPrice,
            
            'destination' => $destination,
            'deli_done' => 0,
            'pay_done' => 0,
            
            'pay_trans_code' =>$data['trans_code'], //コンビニはこれのみ
            'pay_user_id' =>isset($data['user_id']) ? $data['user_id'] : null, //コンビニなし
            
            'pay_payment_code' => $payPaymentCode, //ネットバンク、GMO後払いのみ  
            'pay_result' => isset($data['result']) ? $data['result'] : null, //クレカのみ
            'pay_state' => isset($data['state']) ? $data['state'] : null,  //ネットバンク、GMO後払いのみ  
        
        ]);
        
        $saleRelId = $saleRel->id;
        
        $receiver->salerel_id = $saleRelId;
        $receiver->save();
    
    	$saleIds = array();
        //売上登録処理 Sale create
        foreach($itemData as $key => $val) {
            $sale = $this->sale->create(
                [
                	'salerel_id' => $saleRelId,
                	'order_number' => $all['order_number'], //コンビニなし
                    
                    'item_id' =>$val['item_id'],
                    'item_count' =>$val['item_count'], 
                    
                    'regist' =>$all['regist'],
                    'user_id' =>$userId,
                    'is_user' => $isUser,
                    'receiver_id' => $receiverId,
					
                    'pay_method' => $pm,
                    'deli_fee' => $deliFee,
                    'cod_fee' => 0,
                    'use_point' => 0,
                    'total_price' => $val['item_total_price'],
                    
                    'deli_done' => 0,
                    'pay_done' => 0,
                    
                    /*
                    'destination' => $destination,
                    
                    'pay_trans_code' =>$data['trans_code'], //コンビニはこれのみ
            		'pay_user_id' =>isset($data['user_id']) ? $data['user_id'] : null, //コンビニなし
            		
              		'pay_payment_code' => $paymentCode, //ネットバンク、GMO後払いのみ  
              		'pay_result' => isset($data['result']) ? $data['result'] : null, //クレカのみ
                	'pay_state' => isset($data['state']) ? $data['state'] : null,  //ネットバンク、GMO後払いのみ
                 	*/   
                              
                ]
            );
            
            $saleIds[] = $sale->id; 
            
            //在庫引く処理
            $item = $this->item->find($val['item_id']);
            $item->decrement('stock', $val['item_count']);
            
            //Sale Count処理
            $item->increment('sale_count', $val['item_count']);
            
            //お気に入りにsale_idを入れる
            if($isUser) {
            	$fav = $this->favorite->where(['user_id'=>$userId, 'item_id'=>$val['item_id']])->first();
             	if(isset($fav)) {
              		$fav->sale_id = $sale->id;
                	$fav->save();      
              	}
            }
            
                        
        } //foreach
        
        //各商品の合計金額
        //$allTotal = $this->sale->find($saleIds)->sum('total_price');
        
        
        
        //Mail送信 ----------------------------------------------
        //Ctm::sendMail($data, 'itemEnd');
        Mail::to($userData['email'], $userData['name'])->send(new OrderEnd($saleRelId, 1));
        Mail::to($this->set->admin_email, $this->set->admin_name)->send(new OrderEnd($saleRelId, 0));
        
        if($regist) { 
        	Mail::to($userData['email'], $userData['name'])->send(new Register($userId));
        }
        
        
        if(! Ctm::isLocal()) {
            $request->session()->forget('item');
            $request->session()->forget('all'); 
		}   
     
     	$pmModel = $this->payMethod;
     	return view('cart.end', ['data'=>$data, 'pm'=>$pm, 'pmModel'=>$pmModel, 'paymentCode'=>$payPaymentCode, 'active'=>4]);
      
      
      //クレカURL
      //https://192.168.10.16/shop/thankyou?trans_code=718296&user_id=9999&result=1&order_number=679294540
      //後払い戻りURL
      //https://192.168.10.16/shop/thankyou?trans_code=718177&order_number=1449574270&state=5&payment_code=18&user_id=9999    
    }

    public function postConfirm(Request $request)
    {
    	$pt=0;
    	if(Auth::check()) {
     		$pt = $this->user->find(Auth::id())->point;
     	}
      
//      echo $request->input('user.prefecture');  
//      exit; 

        $rules = [
            'user.name' => 'sometimes|required|max:255',
            'user.hurigana' => 'sometimes|required|max:255',
            'user.email' => 'sometimes|required|email|max:255',
            'user.tel_num' => 'sometimes|required|numeric',
//            'cate_id' => 'required',
			'user.post_num' => 'sometimes|required|nullable|numeric|digits:7', //numeric|max:7
   			'user.prefecture' => 'sometimes|not_in:0',         
   			'user.address_1' => 'sometimes|required|max:255',
      		'user.address_2' => 'sometimes|required|max:255',  
        	'user.password' => 'sometimes|required|min:8|confirmed', 
         	'user.password_confirmation' => 'sometimes|required|min:8',      
			'use_point' => 'numeric|max:'.$pt,
   			        
			'destination' => 'required_without:receiver.name,receiver.hurigana,receiver.tel_num,receiver.post_num,receiver.prefecture,receiver.address_1,receiver.address_2,receiver.address_3',
            'receiver.name' => 'required_without:destination|max:255',
            'receiver.hurigana' => 'required_without:destination|max:255',
            'receiver.tel_num' => 'required_without:destination|nullable|numeric',
            'receiver.post_num' => 'required_without:destination|nullable|numeric|digits:7',
            'receiver.prefecture' => 'required_without:destination',
            'receiver.address_1' => 'required_without:destination|max:255',
            'receiver.address_2' => 'required_without:destination|max:255',
            'receiver.address_3' => 'max:255',
            
            'pay_method' => 'required', 
            //'main_img' => 'filenaming',
        ];
        
        //
        if(! Auth::check()) {
        	//$rules['user.prefecture'] = 'required';
         	
          	if($request->input('regist') && ! Ctm::isLocal()) {
          		$rules['user.email'] = 'filled|email|unique:users,email|max:255';
          	}   
               
        }
        
         $messages = [
            //'title.required' => '「商品名」を入力して下さい。',
            'user.prefecture.not_in' => '「都道府県」を選択して下さい。',
            'destination.required_without' => '「配送先」を入力して下さい。', //登録先住所に配送の場合は「登録先住所に配送する」にチェックをして下さい。
            'pay_method.required' => '「お支払い方法」を選択して下さい。',
            'use_point.max' => '「ポイント」が保持ポイントを超えています。',
            //'post_thumb.filenaming' => '「サムネイル-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'post_movie.filenaming' => '「動画-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'slug.unique' => '「スラッグ」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        $data = $request->all();
        

        //全データをsessionに入れる session入れ
        $request->session()->put('all.data', $data); //user receiver destination paymentMethod
        //$request->session()->put('all.user', $data['user']);
        //$request->session()->put('all.receiver', $data['receiver']);
        //$request->session()->put('user.data', $data['user']);
        //$request->session()->put('receiver.data', $data['receiver']);
        
        $itemSes = session('item.data');
        $regist = session('all.regist');
        $allPrice = session('all.all_price');
//        print_r(session('all'));
//        exit;
        
        
        //商品テーブル用のオブジェクト取得 -------------------------------
        $itemData = array();
        $addPoint = 0;
//        print_r($itemSes);
//        exit;
        
        foreach( $itemSes as $key => $val) {
        	$obj = $this->item->find($val['item_id']);
         	//カウント   
         	$obj['count'] = $val['item_count'];
          	//トータルプライス   
            $obj['item_total_price'] = $val['item_total_price'];
            //ポイント計算
            $obj['point'] = ceil($val['item_total_price'] * ($obj->point_back/100)); //商品金額のみに対してのパーセント 切り上げ 切り捨て->floor()
			$addPoint += $obj['point'];
            
			$itemData[] = $obj;
        }
        
        //手数料、送料、ポイントをここで合計する -------------------------
        $totalFee = 0;
        
        //ポイント -----------
        $usePoint = $data['use_point'];
        $totalFee = $allPrice - $usePoint;
        
        
        //送料 ---------------------------------
        $deliFee = 0;
        
        if(! isset($data['destination'])) {
        	$prefName = $data['receiver']['prefecture'];
         	//$prefId = $this->prefecture->where('name', $prefName)->first()->id;   
        }
        else {
        	if(Auth::check()) {
        		$prefName = $this->user->find(Auth::id())->prefecture;
         	}
          	else {
           		$prefName = $data['user']['prefecture'];
           }
        }
        
        //ユーザーの都道府県
        $prefId = $this->prefecture->where('name', $prefName)->first()->id;
        
        //配送区分：下草小のid
        $sitakusaSmId = 1;
        //配送区分：下草大のid
        $sitakusaBgId = 2;
        
        //配送区分：コニファー小のid
        $coniferSmId = 3;
        //配送区分：コニファー大のid
        $coniferBgId = 4;
        
        $isOnceItem = array();
        $sitakusaItem = array();
        $coniferItem = array();
        $dgIds = array();
        

        //同梱包可能で、配送区分も同じ場合を区別する必要がある
        //同梱包可能なもので配送区分の同じものと異なるものを分けて送料を出す
        foreach($itemData as $item) {
        	if(! $item->is_delifee) { //送料が無料でないもの
                if(! $item->is_once) { //同梱包不可のものはそれぞれ単独で
                    $fee = $this->dgRel->where(['dg_id'=>$item->dg_id, 'pref_id'=>$prefId])->first()->fee;
                    $deliFee += $fee;
                    //$dgIds[] = $item->dg_id;
                } 
                else { //同梱包可能なものは別配列へ入れて下記へ
                    if($item->dg_id == $sitakusaSmId || $item->dg_id == $sitakusaBgId) { //下草の時 下草用の配列に入れる　下草だけ特別なので別計算で
                        $sitakusaItem[] = $item;
                    }
                    elseif($item->dg_id == $coniferSmId || $item->dg_id == $coniferBgId) { //コニファーの時 コニファー用の配列に入れる　コニファーだけ特別なので別計算で
                    	$coniferItem[] = $item;
                    }
                    else {
                        $isOnceItem[] = $item;
                        $dgIds[$item->id] = $item->dg_id; //itemIdをkeyとしてdeliveryGroupIdを別配列へ
                    }
                }
            }      
        }
        
        
        //下草でない時 ============     
        if(count($isOnceItem) > 0) {
        	foreach($isOnceItem as $ioi) {
         		if(isset($dgIds[$ioi->id])) { //ここでsetされていなければ519行目のarray_diffで削除されているので送料算出の必要なし
           			unset($dgIds[$ioi->id]); //自身の要素を削除
             	
                    if(in_array($ioi->dg_id, $dgIds)) { //同じ配送区分があるかどうか                        
                        //容量を超えていないかの確認
                        $out = array_count_values($dgIds); //要素がkeyになって個数がvalとして配列になる
                        //$count = $out[$ioi->dg_id] + 1;
                        
                        $count = 0;
                        $factor = 0;
                        
                        //他の同じ配送区分の商品の個数を取り出す
                        $itemIdKeys = array_keys($dgIds, $ioi->dg_id);
                        if(count($itemIdKeys) > 0) {
                        	foreach($itemIdKeys as $itemIdKey) {
                                foreach($isOnceItem as $obj) {
                                	if($obj->id == $itemIdKey) {
                                 		$count += $obj->count; //買い物個数
                                        $factor += $obj->factor * $obj->count;
                                 	}   
                                }
                         		
                         	}   
                        }
                        

                        //このループの商品の個数
                        $count += $ioi->count;
                        $factor += $ioi->factor * $ioi->count;
                        
                            
                        $dg = $this->dg->find($ioi->dg_id);
                        
                        //dgの容量を取り、係数に対して割り、余りも出す。余りが0なら割ったanswerの倍数送料、余りがあればanswer１以上で少数切り上げをしてその整数値を送料に掛ける
                        $capacity = $dg->capacity;
                        $answer = $factor / $capacity;
                        $amari = $factor % $capacity;
                        
                        $fee = $this->dgRel->where(['dg_id'=>$ioi->dg_id, 'pref_id'=>$prefId])->first()->fee;
                    
                    	if($amari > 0) { //割り切れない時
                            if($answer <= 1) {
                                $deliFee += $fee;
                            }
                            else {
                                $answer = ceil($answer); //切り上げ
                                $deliFee += $fee * $answer;
                            }
                        }
                        else { //割り切れる時
                        	$deliFee += $fee * $answer;
                        }
                        
                        
                        $dgIds = array_diff($dgIds, array($ioi->dg_id)); //同じ配送区分のdg_idを削除
                                                     
                    }
                    else { //同じ配送区分がない時
                    	$fee = $this->dgRel->where(['dg_id'=>$ioi->dg_id, 'pref_id'=>$prefId])->first()->fee;
                    	$deliFee += $fee;  
                    }     
                }
         	}   
        }
        
        //下草の時 下草だけ特別なので別計算で ========
        if(count($sitakusaItem) > 0) {
        	$count = 0;
            $factor = 0;
            
            //下草小の容量: 20
            $sitakusaSmCapa = $this->dg->find($sitakusaSmId)->capacity;
            //下草大の容量: 40
            $sitakusaBgCapa = $this->dg->find($sitakusaBgId)->capacity;
            
            //下草小と大のそれぞれの送料
			$smFee = $this->dgRel->where(['dg_id'=>$sitakusaSmId, 'pref_id'=>$prefId])->first()->fee;
            $bgFee = $this->dgRel->where(['dg_id'=>$sitakusaBgId, 'pref_id'=>$prefId])->first()->fee;
            
            //下草商品の係数の合計を算出
        	foreach($sitakusaItem as $ioi) {	
                $count += $ioi->count;
                $factor += $ioi->factor * $ioi->count;   
        	}

            
            if($factor <= $sitakusaSmCapa) { //個数x係数が20以下なら下草小
//                $answer = $factor / $sitakusaSmCapa;
//                $fee = $this->dgRel->where(['dg_id'=>$sitakusaSmId, 'pref_id'=>$prefId])->first()->fee;
                $deliFee += $smFee;        
            }
            else {  //個数x係数が20以上なら各種計算が必要
                $amari = $factor % $sitakusaBgCapa;
                $answer = $factor / $sitakusaBgCapa;
                
                if($amari > 0) { //amariがある時 0以上の時

                    if($answer <= 1) {
                        $deliFee += $bgFee;
                    }
                    else {
                    	if($amari <= $sitakusaSmCapa) { //40で割ったamariが下草小で可能の時 下草小のcapacity以下の時 合計係数が95なら40で割ると余は15となり下草小で可能
                        	$deliFee += $smFee;
                            $deliFee += $bgFee * floor($answer); //切り捨て
                        }
                        else {
                    		$deliFee += $bgFee * ceil($answer); //切り上げ
                        }
                    }
                }
                else { //amari 0 割り切れる時
                	//$fee = $this->dgRel->where(['dg_id'=>$sitakusaBgId, 'pref_id'=>$prefId])->first()->fee;
                    
                    if($answer <= 1) {   
                        $deliFee += $bgFee;
                    }
                    else {
                    	$deliFee += $bgFee * $answer; //割り切れるので切り上げ切り捨てなし
                    }
                }
            }
        }
        
        
        //コニファーの時 コニファーは大商品が含まれているかどうかを確認する必要があるので　大or小を判別できればあとは通常計算で ========
        if(count($coniferItem) > 0) {
        	$count = 0;
            $factor = 0;
            
            $isBg = 0;
            
            foreach($coniferItem as $ioi) {
            	if($ioi->dg_id == $coniferBgId) {
                	$isBg = 1;
                    break;
                }
            }
        
        	//コニファーの容量と送料を取得
            if($isBg) { //コニファー大の時
            	$coniferCapa = $this->dg->find($coniferBgId)->capacity;
                $coniFee = $this->dgRel->where(['dg_id'=>$coniferBgId, 'pref_id'=>$prefId])->first()->fee;
            }
            else { //コニファー小の時
            	$coniferCapa = $this->dg->find($coniferSmId)->capacity;
                $coniFee = $this->dgRel->where(['dg_id'=>$coniferSmId, 'pref_id'=>$prefId])->first()->fee;
            }
            
 
            //下草商品の係数の合計を算出
        	foreach($coniferItem as $ioi) {	
                $count += $ioi->count;
                $factor += $ioi->factor * $ioi->count;   
        	}
            
            //余りと割り算の解を計算
            $amari = $factor % $coniferCapa;
            $answer = $factor / $coniferCapa;
            
            //余りと割算の答えがあれば、あとは普通の計算と同じ
            if($amari > 0) { //割り切れない時
                if($answer <= 1) {
                    $deliFee += $coniFee;
                }
                else {
                    $answer = ceil($answer); //切り上げ
                    $deliFee += $coniFee * $answer;
                }
            }
            else { //割り切れる時
                $deliFee += $coniFee * $answer;
            }
        
        
        }
        
         
        $totalFee = $totalFee + $deliFee;
        //送料END -----------------
        
        //代引き手数料 -----------
        $codFee = 0;
        if($data['pay_method'] == 5) { 
        	
         	if($totalFee <= 10000) {
          		$codFee = 324;
          	}
           	elseif ($totalFee >= 10001 && $totalFee <= 30000) {
            	$codFee = 432;
            }
            elseif ($totalFee >= 30001 && $totalFee <= 100000) {
            	$codFee = 648;
            }
            elseif ($totalFee >= 100001 && $totalFee <= 300000) {
            	$codFee = 1080;
            }
            elseif ($totalFee >= 300001 && $totalFee <= 500000) {
                $codFee = 2160;
            }
            elseif ($totalFee >= 500001 && $totalFee <= 1000000) {
                $codFee = 3240;
            }
            elseif ($totalFee >= 1000001 && $totalFee <= 999999999) {
                $codFee = 4320;
            }           
        }
        
        $totalFee = $totalFee + $codFee;
        
        //送料、手数料、ポイントのsession入れ *********************
        session(['all.deli_fee'=>$deliFee, 'all.cod_fee'=>$codFee, 'all.use_point'=>$usePoint, 'all.add_point'=>$addPoint]);

        
        // Settle 決済 ====================================================
        $title = $itemData[0]->title; //購入１個目の商品をタイトルにする。これ以外なさそう。
        $number = $itemData[0]->number;
        
        //Order_Number
        //$rand = mt_rand();
        $orderNum = Ctm::getOrderNum(10);
        
        //UserInfo
        if(isset($data['user'])) { 
        	$user_name = $data['user']['name'];
         	$user_email = $data['user']['email'];   
        }
        else {
        	$user_name = $this->user->find(Auth::id())->name;
            $user_email = $this->user->find(Auth::id())->email;
        }
        
        $settles = array();
        
        if($data['pay_method'] == 5 || $data['pay_method'] == 6) {
        	$settles['url'] = url('shop/thankyou');
        }
        else {
            $settles['url'] = "https://beta.epsilon.jp/cgi-bin/order/receive_order3.cgi"; //テスト環境
            //$settleUrl = ""; //本番
        }
        
        $payCode = 0;
        if($data['pay_method'] == 1) { //クレカ
        	$payCode = '10000-0000-00000-00000-00000-00000-00000';
        }
        elseif($data['pay_method'] == 2) { //コンビニ
        	$payCode = '00100-0000-00000-00000-00000-00000-00000';
        }
        elseif($data['pay_method'] == 3) { // ネットバンク
            $payCode = '00010-0000-00000-00000-00000-00000-00000';
        }
        elseif($data['pay_method'] == 4) { //後払い
            $payCode = '00000-0000-00000-00010-00000-00000-00000';
        }
//        elseif($data['pay_method'] == 4) { //代引き
//            $payCode = '10000-0000-00000-00000-00000-00000-00000'; // ???
//        }
        //User識別
        $settles['contract_code'] = '66254480';
        $settles['user_id'] = '9999';
        $settles['user_name'] = $user_name;
        $settles['user_mail_add'] = $user_email;
        $settles['item_code'] = $number;
        $settles['item_name'] = $title;
        $settles['order_number'] = $orderNum;
        $settles['st_code'] = $payCode;
        $settles['mission_code'] = 1;
        $settles['item_price'] = $totalFee;
        $settles['process_code'] = 1;
        $settles['memo1'] = 'あいうえお';
        $settles['xml'] = 0;
        $settles['lang_id'] = 'ja';
        //$settles['page_type'] = 12;
//        $settles['version'] = 2;
//        $settles['character_code'] = 'UTF8';
        
        //注文番号のsession入れ
        session(['all.order_number'=>$settles['order_number']]);
        
        $payMethod = $this->payMethod;
        
        $userArr = '';
        if(Auth::check()) {
        	$userArr = $this->user->find(Auth::id());
        }
        else {
        	$userArr = $data['user'];
        }
        
//        print_r($userArr);
//        exit;
        
        return view('cart.confirm', ['data'=>$data, 'userArr'=>$userArr, 'itemData'=>$itemData, 'regist'=>$regist, 'allPrice'=>$allPrice, 'settles'=>$settles, 'payMethod'=>$payMethod, 'deliFee'=>$deliFee, 'codFee'=>$codFee, 'usePoint'=>$usePoint, 'addPoint'=>$addPoint, 'active'=>3]);
    }
    
    
    public function postForm(Request $request)
    {
//       print_r(session('item.data'));
//       exit;
//         print_r(session('all'));   
//         exit; 
        
        $allPrice = 0;
          
      	if($request->has('from_cart') ) { //cartからpostで来た時
       		$data = $request -> all(); 
            
            $regist = $request->has('regist_on') ? 1 : 0;
         	$request->session()->put('all.regist', $regist); //session入れ
          	
           	foreach($data['last_item_count'] as $key => $val) {   
            	$request->session()->put('item.data.'.$key.'.item_count', $val); //session入れ 
             
             	//個数*値段の再計算
              	$itemId = $data['last_item_id'][$key];
               	$lastPrice = Ctm::getPriceWithTax($this->item->find($itemId)->price);   
                $lastPrice = $lastPrice * $val;
            	$request->session()->put('item.data.'.$key.'.item_total_price', $lastPrice); //session入れ
             
                $allPrice += $lastPrice;
            }
            //all priceのsession入れ
            $request->session()->put('all.all_price', $allPrice);
       	}
        else { //getの時
        	if($request->session()->has('all.regist')) {
         		$regist = session('all.regist');
         	}
          	else {
           		abort(404);
           	}      
        }          
     
     	//PayMethod
      	$payMethod = $this->payMethod->all();
       
       	//Prefecture
        $prefs = $this->prefecture->all();      
       	
        //User   
        $userObj = null;
        if(Auth::check()) {
        	$userObj = $this->user->find(Auth::id());
        } 
        
        //代引きが可能かどうかを判定してboolを渡す
        $sesItems = session('item.data');
        $codCheck = 0;
        foreach($sesItems as $item) {
        	$cod = $this->item->find($item['item_id'])->cod;
            if($cod) {
          		$codCheck = 1;
            	break;      
          	}      
        }
     
     	return view('cart.form', ['regist'=>$regist, 'payMethod'=>$payMethod, 'prefs'=>$prefs, 'userObj'=>$userObj, 'codCheck'=>$codCheck, 'active'=>2]);   
    }
    
    
    public function postCart(Request $request)
    {        
        $itemData = array();
        $allPrice = 0;
        
//        echo date('Y/m/d', '2018-04-01 12:57:30');
//        exit;
//        $request->session()->forget('item.data');
//        $request->session()->forget('all');
        
        if($request->has('from_item')) { //postの時、request dataをsessionに入れる
            $data = $request->all();
            
            if($request->session()->has('item.data')) {
                
                if(! in_array($data, session('item.data'))) {
//                    echo "abc";
//                     print_r($data);   
//                     print_r(session('item.data'));   
//                    exit;
                    $request->session()->push('item.data', $data);
                 }   
            }
            else {
//                echo "bbb";
//                print_r(session('item.data'));
//                exit;
                $request->session()->push('item.data', $data);
            }
            
            $request->session()->put('org_url', $data['uri']);
        }

        
        $submit = 0;
        //再計算の時
        if($request->has('re_calc')) {
            $data = $request->all();
            $submit = 1;
//            print_r($secData);
//            exit;
        }
        
        //削除の時
        if($request->has('del_item_key')) {
        	$data = $request->all();
            $request->session()->forget('item.data.'.$data['del_item_key']);
            
            //Keyの連番を振り直してsessionに入れ直す session入れ
            $reData = array_merge(session('item.data'));
            $request->session()->put('item.data', $reData);
        }
        
        //itemのsessionがある時　なければスルーして$itemDataを空で渡す
        if( $request->session()->has('item.data') ) {
            $itemSes = session('item.data');
//            print_r($itemSes);
//             exit;
                
            //sessionからobjectを取得して配列に入れる
            foreach($itemSes as $key => $val) {
                $obj = $this->item->find($val['item_id']);
                
                if($submit) { //再計算の時
                	$obj['count'] = $data['last_item_count'][$key];
                }
                else {
                	$obj['count'] = $val['item_count'];	
                } 
                
                //値段 * 個数
                $total = Ctm::getPriceWithTax($obj->price);
                $obj['total_price'] = $total * $obj['count'];
                //$request->session()->put('item.data.'.$key.'.item_total_price', $obj['item_total_price']); //session入れ
				//合計金額を算出
				$allPrice += $obj['total_price'];		
                
                $itemData[] = $obj;       
            }
            /************
            $request->session()->put('all.all_price', $allPrice);
            *************/
            
            //合計金額を算出
//            $priceArr = collect($itemData)->map(function($item) use($allPrice) {
//                return $item->total_price; 
//            })->all();
//            
//            $allPrice = array_sum($priceArr);
        }
        
        
        return view('cart.index', ['itemData'=>$itemData, 'allPrice'=>$allPrice, 'uri'=>session('org_url'), 'active'=>1 ]);
        
        //$tax_per = $this->set->tax_per;
//        print_r($itemSes);
//        exit;
//        
//        if ($request->session()->exists('item_data')) {
//            $itemSes = session('item_data');
//                
//        }
//           $request->session()->put('item_data', $data);
//        $ses = $request->session()->all();
//        
//        print_r($ses);
//        exit;

//         if($request->has('regist_on') || $request->has('regist_off')) {
//             $regist = $request->has('regist_on') ? 1 : 0;
//              $payMethod = $this->payMethod->all();   
//             return view('cart.form', ['itemData'=>$itemData, 'regist'=>$regist, 'allPrice'=>$allPrice, 'payMethod'=>$payMethod, ]);
//         }
//         else {
//            return view('cart.index', ['itemData'=>$itemData, 'allPrice'=>$allPrice, 'uri'=>session('org_url') ]);
//        }
        
//        //status
//        if(isset($data['open_status'])) { //非公開On
//            $data['open_status'] = 0;
//        }
//        else {
//            $data['open_status'] = 1;
//        }
//        
//        //stock_show
//        $data['stock_show'] = isset($data['stock_show']) ? 1 : 0;
//        
//        
//        if($editId) { //update（編集）の時
//            $status = '商品が更新されました！';
//            $item = $this->item->find($editId);
//        }
//        else { //新規追加の時
//            $status = '商品が追加されました！';
//            //$data['model_id'] = 1;
//            
//            $item = $this->item;
//        }
//        
//        $item->fill($data);
//        $item->save();
//        $itemId = $item->id;
//        
////        print_r($data['main_img']);
////        exit;
//        
//        //Main-img
//        if(isset($data['main_img'])) {
//                
//            //$filename = $request->file('main_img')->getClientOriginalName();
//            $filename = $data['main_img']->getClientOriginalName();
//            $filename = str_replace(' ', '_', $filename);
//            
//            //$aId = $editId ? $editId : $rand;
//            //$pre = time() . '-';
//            $filename = 'item/' . $itemId . '/thumbnail/'/* . $pre*/ . $filename;
//            //if (App::environment('local'))
//            $path = $data['main_img']->storeAs('public', $filename);
//            //else
//            //$path = Storage::disk('s3')->putFileAs($filename, $request->file('thumbnail'), 'public');
//            //$path = $request->file('thumbnail')->storeAs('', $filename, 's3');
//            
//            $item->main_img = $path;
//            $item->save();
//        }
//        
//        //Spare-img
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
//        
//
//        
//        //タグのsave動作
//        if(isset($data['tags'])) {
//            $tagArr = $data['tags'];
//        
//            foreach($tagArr as $tag) {
//                
//                //Tagセット
//                $setTag = Tag::firstOrCreate(['name'=>$tag]); //既存を取得 or なければ作成
//                
//                if(!$setTag->slug) { //新規作成時slugは一旦NULLでcreateされるので、その後idをセットする
//                    $setTag->slug = $setTag->id;
//                    $setTag->save();
//                }
//                
//                $tagId = $setTag->id;
//                $tagName = $tag;
//
//
//                //tagIdがRelationになければセット ->firstOrCreate() ->updateOrCreate()
//                $tagRel = $this->tagRelation->firstOrCreate(
//                    ['tag_id'=>$tagId, 'item_id'=>$itemId]
//                );
//                /*
//                $tagRel = $this->tagRelation->where(['tag_id'=>$tagId, 'item_id'=>$itemId])->get();
//                if($tagRel->isEmpty()) {
//                    $this->tagRelation->create([
//                        'tag_id' => $tagId,
//                        'item_id' => $itemId,
//                    ]);
//                }
//                */
//
//                //tagIdを配列に入れる　削除確認用
//                $tagIds[] = $tagId;
//            }
//        
//            //編集時のみ削除されたタグを消す
//            if(isset($editId)) {
//                //元々relationにあったtagがなくなった場合：今回取得したtagIdの中にrelationのtagIdがない場合をin_arrayにて確認
//                $tagRels = $this->tagRelation->where('item_id', $itemId)->get();
//                
//                foreach($tagRels as $tagRel) {
//                    if(! in_array($tagRel->tag_id, $tagIds)) {
//                        $tagRel->delete();
//                    }
//                }
//            }
//        }
        
        
        //return view('cart.index', ['data'=>$data ]);
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
        
         $array = [1, 11, 12, 13, 14, 15];
         
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
