<?php

namespace App\Http\Controllers;

use App\Item;
use App\DeliveryGroup;
use App\DeliveryGroupRelation;
use App\Prefecture;
use App\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

    
class CalcDelifeeController extends Controller
{
//	public $itemData;
//	public $prefId;

	//private $dgId = 3;
    
    public function __construct($itemData, $prefId)
    {
        $this->item = new Item;
        $this->dg = new DeliveryGroup;
        $this->dgRel = new DeliveryGroupRelation;
        $this->prefecture = new Prefecture;
        
        $this->setting = new Setting;
        
        $this->itemData = $itemData;
        $this->prefId = $prefId;
                
    }
    
    
    public function index()
    {
    	$dgId = 0;
    	foreach($this->itemData as $item) {
        	$dgId = $item->id;
            break;
        }
        
    	$dg = $this->dg->find($dgId);
        $dgRel = $this->dgRel->where(['dg_id'=>$dg->id, 'pref_id'=>$this->prefId])->get()->first();
        
        
        echo $dgRel->fee;
        //echo $this->dgId;
        exit;
    }
    
    public function checkIsDelivery()
    {
    	$errorArr = array();
        $prefId = $this->prefId;
                
        foreach($this->itemData as $keys => $item) {
            
            $prefFee = $this->dgRel->where(['dg_id'=>$item->dg_id, 'pref_id'=>$prefId])->first()->fee;
    
            if($prefFee == '99999' || $prefFee === null) {            	
                $title = $item->title;
                $prefName = $this->prefecture->find($prefId)->name;
                
                $errorArr['no_delivery.'. $keys][] = '「'. $title .'」['.  $item->number .'] の「'. $prefName .'」への配送は不可です。';
            }
        }
        
        return $errorArr;
        
//        if(count($errorArr) > 0) { //配送不可ならリダイレクト
//            return redirect($toRedirect)->withErrors($errorArr)->withInput();
//        }
//        else {
//        	return;
//        }
    }
    
    

    /* 送料　通常の計算の関数 **************************************************************** */
    public function normalCalc($dgId, $factor) //factor->事前に個数の倍数であること
    {
    	$deliveryFee = 0;
        
        $prefId = $this->prefId;
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
    
    /* 下草・シモツケ・高木コニファー　小の容量を超えれば大の送料になる特別計算の関数 ************************************************** */ 
    public function specialCalc($smId, $bgId, $factor)
    {
        $deliveryFee = 0;
        $prefId = $this->prefId;
        
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
    
    
    /* 特殊計算：無料分の余った容量を埋める関数 ************************************* */
    public function freeFillCalc()
    {
    	
        
        
    }
    /* 特殊計算：無料分の余った容量を埋める関数 END ************************************* */
    
    
    
    /* Main *************************************************** */
    public function getDelifee()
    {
    	//送料 ---------------------------------
        $deliFee = 0;
        //$takeChargeFee = 0;
        
        //$prefId/$prefNameは上記で既に取得している
        
        //下草：小の容量を越えれば大の送料になる
        //配送区分：下草小のid
        $sitakusaSmId = 1;
        //配送区分：下草大のid
        $sitakusaBgId = 2;
        
        //高木コニファー(千代田プランツ)： ->高木が含まれていれば高木として計算（下草と同じ計算方法　商品個数x係数の合計に応じて容量と送料区分が決まる）
        //配送区分：高木コニファー小のid
        $koubokuSmId = 3;
        //配送区分：高木コニファー大のid
        $koubokuBgId = 4;
        //下草コニファー(千代田プランツ)： ->高木が含まれていれば高木として計算（下草と同じ計算方法　商品個数x係数の合計に応じて容量と送料区分が決まる）
        $sitakoniId = 5;
        
        
        //シモツケ(千代田プランツ)  -> 下草と同じ計算方法
        //配送区分：シモツケ小のid
        $simotukeSmId = 6;
        //配送区分：シモツケ大のid
        $simotukeBgId = 7;
        

        //モリヤコニファー：大の商品が含まれていれば強制的に大となり、なければ小になる 
        //配送区分：モリヤコニファー下草のid
        $coniferKsId = 8;
        //配送区分：モリヤコニファー小のid
        $coniferSmId = 9;
        //配送区分：モリヤコニファー大のid
        $coniferBgId = 10;
        
        
        $isOnceItem = array();
        $sitakusaItem = array();
        $tiyodaItem = array();
        $simotukeItem = array();
        $coniferItem = array();
        //$keyIsDgId = array();
        

        //同梱包可能で、配送区分も同じ場合を区別する必要がある
        //同梱包可能なもので配送区分の同じものと異なるものを分けて送料を出す
        foreach($this->itemData as $item) {
        	
            if($item->dg_id == $sitakusaSmId || $item->dg_id == $sitakusaBgId) { //下草 府中ガーデンの時
            	if(! $item->is_once) { //下草府中ガーデンで同梱包不可のものはそれぞれ単独で -> ほとんどなさそうだが
                    $factor = $item->factor * $item->count;
                    $deliFee += $this->specialCalc($sitakusaSmId, $sitakusaBgId, $factor);                    
                }
                else {
            		$sitakusaItem[] = $item;
                }
        	}
            elseif($item->dg_id == $coniferKsId || $item->dg_id == $coniferSmId || $item->dg_id == $coniferBgId) { //モリヤコニファーの時
            	if(! $item->is_once) { //モリヤコニファーで同梱包不可のものはそれぞれ単独で -> ほとんどなさそうだが
                    $factor = $item->factor * $item->count;
                    $deliFee += $this->normalCalc($item->dg_id, $factor);                    
                }
                else {
            		$coniferItem[] = $item;
                }
            }
            elseif(! $item->is_delifee) { //送料が無料でないもの
                if(! $item->is_once) { //同梱包不可のものはそれぞれ単独で
                    $factor = $item->factor * $item->count;
                    $deliFee += $this->normalCalc($item->dg_id, $factor);
                    
                    //ORG ---
                    //$deliFee += $this->dgRel->where(['dg_id'=>$item->dg_id, 'pref_id'=>$this->prefId])->first()->fee;
                } 
                else { //同梱包可能なものは別配列へ入れて下記へ
//                    if($item->dg_id == $sitakusaSmId || $item->dg_id == $sitakusaBgId) { //下草の時 下草用の配列に入れる　下草特別なので別計算で
//                        $sitakusaItem[] = $item;
//                    }
                    if($item->dg_id == $koubokuSmId || $item->dg_id == $koubokuBgId || $item->dg_id == $sitakoniId) { //高木コニファー(千代田プランツ)の時 高木用の配列に入れる　高木は特別なので別計算で
                    	$tiyodaItem[] = $item;
                    }
                    elseif($item->dg_id == $simotukeSmId || $item->dg_id == $simotukeBgId) { //シモツケの時 シモツケ用の配列に入れる　シモツケは特別なので別計算で
                    	$simotukeItem[] = $item;
                    }
//                    elseif($item->dg_id == $coniferKsId || $item->dg_id == $coniferSmId || $item->dg_id == $coniferBgId) { //モリヤコニファーの時 モリヤコニファー用の配列に入れる　モリヤコニファーだけ特別なので別計算で
//                    	$coniferItem[] = $item;
//                    }
                    else { //下草・コニファー以外の同梱包商品
                        $isOnceItem[$item->dg_id][] = $item; //dgIdをKeyとして、itemを入れる dgIdが同じitemはdgIdのkeyに対しての配列としてpushされる
                        //$keyIsDgId[] = $item->id; //itemIdをkeyとしてdeliveryGroupIdを別配列へ
                    }
                }
            }
            
            
        }
  		
        
        //下草・コニファー以外の同梱包商品 係数 x 個数の合計が容量を越えれば都道府県送料の倍数となる ============     
        if(count($isOnceItem) > 0) {
        
        	foreach($isOnceItem as $dgIdKey => $itemArrs) {
            	//$count = 0;
            	$factor = 0;
                
                //同じ配送区分のItemに対して 係数 x 個数を出す
                foreach($itemArrs as $ioi) {
                	//$count += $obj->count; //買い物個数
                    $factor += $ioi->factor * $ioi->count;
                }
                
                //dgの容量を取り、係数に対して割り、余りも出す。余りが0なら割ったanswerの倍数送料、余りがあればanswer１以上で少数切り上げをしてその整数値を送料に掛ける
                //通常計算関数にて
                $deliFee += $this->normalCalc($dgIdKey, $factor);
                
            
            } //foreach first
        
        } // if(count($isOnceItem) > 0)
        

        
        //下草(府中ガーデン)の時 特別なので別計算で ================
        if(count($sitakusaItem) > 0) {
        	$countSm = 0;
            $countBg = 0;
            
            $factor = 0;
            $factorFreeSm = 0;
            $factorFreeBg = 0;
            
            $freeCapaSm = 0;
            $freeCapaBg = 0;
 
/*
            //下草小の容量: 20
            $sitakusaSmCapa = $this->dg->find($sitakusaSmId)->capacity;
            //下草大の容量: 40
            $sitakusaBgCapa = $this->dg->find($sitakusaBgId)->capacity;
            
            //下草小と大のそれぞれの送料
			$smFee = $this->dgRel->where(['dg_id'=>$sitakusaSmId, 'pref_id'=>$prefId])->first()->fee;
            $bgFee = $this->dgRel->where(['dg_id'=>$sitakusaBgId, 'pref_id'=>$prefId])->first()->fee;
*/            

            //下草商品の係数の合計を算出 送料無料のものと有料のものを分ける
        	foreach($sitakusaItem as $ioi) { 
                if($ioi->is_delifee) { //送料無料のもの この場合、余る容量を計算するための準備をここでする
                	if($ioi->dg_id == $sitakusaSmId) {
                    	$factorFreeSm += $ioi->factor * $ioi->count;
                        $countSm++;
                    }
                    else {
                		$factorFreeBg += $ioi->factor * $ioi->count;
                        $countBg++;
                    }
                }
                else { //送料有料のもの
                	$factor += $ioi->factor * $ioi->count;
                } 
        	}
            
            if($countSm > 0) {
            	$sitakusaSmCapa = $this->dg->find($sitakusaSmId)->capacity;
                $sitakusaSmCapa = $sitakusaSmCapa * $countSm;
                $freeCapaSm = $sitakusaSmCapa - $factorFreeSm;
            }
            
            if($countBg > 0) {
            	$sitakusaBgCapa = $this->dg->find($sitakusaBgId)->capacity;
                $sitakusaBgCapa = $sitakusaBgCapa * $countBg;
                $freeCapaBg = $sitakusaBgCapa - $factorFreeBg;
            }
            
			//最終のFactorを算出 最終Factorが0以上ならその分が送料となるので最終計算をさせる。0以下なら全て無料容量に収まっていることになるので計算不要（送料0）となる。
			$factor = $factor - ($freeCapaSm + $freeCapaBg);
            
//            echo $factorFreeSm . '/' . $countSm. '/' . $factorFreeBg . '/' . $countBg . '/' . $factor . '/' . $freeCapaSm . '/' . $freeCapaBg;
//            exit;
            
            if($factor > 0) { //係数が0以下なら全て無料容量に収まっていることになるので計算不要（送料0）となる。
                $deliFee += $this->specialCalc($sitakusaSmId, $sitakusaBgId, $factor); //特別関数で計算
            }

        }
        
        //高木コニファー・下草コニファー（千代田プランツ）の時  特別なので別計算で ================
        if(count($tiyodaItem) > 0) {
        	//$count = 0;
            $factor = 0;
            $switch = 0; //高木コニファーがない時False 高木コニファーがある時True
            
            foreach($tiyodaItem as $itemObject) {
                if($koubokuSmId == $itemObject->dg_id || $koubokuBgId == $itemObject->dg_id) {
                	$switch = 1;
                    break;
                }
            }
             
            //下草商品の係数の合計を算出
        	foreach($tiyodaItem as $ioi) {  //★★★ 高木コニファーがあってもなくても、係数はその商品に指定されている係数にて計算している★★★
                //$count += $ioi->count;
                $factor += $ioi->factor * $ioi->count;   
        	}
            
//            echo $factor . '/'. $switch . '/' . $prefId;
//            exit;
            
            if($switch) {
            	$deliFee += $this->specialCalc($koubokuSmId, $koubokuBgId, $factor); //下記の特別関数で計算
            }
            else { //下草コニファー（千代田プランツ）は大小の区別がないので通常計算で可能
            	$deliFee += $this->normalCalc($sitakoniId, $factor);
            	
			}
            
        }
        
        
        //シモツケの時 係数x個数の合計に対して容量を決める特別計算 下草（府中ガーデン）と同じ================
        if(count($simotukeItem) > 0) {
        	//$count = 0;
            $factor = 0;
            
            //下草商品の係数の合計を算出
        	foreach($simotukeItem as $ioi) {
                //$count += $ioi->count;
                $factor += $ioi->factor * $ioi->count;   
        	}
            
            $deliFee += $this->specialCalc($simotukeSmId, $simotukeBgId, $factor); //下記の特別関数で計算
			
        }

        
        
        //モリヤコニファーの時 モリヤコニファーは大商品が含まれているかどうかを確認する必要があるので　大or小を判別できればあとは通常計算で ========
        if(count($coniferItem) > 0) {
        	//$count = 0;
            $factor = 0;
            
            $isBg = 0;
            $isSm = 0;
            
            foreach($coniferItem as $ioi) {
            	if($ioi->dg_id == $coniferBgId) {
                	$isBg = 1;
                    break;
                }
            }
            
            if(!$isBg) {
            	foreach($coniferItem as $ioi) {
                    if($ioi->dg_id == $coniferSmId) {
                        $isSm = 1;
                        break;
                    }
                }
            }
            

            //コニファー商品の係数の合計を算出
        	foreach($coniferItem as $ioi) {	
                /* 特殊計算 ******************* */
                if($ioi->is_delifee) { //送料無料のもの この場合、余る容量を計算するための準備をここでする
                	if($ioi->dg_id == $sitakusaKsId) {
                    	$factorFreeKs += $ioi->factor * $ioi->count;
                        $countKs++;
                    }
                }
                else { //送料有料のもの
                	$factor += $ioi->factor * $ioi->count;
                } 
                /* 特殊計算 END ******************* */
                
                //$factor += $ioi->factor * $ioi->count;   
        	}
            
            if($countKs > 0) {
            	$sitakusaKsCapa = $this->dg->find($sitakusaKsId)->capacity;
                $sitakusaKsCapa = $sitakusaKsCapa * $countKs;
                $freeCapaKs = $sitakusaKsCapa - $factorFreeKs;
            }

			//最終のFactorを算出 最終Factorが0以上ならその分が送料となるので最終計算をさせる。0以下なら全て無料容量に収まっていることになるので計算不要（送料0）となる。
			$factor = $factor - $freeCapaKs;
            
            
            if($isBg) { //大を含む時
            	$deliFee += $this->normalCalc($coniferBgId, $factor);
            }
            elseif($isSm) { //小を含む時
            	$deliFee += $this->normalCalc($coniferSmId, $factor);
            }
            else { //下草のみの時
            	$deliFee += $this->normalCalc($coniferKsId, $factor);
            }
          
        }
        
         
        //$totalFee = $totalFee + $deliFee;
        
        return $deliFee;
        //送料END -----------------
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
