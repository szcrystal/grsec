<?php

namespace App\Http\Controllers;

use App\Item;
use App\Category;
use App\Tag;
use App\TagGroup;
use App\TagRelation;
use App\Fix;
use App\TotalizeAll;
use App\Setting;
use App\MailTemplate;

use App\ItemUpper;
use App\ItemUpperRelation;

use Mail;
use DateTime;
use Auth;

use Illuminate\Http\Request;

class CustomController extends Controller
{
	public $setting;
	
    public function __construct(Setting $setting, Item $item, Category $category, Tag $tag)
    {
    	$this->setting = $setting;
    	$this->item = $item;
        $this->category = $category;
        $this->tag = $tag;
        //$this->totalizeAll = $totalizeAll;
        
	}
    
    
    static function changeDate($arg, $rel=0)
    {
    	if(!$rel)
	        return date('Y/m/d H:i', strtotime($arg));
        else
        	return date('Y/m/d', strtotime($arg));
    }
    
    static function getPriceWithTax($price)
    {
    	$tax_per = Setting::get()->first()->tax_per;
     	$tax = floor($price * $tax_per/100);   
     	$price = $price + $tax;
      	
        return $price;      
    }
    
    static function getSalePriceWithTax($price)
    {
    	//$orgPrice = Self::getPriceWithTax($price);
        
        $salePer = Setting::get()->first()->sale_per;
        $tax_per = Setting::get()->first()->tax_per;
        
        $waribiki = $price * ($salePer/100);
        $price = $price - $waribiki;
        $tax = floor($price * $tax_per/100);   
     	$price = $price + $tax;
                
        return $price;
        
    }
    
    static function getItemPrice($obj)
    {
    	$isSale = Setting::get()->first()->is_sale; 

                                                    
        if(isset($obj->sale_price)) {
            $price = number_format(CustomController::getPriceWithTax($obj->sale_price));
        }
        else {
            if($isSale)
                $price = number_format(CustomController::getSalePriceWithTax($obj->price));
            else
                $price = number_format(CustomController::getPriceWithTax($obj->price));
        }
        
        
        return $price;
    }
    
    static function getFixPage()
    {
        $set = Setting::get()->first();
        
        $fixArr['fixNeeds'] = array();
        $fixArr['fixOthers'] = array();
        
        $needIds = array();
        $otherIds = array();
        
        if(isset($set->fix_need)) {
        	$needIds = explode(',', $set->fix_need);
            $fixArr['fixNeeds'] = Fix::whereIn('id', $needIds)->where('open_status', 1)->orderByRaw("FIELD(id, $set->fix_need)")->get(); //orderByRowで配列の順番通りにする
        }
        
        if(isset($set->fix_other)) {
        	$otherIds = explode(',', $set->fix_other);
            $fixArr['fixOthers'] = Fix::whereIn('id', $otherIds)->where('open_status', 1)->orderByRaw("FIELD(id, $set->fix_other)")->get();
        }

        return $fixArr;
    }
    
    static function getTags($itemId, $num=0)
    {
        $tagIds = TagRelation::where('item_id', $itemId)->get()->map(function($obj){
            return $obj->tag_id;
        })->all();
        
        $strs = '"'. implode('","', $tagIds) .'"';

        
        if($num)
        	$tags = Tag::whereIn('id', $tagIds)->orderByRaw("FIELD(id, $strs)")->take($num)->get();
        else
        	$tags = Tag::whereIn('id', $tagIds)->orderByRaw("FIELD(id, $strs)")->get();

		
        return $tags;

    }
    
    static function getItemTitle($item, $isHtml = 0)
    {
    	$itemTitle = '';
        
    	if($item->is_potset && $item->pot_parent_id) {
            $itemTitle = Item::find($item->pot_parent_id)->title . '／'/* . "<b class=\"text-danger\">" . $item->title . "</b>"*/;
            $itemTitle .= $isHtml ? '<b class="text-danger">' . $item->title . '</b>' : $item->title;
        }
        else {
            $itemTitle = $item->title;
        }
        
        return $itemTitle;
        
    }
    
    
//    static function getHeaderTitle($type)
//    {
//    	$title = '';
//        
//    	@if($type == 'category') {
//        	$title = Category::->name;
//        }
//                    @elseif($type == 'subcategory')
//                    	<small class="d-block pb-2">{{ $cate->name }}</small>{{ $subcate->name }}
//                    @elseif($type == 'tag')
//                    	タグ：{{ $tag->name }}
//                    @elseif($type=='search')
//                        @if(!count($items))
//                        検索ワード：{{ $searchStr }}の記事がありません
//                        @else
//                        検索ワード：{{ $searchStr }}
//                        @endif
//                    @endif
//    }
    
    
    static function getArgForView($slug, $type)
    {
//    	$posts = Article::where('open_status', 1)
//               ->orderBy('open_date', 'desc')
//               ->take(30)
//               ->get();

//        foreach($rankObjs as $obj) {
//        	$objId[] = $obj->post_id;
//            //$rankObj[] = $this->articlePost->find($obj->post_id);
//        }
//    
//    	$ranks = $this->articlePost ->find($objId)->where('open_status', 1)->take(20);
        
        //非Openのグループidを取る
//        $tgIds = TagGroup::where('open_status', 0)->get()->map(function($tg){
//            return $tg->id;
//        })->all();
//        
//        //人気タグ
//        $tagLeftRanks = Tag::whereNotIn('group_id', $tgIds)->where('view_count','>',0)->orderBy('view_count', 'desc')->take(10)->get();
//        
//        //Category
//        $cateLeft = Category::all(); //open_status
		
        $rightRanks = '';
        
        //TOP20
        if($type == 'tag') {
        	$tag = Tag::where('slug', $slug)->first();
            $atclIds = TagRelation::where('tag_id', $tag->id)->get()->map(function($tr){
            	$atcl = Article::find($tr->atcl_id);
                if($atcl) {
                    if($atcl->open_status && ! $atcl->del_status && $atcl->owner_id > 0) {
                        return $tr->atcl_id;
                    }
                }
            })->all();
            
            $rightRanks = TotalizeAll::whereIn('atcl_id', $atclIds)->orderBy('total_count', 'desc')->take(20)->get();

        }
        else if($type == 'cate') {
        	$cate = Category::where('slug', $slug)->first();
        	
            $atclIds = Article::where(['open_status'=>1, 'del_status'=>0, 'cate_id'=>$cate->id])->whereNotIn('owner_id', [0])
                ->get()->map(function($al){
                    return $al->id;
                })->all();
            
            $rightRanks = TotalizeAll::whereIn('atcl_id', $atclIds)->orderBy('total_count', 'desc')->take(20)->get();
            
        }
        else { //all
            $atclIds = Article::where([
                ['open_status','=',1], ['del_status', '=', '0'], ['owner_id', '>', '0']
            ])
            ->get()->map(function($al){
                return $al->id;
            })->all();
            
            $rightRanks = TotalizeAll::whereIn('atcl_id', $atclIds)->orderBy('total_count', 'desc')->take(20)->get();

        }
        
        //return compact('tagLeftRanks', 'cateLeft', 'rightRanks');
        return $rightRanks;
    }
    
    static function getLeftbar() {
    	//非Openのグループidを取る
//        $tgIds = TagGroup::where('open_status', 0)->get()->map(function($tg){
//            return $tg->id;
//        })->all();
        
        //人気タグ
        $tagLeftRanks = Tag::where('view_count','>',0)->orderBy('view_count', 'desc')->take(10)->get();
        
        //Category
        //$cateLeft = Category::all(); //open_status
        
        return compact('tagLeftRanks', 'cateLeft');
    }
    
    static function shortStr($str, $length)
    {
    	if(mb_strlen($str) > $length) {
        	$continue = '…';
            $str = mb_substr($str, 0, $length);
            $str = $str . $continue;
        }

        return $str;
    }
    
    
    static function fixList()
    {
    	$fixes = Fix::where('not_open', 0)->get();
        
        return $fixes;
    }
    
    static function isOld()
    {
    	return count(old()) > 0;
    }
    
    static function isOldSelected($name, $obj, $objs)
    {
    	$selected = '';
        if(CustomController::isOld()) {
        	if(old($name) == $obj)
            	$selected = ' selected';
        }
        else {
        	if(isset($objs) && $objs->$name == $obj) {
            	$selected = ' selected';
            }
        }
        
        return $selected;
    }
    
    static function isOldChecked($name, $objs)
    {
    	$checked = '';
        if(CustomController::isOld()) {
        	if(old($name))
            	$checked = ' checked';
        }
        else {
        	//isset($article) && $article->del_status
        	if(isset($objs) && $objs->$name) {
            	$checked = ' checked';
            }
        }
        
        return $checked;
    }
    
    
    //郵便番号の出力
    static function getPostNum($post_code)
    {
    	$post_code = str_pad($post_code, 7, 0, STR_PAD_LEFT); //0埋め
    	return preg_replace("/^(\d{3})(\d{4})$/", "$1-$2", $post_code);
    }
    
    //注文番号 OrderNumberの作成
    static function getOrderNum($length) {
        //$eng = array_merge(range('a', 'z'), range('A', 'Z'));
        $eng = array_merge(range('a', 'z'));
        $num = array_merge(range('0', '9'));
        
        $alphaNum = $length > 12 ? 5 : 3; //13桁以上ならアルファベットを5文字にする
        $intNum = $length - $alphaNum;
        
        $r_str = null;
        
        //アルファベット部分
        for ($i = 0; $i < $alphaNum; $i++) {
            $r_str .= $eng[mt_rand(0, count($eng) - 1)];
        }
        
        //$r_str .= '-';
        //整数部分
        for ($n = 0; $n < $intNum; $n++) {
            $r_str .= $num[mt_rand(0, count($num) - 1)];
        }
        
        return $r_str;
        
    }
    
    //枯れ保証期間の書き出し
    static function getKareHosyou($deliDate)
    {
    	$kareDay = Setting::get()->first()->kare_ensure; 
        //$kareDay += 1;
        
        $limit = strtotime($deliDate." +" . $kareDay . " day");

        $limitDay = new DateTime(date('Y-m-d', $limit));
        $current = new DateTime(date('Y-m-d', time())); //DateTime('now')
        
        $diff = $current->diff($limitDay);
        //echo $diff->days;
            
//                    $limit = $limit - strtotime("now");  
//                     $days = (strtotime('Y-m-d', $limit) - strtotime("1970-01-01")) / 86400;   
  
    	return ['limit'=>date('Y/m/d', $limit), 'diffDay'=>$diff->days];
    }
    
    static function getDateWithYoubi($dateNormalFormat)
    {
    	$week = ['日', '月', '火', '水', '木', '金', '土'];
        /*
        $time = strtotime($dateNormalFormat);
        $withYoubi = date('Y/m/d', $time);
        $withYoubi .= ' (' . $week[date('w', $time)] . ')';
        */
		
        $time = new DateTime($dateNormalFormat);
		$withYoubi = $time->format('Y/m/d');
        $withYoubi .= ' (' . $week[$time->format('w')] . ')';
        
        return $withYoubi;
    }
    
    
    static function getUpperArr($parentId, $type)
    {
    	//ItemUpper
        $upperRels = null;
        $upperRelArr = array();
        
        $upper = ItemUpper::where(['parent_id'=>$parentId, 'type_code'=>$type, 'open_status'=>1])->first();
		
        if(isset($upper)) {
        	$upperRels = ItemUpperRelation::where(['upper_id'=>$upper->id, ])->orderBy('sort_num', 'asc')->get();
            
            if($upperRels->isNotEmpty()) {
            	foreach($upperRels as $upperRel) {

                    if($upperRel->is_section) {
                        if($upperRel->sort_num > 0) { //sort_numが1以上なら中タイトル 0は大タイトル(1つのみ)
                            $upperRelArr[$upperRel->block]['mid_section'][] = $upperRel;
                        }
                        else {
                            $upperRelArr[$upperRel->block]['section'] = $upperRel; //大タイトルは一つのみなので、pushしない
                        }
                    }
                    else {
                        $upperRelArr[$upperRel->block]['block'][] = $upperRel;
                    }

                }
            }

        }
        
        return $upperRelArr;
    }
    
    
    static function checkRole($roleName)
    {
    	$per = Auth::guard('admin')->user()->permission;
        
        //$ret = $view ? true : view('erroes.dashboard');
        
        if(
        	$roleName == 'isSuper' && $per < 5 ||
        	$roleName == 'isAdmin' && $per < 10 ||
            $roleName == 'isDesigner' && $per == 10
        ) {
        	return true;
        }
        
        else {
        	return false;
        }
        
        
    }
    
    static function gmoId()
    {
    	// 変更する場合は、js内にも1カ所あるので注意*******   	
        
        if(Setting::get()->first()->is_product) { //本番
        	return [
            	'siteId' =>'tsite00032753',
                'sitePass' => 'uu6xvemh',
                'shopId' =>'tshop00036826',
                'shopPass' => 'bgx3a3xf',
        	];	
        }
        else { //テスト
        	return [
            	'siteId' =>'tsite00032753',
                'sitePass' => 'uu6xvemh',
                'shopId' =>'tshop00036826',
                'shopPass' => 'bgx3a3xf',
        	];
        }
    	
    }
    
    static function cUrlFunc($connectUrl, $datas)
    {
    	$productUrl = "https://p01.mul-pay.jp/payment/";
        $testUrl = "https://pt01.mul-pay.jp/payment/";
        
    	$url = Setting::get()->first()->is_product ? $productUrl : $testUrl; 
    	
        $options = [
            CURLOPT_URL => $url . $connectUrl,
            CURLOPT_RETURNTRANSFER => true, //文字列として返す
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($datas),
            CURLOPT_TIMEOUT => 60, // タイムアウト時間
        ];
        
        //curl init
        $ch = curl_init();
        
        //setOption
        curl_setopt_array($ch, $options);
        
        //response
        $response = curl_exec($ch);
        
        //close
        curl_close($ch);
        
        return $response;
    }
    
    
    static function sendMail($data, $typeCode)
    {
    	$set = Setting::get()->first();
     	$templ = MailTemplate::where(['type_code'=>$typeCode])->first();   
      
//         echo $set->admin_email;
//        exit;      
        
        $data['is_user'] = 1; //引数について　http://readouble.com/laravel/5/1/ja/mail.html
        Mail::send('emails.'. $templ->type_code, $data, function($message) use ($data, $set, $templ) 
        {
            //$dataは連想配列としてviewに渡され、その配列のkey名を変数としてview内で取得出来る
            $message -> from($set->admin_email, $set->admin_name)
                     -> to($data['user']['email'], $data['user']['name'])
                     -> subject($template->title);
            //$message->attach($pathToFile);
            
        });
        
        //for Admin
        $data['is_user'] = 0;
        //if(! env('MAIL_CHECK', 0)) { //本番時 env('MAIL_CHECK')がfalseの時
        Mail::send('emails.'. $template->type_code, $data, function($message) use ($data)
        {
            $message -> from($set->admin_email, $set->admin_name)
                     -> to($set->admin_email, $set->admin_name)
                     -> subject($template->type_name .'がありました - '. config('app.name'). ' -');
        });
    }
    
    static function isAgent($agent)
    {
        $ua_sp = array('iPhone','iPod','Mobile ','Mobile;','Windows Phone','IEMobile');
        $ua_tab = array('iPad','Kindle','Sony Tablet','Nexus 7','Android Tablet');
        $all_agent = array_merge($ua_sp, $ua_tab);
        
        switch($agent) {
            case 'sp':
                $agent = $ua_sp;
                break;
        
            case 'tab':
                $agent = $ua_tab;
                break;
            
            case 'all':
                $agent = $all_agent;
                break;
                
            default:
                //$agent = '';
                break;
        }
           
        if(is_array($agent)) {
            $agent = implode('|', $agent);
        }
        
        return preg_match('/'. $agent .'/', $_SERVER['HTTP_USER_AGENT']);
    }
    
    static function isLocal()
    {
    	return env('APP_ENV') == 'local';
    }
    
    static function isEnv($envName)
    {
    	return env('APP_ENV') == $envName;
    }
    
}
