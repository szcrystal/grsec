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
use App\PayMethodChild;

use App\Mail\OrderEnd;
use App\Mail\Register;
use App\Mail\NoStocked;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Ctm;
use Mail;
use Auth;
use DB;
use Delifee;
use Exception;

class CartController extends Controller
{
    public function __construct(Item $item, Setting $setting, User $user, UserNoregist $userNor, Sale $sale, SaleRelation $saleRel, Receiver $receiver, PayMethod $payMethod, Prefecture $prefecture, DeliveryGroup $dg, DeliveryGroupRelation $dgRel, Favorite $favorite, PayMethodChild $payMethodChild)
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
        $this->prefecture = $prefecture;
        $this->dg = $dg;
        $this->dgRel = $dgRel;
        $this->favorite = $favorite;
        $this->payMethodChild = $payMethodChild;
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
    
    /* 送料　通常の計算の関数 ******************************** */
    public function normalCalc($dgId, $prefId, $factor)
    {
    	$deliveryFee = 0;
        
    	$dg = $this->dg->find($dgId);
                
        $capacity = $dg->capacity;
        $answer = $factor / $capacity;
        $amari = $factor % $capacity;
        
        $fee = $this->dgRel->where(['dg_id'=>$dgId, 'pref_id'=>$prefId])->first()->fee;
    
        if($amari > 0) { //割り切れない時
            if($answer <= 1) {
                $deliveryFee += $fee;
            }
            else {
                $answer = ceil($answer); //切り上げ
                $deliveryFee += $fee * $answer;
            }
        }
        else { //割り切れる時
            if(is_float($answer)) { //割り切れる時で、なおかつ小数点の余がある時。12.3 / 6 の時amariは0だが、0.3の端数が出る
                $deliveryFee += $fee * ceil($answer); //切り上げ
            }
            else {
                $deliveryFee += $fee * $answer;
            }
        }
        
        return $deliveryFee;
    }
    
    /* 下草・シモツケ・高木コニファー　特別計算の関数 ************************************************** */ 
    public function specialCalc($smId, $bgId, $prefId, $factor)
    {
        $deliveryFee = 0;
        
        //下草小の容量: 20
        $smCapa = $this->dg->find($smId)->capacity;
        //下草大の容量: 40
        $bgCapa = $this->dg->find($bgId)->capacity;
        
        //下草小と大のそれぞれの送料
        $smFee = $this->dgRel->where(['dg_id'=>$smId, 'pref_id'=>$prefId])->first()->fee;
        $bgFee = $this->dgRel->where(['dg_id'=>$bgId, 'pref_id'=>$prefId])->first()->fee;
        
        //$factor = 27.9;
    
        if($factor <= $smCapa) { //個数x係数が20以下なら下草小
//                $answer = $factor / $sitakusaSmCapa;
//                $fee = $this->dgRel->where(['dg_id'=>$sitakusaSmId, 'pref_id'=>$prefId])->first()->fee;
            $deliveryFee += $smFee;        
        }
        else {  //個数x係数が20以上なら容量で割る各種計算が必要
            $amari = $factor % $bgCapa;
            $answer = $factor / $bgCapa;
            
            //amariについて
            //0.3 % 6 = 0
            //1.3 % 6 = 1
            //5.3 % 6 = 5
            //6.3 % 6 = 0
            //7.3 % 6 = 1
            //12.3 % 6 = 0
            //13.3 % 6 = 1
            
//            echo $amari . '/' . $answer. '/'. 27.9 % 6 . '/'. is_float($answer);
//            exit;
            
            if($amari > 0) { //amariがある時 0以上の時

                if($answer <= 1) {
                    $deliveryFee += $bgFee;
                }
                else {
                    if($amari <= $smCapa) { //40で割ったamariが下草小で可能の時 下草小のcapacity以下の時 合計係数が95なら40で割ると余は15となり下草小で可能
                    	if($amari == $smCapa && is_float($answer)) { //factor:27.9 / 容量6の時など 27.9 / 6 小数点分でsmCapacityの容量を超えるので
                        	$deliveryFee += $bgFee * ceil($answer); //切り上げ
                        }
                        else {
                        	$deliveryFee += $smFee;
                        	$deliveryFee += $bgFee * floor($answer); //切り捨て
                        }
                    }
                    else {
                        $deliveryFee += $bgFee * ceil($answer); //切り上げ
                    }
                }
            }
            else { //amari 0 割り切れる時
                if(is_float($answer)) { //割り切れる時で、なおかつ小数点の余がある時。12.3 / 6 の時amariは0だが、0.3の端数が出る
                	$deliveryFee += $smFee;
                    $deliveryFee += $bgFee * floor($answer); //切り捨て
                }
                else { 
                    if($answer <= 1) {   
                        $deliveryFee += $bgFee;
                    }
                    else {
                        $deliveryFee += $bgFee * $answer; //割り切れるので切り上げ切り捨てなし
                    }
                }
            }
        }
        
        return $deliveryFee;
    }
    /* 下草　特別計算の関数 END ************************************************** */
    
    
    /* 値段 商品金額 算出 Sale or Normal Price **************************************************************** */
    private function getItemPrice($item) {
        
        //商品に入力されているSale金額が最優先
        
        $isSale = $this->setting->get()->first()->is_sale;
        $price = 0;
        
        if(isset($item->sale_price)) {
            $price = Ctm::getPriceWithTax($item->sale_price);
        }
        else {
            if($isSale) {
                $price = Ctm::getSalePriceWithTax($item->price);
            }
            else {
                $price = Ctm::getPriceWithTax($item->price);
            }
        }
        
        return $price;
    }
    /* END 値段 商品金額 算出 Sale or Normal Price **************************************************************** */
    
    /* ポイント 還元率 算出 is_point or item point **************************************************************** */
    private function getPointBack($item) {
        
        //商品に入力されているポイント還元率が最優先
        
        //$setting = $this->setting->get()->first();
        $pointBack = 0;
        
        if(isset($item->point_back)) {
            $pointBack = $item->point_back / 100;
        }
        else {
            if($this->set->is_point) {
                $pointBack = $this->set->point_per / 100;
            }
        }
        
        return $pointBack;
    }
    /* ポイント 還元率 算出 is_point or item point END **************************************************************** */
    
    
    public function getThankyou(Request $request)
    {
    	if(! $request->session()->has('all')) {
        	return redirect('/');
        }
        
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
        //$takeChargeFee = $all['take_charge_fee'];
        $usePoint = $all['use_point'];      
      	$addPoint = $all['add_point'];
          
        $destination = isset($allData['destination']) ? 1 : 0;
        $pm = $allData['pay_method'];
        
        $planTime = isset($allData['plan_time']) ? $allData['plan_time'] : array();
        
        $userData = Auth::check() ? $this->user->find(Auth::id()) : $allData['user']; //session(all.data.user)
      	$receiverData = $allData['receiver']; //session('all.data.receiver');
      	
       
       	
        //配送時間指定 itemごとにitemDataの配列内に入れる
        if(count($planTime) > 0) {
            foreach($itemData as $key => $value) {
                
                foreach($planTime as $dgKey => $dgTime ) {
                    $dgId = $this->item->find($value['item_id'])->dg_id;
                    if($dgKey == $dgId) {
                        $itemData[$key]['plan_time'] = $dgTime;
                    }
                }
            }
        }
    
      
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
        $isEmpty = isset($receiverData) ? 1 : 0; //不要かも
//        foreach($receiverData as $receive) {
//        	if(empty($receive)) { //空の時はTrueになる
//         		$isEmpty = 0;
//           		break;      
//         	}    
//        }
       
       //if($isEmpty && ! $destination) { //receiveDataが入力されている時
       $receiverData['user_id'] = $userId;
       $receiverData['regist'] = $regist;
       $receiverData['order_number'] = $all['order_number'];
       //$receiverData['is_user'] = $isUser;
       
       if(! $destination) {
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
       $pmChild = null;
       $payPaymentCode = null;
       
       if($pm == 3) {
            $pmChild = isset($allData['net_bank']) ? $allData['net_bank'] : 0;
            
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
            'pay_method_child' => $pmChild,
            
            'deli_fee' => $deliFee,
            'cod_fee' => $codFee,
            //'take_charge_fee' => $takeChargeFee,
            'use_point' => $usePoint,
            'all_price' => $allPrice, //商品withTax x 個数 の合計　送料等は含まれない
            
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
        $stockNone = array();
        //売上登録処理 Sale create
        foreach($itemData as $key => $val) {
        	
			$i = $this->item->find($val['item_id']);
        
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
                    'single_price' => $this->getItemPrice($i),
                    'total_price' => $val['item_total_price'],
                    
                    'cost_price' => $i->cost_price * $val['item_count'],
                    'charge_loss' => 0,
                    
                    'plan_date' => isset($allData['plan_date']) ? $allData['plan_date'] : null,
                    'plan_time' => isset($val['plan_time']) ? $val['plan_time'] : null,
                    
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
            $item->timestamps = false; //在庫引く時とsale Countでタイムスタンプを上書きしない
            $item->decrement('stock', $val['item_count']);
            
            if(! $item->stock) { //在庫が0になればitem_idを配列へ メールで知らせるため
            	$stockNone[] = $item->id;
            }
            
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
        //for User
        Mail::to($userData['email'], $userData['name'])->queue(new OrderEnd($saleRelId, 1));
        //for Admin
        Mail::to($this->set->admin_email, $this->set->admin_name)->later(now()->addMinutes(3), new OrderEnd($saleRelId, 0))/*->queue(new OrderEnd($saleRelId, 0))*/;
        
        if($regist) { 
        	Mail::to($userData['email'], $userData['name'])->later(now()->addMinutes(2), new Register($userId))/*->queue(new Register($userId))*/; //for User New Regist
        }
        
        
        //在庫確認 -----------------------------------------------
        if(count($stockNone) > 0) {
        	
        	$str = '下記商品の在庫がなくなりました。'. "\n\n";
            
            foreach($stockNone as $itemIdVal) {
            	$str .= '●' . $this->item->find($itemIdVal)->number. "\n";
            	$str .= $this->item->find($itemIdVal)->title. "\n";
        		$str .= url('dashboard/items/'. $itemIdVal). "\n\n\n";
            }
            
            Mail::later(now()->addMinutes(5), new NoStocked($str)); //queue
        
//            Mail::raw($str, function ($message) {
//            	$setting = $this->setting->get()->first();
//                
//                $message -> from('no-reply@green-rocket.jp', $setting->admin_name)
//                         -> to($setting->admin_email, $setting->admin_name)
//                         -> subject('商品の在庫がなくなりました。');          
//            });
        }
        
        
        if(! Ctm::isLocal()) {
            $request->session()->forget('item');
            $request->session()->forget('all'); 
		}   
     
     	$pmModel = $this->payMethod;
     	return view('cart.end', ['data'=>$data, 'pm'=>$pm, 'pmModel'=>$pmModel, 'paymentCode'=>$payPaymentCode, 'active'=>4]);
      
      
      //クレカからの戻りサンプルURL
      //https://192.168.10.16/shop/thankyou?trans_code=718296&user_id=9999&result=1&order_number=679294540
      //後払い戻りサンプルURL
      //https://192.168.10.16/shop/thankyou?trans_code=718177&order_number=1449574270&state=5&payment_code=18&user_id=9999    
    }
    
    
    public function postEpsilon(Request $request)
    {
    	//1回postで送信（file_get_contentsで）し、結果がxmlで返る。その結果が正常ならepsilonへリダイレクトするという仕様
        //イプシロン_system_manual.pdfの47ページに返り値があり
        //しかし、この仕様については詳しく書いていない。サンプルCGIを見ろということらしい
        //https://www.epsilon.jp/developer/each_time.html
        
    	$data = $request->all();
        $strData = implode(',', $data);
        
    	mb_language('Japanese');
        mb_internal_encoding('UTF-8');

        // ヘッダで、相手方に送信フォーマットとデータの長さを伝える
        $header = [
            'Content-Type: application/x-www-form-urlencoded',
            'Content-Length: '. strlen($strData)
        ];

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => implode('\r\n', $header),
                'content' => http_build_query($data, '', '&'),
                'max_redirects' => 3,        // リダイレクトの最大回数 def:3
                'timeout' => '20',           // タイムアウトの秒数指定
            ]
        ]);
        
        
        $isProduct = $this->set->is_product;

        if($isProduct) { //本番環境
            $url = "https://secure.epsilon.jp/cgi-bin/order/receive_order3.cgi"; //本番(完了通知書：contract_66254480.pdf内にあり)
        }
        else { //テスト環境
            // 結果問い合わせ用URL CGI-2利用(basicAuth不要、設定画面からのIP制限有)
            // サンプルソースのCGI-1はIP制限無し、basicAuthのみで制限
            $url = "https://beta.epsilon.jp/cgi-bin/order/receive_order3.cgi";
        }
//        else{
//            throw new Exception('決済サーバURLの指定が異常');
//        }

        $res = file_get_contents($url, false, $context);
        
        if(!$res){
        	throw new Exception('決済サーバに情報が送信できない');
        }
        
        //return (string)$res;
        
        $xml = (string)$res;
        
        $obj = simplexml_load_string($xml);
        if(!$obj){
        	throw new Exception('決済サーバからの情報を解析できない');
        }

        //受け取ったxmlをjsonに変換してからデコードして配列にするという黒魔術
        $json_res =json_encode($obj);
        $decode_res = json_decode($json_res,TRUE);
        
//        print_r($decode_res);
//        exit;

        //普通にforeach１段で回すと、無駄な多次元配列になってしまう 例:$arr[0]['result']
        //2段で回すことで、添字が文字列のみの一次元連想配列にする 例:$arr['result']
        //流石に同じ添字が存在しないことを祈る（API信用できてない）
        $array_res = [];
        foreach($decode_res['result'] as $key => $val){
            $attributes = $val['@attributes'];
            foreach( $attributes as $key_attr => $val_attr ){
                $array_res[$key_attr] = (string)$val_attr;
            }
        }
        //return $array_res;

        if(!$array_res['result']){ //失敗時の処理
            $err_code = $array_res['err_code'];
            $err_detail = urldecode($array_res['err_detail']);

            $err_msg = '決済データの送信に失敗 code-' . $err_code . ':' . $err_detail . PHP_EOL;
            $err_msg .= 'memo1:' . $array_res['memo1'] . PHP_EOL;
            $err_msg .= 'memo2:' . $array_res['memo2'] . PHP_EOL;
            
            //throw new Exception(mb_convert_encoding($err_msg, "UTF-8", "auto"));
            
            $errors['fromEpe'] = $err_msg;
            return redirect('shop/confirm')->withErrors($errors);

        }//成功時の処理
        
        $redirectUrl = urldecode($array_res['redirect']);
        return redirect()->away($redirectUrl);
    }
    

    public function postConfirm(Request $request)
    {
    	$pt=0; //ポイント
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
   			        
			//'destination' => 'required_without:receiver.name,receiver.hurigana,receiver.tel_num,receiver.post_num,receiver.prefecture,receiver.address_1,receiver.address_2,receiver.address_3',
            'receiver.name' => 'required_with:destination|max:255',
            'receiver.hurigana' => 'required_with:destination|max:255',
            'receiver.tel_num' => 'required_with:destination|nullable|numeric',
            'receiver.post_num' => 'required_with:destination|nullable|numeric|digits:7',
            'receiver.prefecture' => 'required_with:destination',
            'receiver.address_1' => 'required_with:destination|max:255',
            'receiver.address_2' => 'required_with:destination|max:255',
            'receiver.address_3' => 'max:255',
            
            'pay_method' => 'required', 
            'net_bank'=> 'required_if:pay_method,3'
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
            'destination.required_with' => '「配送先」を入力して下さい。', //登録先住所に配送の場合は「登録先住所に配送する」にチェックをして下さい。
            'pay_method.required' => '「お支払い方法」を選択して下さい。',
            'use_point.max' => '「ポイント」が保持ポイントを超えています。',
            'net_bank.required_if'=> '「お支払い方法」ネットバンク決済の銀行を選択して下さい。',
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

		//ユーザー(配送先)の都道府県NameとIdを取得
        if(isset($data['destination'])) {
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
        
        //都道府県ID
        $prefId = $this->prefecture->where('name', $prefName)->first()->id;
		//$prefDeli = array();
                
        foreach($itemSes as $key => $val) {
        	$obj = $this->item->find($val['item_id']);
            
            // 配送先が配送可能かどうかを確認するための配列をここで作る
			//$prefDeli[$obj->dg_id][] = $val['item_id'];
            
         	//カウント 個数  
         	$obj['count'] = $val['item_count'];
          	
            //トータルプライス   
            $obj['item_total_price'] = $val['item_total_price'];
            
            //ポイント　ポイント加算
            $pointBack = $this->getPointBack($obj);
            $obj['point'] = ceil($val['item_total_price'] * $pointBack); //商品金額のみに対してのパーセント 切り上げ 切り捨て->floor()
			$addPoint += $obj['point'];
            
            //配送希望時間
            if(isset($data['plan_time'])) {
                foreach($data['plan_time'] as $dgKey => $timeVal) {
                    if($obj->dg_id == $dgKey) {
                        $obj['plan_time'] = $timeVal;
                    }
                }
            }
            
			$itemData[] = $obj;
        }
        
        
        //配送先都道府県への配送が可能かどうかを確認 -------------------------
        $df = new Delifee($itemData, $prefId); //CalcDelifeeController Init 
                
        $errorArr = $df->checkIsDelivery();
        
        /*
        $errorArr = array();
        
        foreach($prefDeli as $dgKey => $item_ids) {
            
            $prefFee = $this->dgRel->where(['dg_id'=>$dgKey, 'pref_id'=>$prefId])->first()->fee;
	
            if($prefFee == '99999' || $prefFee === null) {            	
                foreach($item_ids as $item_id) {
                	$title = $this->item->find($item_id)->title;
                    $errorArr['no_delivery'][] = '「'. $title .'」の商品の'. $prefName .'への配送は不可です。';
                }
                
                //$noDeliPref = 0;
            }
        }
        */
        
        if(count($errorArr) > 0) { //配送不可ならリダイレクト リダイレクトを別クラスに入れるとおかしくなるのでここに
        	return redirect('shop/form')->withErrors($errorArr)->withInput();
        }
        
        
        //手数料、送料、ポイントをここで合計する -------------------------
        $totalFee = 0;
        
        //ポイント 使用ポイント減算-----------
        $usePoint = $data['use_point'];
        $totalFee = $allPrice - $usePoint;
        //ポイント END-----------
        
        //送料 --------------
        $deliFee = $df->getDelifee();
        $totalFee = $totalFee + $deliFee;
        //送料END -----------------
        
        
        $codFee = 0;
        $errors = array();
        //コンビニ手数料 --------------
        if($data['pay_method'] == 2) { 
        	//https://www.epsilon.jp/pricelist/com_conv.html
        	
            $taxPer = $this->set->tax_per / 100;
            
         	if($totalFee <= 1999) {
            	$epTesu = 130;
          		$codFee = ceil(($epTesu * $taxPer) + $epTesu);
          	}
           	elseif ($totalFee >= 2000 && $totalFee <= 2999) {
            	$epTesu = 150;
          		$codFee = ceil(($epTesu * $taxPer) + $epTesu);
            }
            elseif ($totalFee >= 3000 && $totalFee <= 4999) {
            	$epTesu = 180;
          		$codFee = ceil(($epTesu * $taxPer) + $epTesu);
            }
            elseif ($totalFee >= 5000) {
            	$epTesu = $totalFee * 0.04;
            	$codFee = ceil(($epTesu * $taxPer) + $epTesu);
            }
            
            //コンビニ上限額
            if( ($totalFee + $codFee) > 300000) {
            	$errors['konbiniLimit'] = 'コンビニ決済の上限額30万円を超えています。';
                
            }
                   
        }
        
        //GMO後払い手数料 ----------------
        else if($data['pay_method'] == 4) { 
        	$codFee = 205;
            
            //GMO後払い上限額
            if( ($totalFee + $codFee) > 50000) {
            	$errors['gmoLimit'] = 'GMO後払い決済の上限額5万円を超えています。';
            }
        }
        
        
        //代引き手数料 -----------
        else if($data['pay_method'] == 5) { 
        	
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
        //代引き END ---------------------
        
        //送料、手数料、ポイントのsession入れ *********************
        session(['all.deli_fee'=>$deliFee, 'all.cod_fee'=>$codFee, /*'all.take_charge_fee'=>$takeChargeFee,*/ 'all.use_point'=>$usePoint, 'all.add_point'=>$addPoint]);

        
        // Settle 決済 ====================================================
        $title = $itemData[0]->title; //購入１個目の商品をタイトルにする。これ以外なさそう。
        $number = $itemData[0]->number;
        
        //Order_Number
        //$rand = mt_rand();
        $orderNum = Ctm::getOrderNum(10);
        
        //UserInfo
        if(isset($data['user'])) { //Authでなければ$data['user']にデータが入る
        	$user_id = '99999';
        	$user_name = $data['user']['name'];
         	$user_email = $data['user']['email'];   
        }
        else {
        	$user_id = '88' . Auth::id();
        	$user_name = $this->user->find(Auth::id())->name;
            $user_email = $this->user->find(Auth::id())->email;
        }
        
        $settles = array();
        $actionUrl = '';
        
        if($data['pay_method'] == 5 || $data['pay_method'] == 6) { //代引きと銀振
        	//$settles['url'] = url('shop/thankyou');
            $actionUrl = url('shop/thankyou');
        }
        else {
        	$actionUrl = url('shop/to-epsilon');
//        	$isProduct = $this->set->is_product;
//            
//            if($isProduct) { //本番環境
//            	$settles['url'] = "https://secure.epsilon.jp/cgi-bin/order/receive_order3.cgi"; //本番(完了通知書：contract_66254480.pdf内にあり)
//            }
//            else { //テスト環境
//            	$settles['url'] = "https://beta.epsilon.jp/cgi-bin/order/receive_order3.cgi"; //テスト環境
//            }
            
        }
        
        $payCode = 0;
        if($data['pay_method'] == 1) { //クレカ
        	$payCode = '10000-0000-00000-00000-00000-00000-00000';
        }
        elseif($data['pay_method'] == 2) { //コンビニ
        	$payCode = '00100-0000-00000-00000-00000-00000-00000';
        }
        elseif($data['pay_method'] == 3) { // ネットバンク
        	if($data['net_bank'] == 1) {
            	$payCode = '00010-0000-00000-00000-00000-00000-00000';
            }
            elseif($data['net_bank'] == 2) {
            	$payCode = '00001-0000-00000-00000-00000-00000-00000';
            }
            elseif($data['net_bank'] == 3) {
            	$payCode = '00000-0000-00000-00100-00000-00000-00000';
            }
        }
        elseif($data['pay_method'] == 4) { //後払い
            $payCode = '00000-0000-00000-00010-00000-00000-00000';
        }
//        elseif($data['pay_method'] == 4) { //代引き
//            $payCode = '10000-0000-00000-00000-00000-00000-00000'; // ???
//        }
        
        //User識別
        $settles['contract_code'] = '66254480'; //イプシロンID
        $settles['user_id'] = $user_id;
        $settles['user_name'] = $user_name;
        $settles['user_mail_add'] = $user_email;
        $settles['item_code'] = $number;
        $settles['item_name'] = $title;
        $settles['order_number'] = $orderNum;
        $settles['st_code'] = $payCode;
        $settles['mission_code'] = 1;
        $settles['item_price'] = $totalFee;
        $settles['process_code'] = 1;
        $settles['memo1'] = '';
        $settles['xml'] = 1; //1回postで送信し、結果がxmlで返り、正常ならepsilonへリダイレクトするという仕様
        $settles['lang_id'] = 'ja';
        //$settles['page_type'] = 12;
//        $settles['version'] = 2;
        $settles['character_code'] = 'UTF8';
        
        //注文番号のsession入れ
        session(['all.order_number'=>$settles['order_number']]);
        
        $payMethod = $this->payMethod;
        $pmChild = $this->payMethodChild;
        
        $userArr = '';
        if(Auth::check()) {
        	$userArr = $this->user->find(Auth::id());
        }
        else {
        	$userArr = $data['user'];
        }
        
//        print_r($userArr);
//        exit;
        
        return view('cart.confirm', ['data'=>$data, 'userArr'=>$userArr, 'itemData'=>$itemData, 'regist'=>$regist, 'allPrice'=>$allPrice, 'settles'=>$settles, 'payMethod'=>$payMethod, 'pmChild'=>$pmChild, 'deliFee'=>$deliFee, 'codFee'=>$codFee, 'usePoint'=>$usePoint, 'addPoint'=>$addPoint, 'actionUrl'=>$actionUrl, 'active'=>3])->withErrors($errors);
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
             
             	//個数 * 値段の再計算（再計算を押さずに購入手続きした時）
              	$itemId = $data['last_item_id'][$key];
                $itemObj = $this->item->find($itemId);
                
                $lastPrice = $this->getItemPrice($itemObj); //セールならセール金額　通常なら通常金額
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
        
        //PayMethodChild
      	$pmChilds = $this->payMethodChild->all();
       
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
        
        //時間指定の選択肢
        $dgGroup = array();
        foreach($sesItems as $item) {
        	$dgId = $this->item->find($item['item_id'])->dg_id;
            
            if($this->dg->find($dgId)->is_time) {
            	$dgGroup[$dgId][] = $item['item_id'];
            }
            
        }
        
//        print_r($dgGroup);
//        exit;
        
        //$dgGroup = $this->item->groupBy('view_count')->get()->all();        
//        print_r($dgGroup);
//        exit;

     
     	return view('cart.form', ['regist'=>$regist, 'payMethod'=>$payMethod, 'pmChilds'=>$pmChilds, 'prefs'=>$prefs, 'userObj'=>$userObj, 'codCheck'=>$codCheck, 'dgGroup'=>$dgGroup, 'active'=>2]);   
    }
    
    
    public function postCart(Request $request)
    {        
        $itemData = array();
        $allPrice = 0;
        $prefs = $this->prefecture->all();
        
        if($request->has('delifee_calc')/* && ! $request->input('pref_id')*/) {
        	//return redirect('shop/cart')->withErrors(['pref_id'=>'選択して下さい'])->withInput();
        	$rules = [
                'pref_id' => [
                    function($attribute, $value, $fail) use($request) {
                        if(! $value) {
                            return $fail('選択して下さい');
                        }
                    },
                ],
            ];
        
        	$this->validate($request, $rules);
        }

        
//        echo date('Y/m/d', '2018-04-01 12:57:30');
//        exit;
//        $request->session()->forget('item.data');
//        $request->session()->forget('all');
        
        if($request->has('from_item')) { //singleからのpostの時、request dataをsessionに入れる
            $datas = $request->all();
            
//            print_r($datas);
//            exit;
            
            foreach($datas['item_id'] as $k => $v) {
            	
                if($datas['item_count'][$k] == 0) {
                	continue;
                }
                
            	$data = array();
                
            	$data['_token'] = $datas['_token'];
                $data['item_count'] = $datas['item_count'][$k];
                $data['from_item'] = $datas['from_item'];
            	$data['item_id'] = $v;
                $data['uri'] = $datas['uri'];
            
            
                if($request->session()->has('item.data')) { //一度カートに入れ、別商品を再度カートに入れた時
                    
                    if(! in_array($data, session('item.data'))) {
    //                    echo "abc";
    //                     print_r($data);   
    //                     print_r(session('item.data'));   
    //                    exit;
                        $request->session()->push('item.data', $data);
                     }   
                }
                else { //初カートの時
    //                echo "bbb";
    //                print_r(session('item.data'));
    //                exit;
                    $request->session()->push('item.data', $data);
                }
            
            }
            
            $request->session()->put('org_url', $datas['uri']);
        }

        
        $submit = 0;
        $deliFee = null;
        $prefId = null;
            
        //再計算の時
        if($request->has('re_calc') || $request->has('delifee_calc') || $request->has('del_item_key')) {
            $data = $request->all();
            $submit = 1;
            $prefId = isset($data['pref_id']) ? $data['pref_id'] : 0;
            //print_r($secData);
            //exit;
        }
        
        //削除の時
        if($request->has('del_item_key')) {
        	unset($data['last_item_count'][$data['del_item_key']]);
            $data['last_item_count'] = array_values($data['last_item_count']);
            
            //sesionから消す
            $request->session()->forget('item.data.'.$data['del_item_key']);
            
            //Keyの連番を振り直してsessionに入れ直す session入れ
            $reData = array_merge(session('item.data'));
            $request->session()->put('item.data', $reData);
        }
        
        //itemのsessionがある時　なければスルーして$itemDataを空で渡す sessionがない時->カートが空の時だったか
        if( $request->session()->has('item.data') ) {
            $itemSes = session('item.data');
//            print_r($itemSes);
//             exit;
                
            //sessionからobjectを取得して配列に入れる
            foreach($itemSes as $key => $val) {
                $obj = $this->item->find($val['item_id']);
                
                if($submit) { //再計算の時
                	$obj['count'] = $data['last_item_count'][$key];
                    $request->session()->put('item.data.'.$key.'.item_count', $obj['count']);
                }
                else {
                	$obj['count'] = $val['item_count'];	
                } 
                
                //値段 * 個数
                $itemPrice = $this->getItemPrice($obj); //セールならセール金額　通常なら通常金額
                $obj['total_price'] = $itemPrice * $obj['count'];
                //$request->session()->put('item.data.'.$key.'.item_total_price', $obj['item_total_price']); //session入れ
                /*
                $isSale = $this->setting->get()->first()->is_sale;
                
                if(isset($obj->sale_price)) {
                	$total = Ctm::getPriceWithTax($obj->sale_price);
                }
                else {
                    if($isSale) {
                        $total = Ctm::getSalePriceWithTax($obj->price);
                    }
                    else {
                        $total = Ctm::getPriceWithTax($obj->price);
                    }
                }
                */
                
                
				//合計金額を算出
				$allPrice += $obj['total_price'];		
                
                $itemData[] = $obj;       
            }
            /************
            $request->session()->put('all.all_price', $allPrice);
            *************/

			// 送料計算 ===========================
            if(isset($data['delifee_calc']) && $data['delifee_calc']) {

//                print_r($itemData);
//                exit;
                
                $df = new Delifee($itemData, $prefId);
                
                //配送先都道府県への配送が可能かどうかを確認 -------------------------
                $errorArr = $df->checkIsDelivery();
               
                if(count($errorArr) > 0) { //配送不可ならリダイレクト リダイレクトを別クラスに入れるとおかしくなるのでここに
                    return redirect('shop/cart')->withErrors($errorArr)->withInput();
                }
                
                $deliFee = $df->getDelifee();
            }
            
            
            
            //合計金額を算出
//            $priceArr = collect($itemData)->map(function($item) use($allPrice) {
//                return $item->total_price; 
//            })->all();
//            
//            $allPrice = array_sum($priceArr);
        }
        
        
        return view('cart.index', ['itemData'=>$itemData, 'allPrice'=>$allPrice, 'uri'=>session('org_url'), 'prefs'=>$prefs, 'prefId'=>$prefId, 'deliFee'=>$deliFee, 'active'=>1 ]);
        
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
