<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Tag;
use App\TagGroup;
use App\TagRelation;
use App\Fix;
use App\TotalizeAll;
use App\Setting;
use App\MailTemplate;

use Mail;
use DateTime;

use Illuminate\Http\Request;

class CustomController extends Controller
{
	public $setting;
	
    public function __construct(Setting $setting, Article $article, Category $category, Tag $tag, TotalizeAll $totalizeAll)
    {
    	$this->setting = $setting;
    	$this->article = $article;
        $this->category = $category;
        $this->tag = $tag;
        $this->totalizeAll = $totalizeAll;
        
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
        
        $r_str = null;
        
        for ($i = 0; $i < 3; $i++) {
            $r_str .= $eng[mt_rand(0, count($eng) - 1)];
        }
        
        //$r_str .= '-';
        
        for ($n = 0; $n < 8; $n++) {
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
    
}
