<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\Contact;
use App\Sale;
use App\Item;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;

use App\Mail\NoStocked;
    
use Auth;
use Mail;
use DateTime;

class MainController extends Controller
{
    public function __construct(Admin $admin, Contact $contact/*, Tag $tag, Article $article, Totalize $totalize*/)
    {
        
        $this -> middleware('adminauth'/*, ['except' => ['getRegister','postRegister']]*/);
//        //$this->middleware('auth:admin', ['except' => 'getLogout']);
//        //$this -> middleware('log', ['only' => ['getIndex']]);
//        
        $this -> admin = $admin;
        $this-> contact = $contact;
//        $this -> totalize = $totalize;
        
        $this->perPage = 20;
        
        // URLの生成
        //$url = route('dashboard');
        
    }
    
    
    public function index()
    {
    	$adminUser = Auth::guard('admin')->user();
     
     	$data = array();
      	$data['is_user'] = 1;
       	$data['user_name'] = "aaa";
        
//        $sales = Sale::all();
//        print_r($sales);
//		exit;        
//        $from = new DateTime('2018-07-26 17:40:47');
//        $current = new DateTime('now');
//        
//        $diff = $current->diff($from);
//        echo $diff->days;
//        exit;
        
//        $stockNone = [1];
        
//        if(count($stockNone) > 0) {
//        	
//        	$str = '下記商品の在庫がなくなりました。'. "\n\n";
//            
//            foreach($stockNone as $itemIdVal) {
//            	$str .= Item::find($itemIdVal)->number. "\n";
//            	$str .= Item::find($itemIdVal)->title. "\n";
//        		$str .= url('dashboard/items/'. $itemIdVal). "\n\n";
//            }
//        
//        	
//            //Mail::later(now()->addMinutes(1), new NoStocked($str));
//            Mail::queue(new NoStocked($str));
//            
////            Mail::raw($str, function ($message) {
////            	$setting = Setting::get()->first();
////                
////                $message -> from('no-reply@green-rocket.jp', $setting->admin_name)
////                         -> to($setting->admin_email, $setting->admin_name)
////                         -> subject('商品の在庫がなくなりました。');
////                         
////            })
////            //-> later(now()->addMinutes(1), new NoStocked());
////            -> queue(new NoStocked());
//        }
        
//        $now = new DateTime('now');
//        $nowDay = $now->format('d');
//        echo $nowDay + 1;
//        exit;
        
//        $now = new DateTime('now');
//        $nowMonth = $now->format('n');
//        
//        $items = Item::get();
//        
//        foreach($items as $item) {
//        	if($nowMonth == $item->stock_reset_month) {
//            	$item->stock = $item->stock_reset_count;
//                $item->save();
//            }
//        }
//   
//        exit;
        
        $current = new DateTime('now'); 
   
        //$d = strtotime($sale->deli_start_date);
        $from = new DateTime('2018-09-29 14:44:23');
        $diff = $current->diff($from);
        
        echo date('Y-m-d H:i:s', time());
        print_r($diff);
        exit;
        echo $diff->time;
        exit;
            
            
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
  
        $str = env('REMOTE_ADDR', '') . "\n" . env('HTTP_USER_AGENT', '');
        //$str .= "<br>abcde" . '<a href="https://192.168.10.16">abcde</a>';
        
        Mail::raw($str, function ($message) {
    		$message -> from('no-reply@green-rocket.jp', '送信元の名前')
                     -> to('szk.create@gmail.com', 'サンプル')
                     -> subject('お問い合わせの送信が完了しました。');
		});
            
//        Mail::send('emails.contact', $data, function($message) use ($data) //引数について　http://readouble.com/laravel/5/1/ja/mail.html
//        {
//            //$dataは連想配列としてviewに渡され、その配列のkey名を変数としてview内で取得出来る
//            $message -> from(env('ADMIN_EMAIL'), env('ADMIN_NAME'))
//                     -> to('szk.create@gmail.com', 'sample')
//                     -> subject('お問い合わせの送信が完了しました');
//            //$message->attach($pathToFile);
//        });  
     	   
        //return view('dashboard.index', ['name'=>$adminUser->name]);
        return redirect('dashboard/register');
    }
    
    private function sendMail($data)
    {
        $data['is_user'] = 1;
        Mail::send('emails.contact', $data, function($message) use ($data) //引数について　http://readouble.com/laravel/5/1/ja/mail.html
        {
            //$dataは連想配列としてviewに渡され、その配列のkey名を変数としてview内で取得出来る
            $message -> from(env('ADMIN_EMAIL'), env('ADMIN_NAME'))
                     -> to($data['user_email'], $data['user_name'])
                     -> subject('お問い合わせの送信が完了しました');
            //$message->attach($pathToFile);
        });
        
        //for Admin
        $data['is_user'] = 0;
        //if(! env('MAIL_CHECK', 0)) { //本番時 env('MAIL_CHECK')がfalseの時
            Mail::send('emails.contact', $data, function($message) use ($data)
            {
                $message -> from(env('ADMIN_EMAIL'), env('ADMIN_NAME'))
                         -> to(env('ADMIN_EMAIL'), env('ADMIN_NAME'))
                         -> subject('お問い合わせがありました - '. config('app.name', 'MovieReview'). ' -');
            });
    }
    
    
    
    

    public function getRegister ($id='')
    {
        $editId = 0;
        $admin = NULL;
        
        if($id) {
            $editId = $id;
            $admin = $this->admin->find($id);
        }
        
        $admins = $this->admin->paginate($this->perPage);
        
        return view('dashboard.register', ['admins'=>$admins, 'admin'=>$admin, 'editId'=>$editId]);
    }
    
    public function postRegister(Request $request)
    {
        $editId = $request->input('edit_id');
        $valueId = '';
        if($editId) {
            $valueId = ','. $editId;
        }
        
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins,email'.$valueId, /* |unique:admins 注意:unique */
            'password' => 'required|min:8',
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        if($data['edit_id']) {
            $adminModel = $this->admin->find($data['edit_id']);
        }
        else {
            $adminModel = $this->admin;
        }
        
        $data['password'] = bcrypt($data['password']);
        
        $adminModel->fill($data);
        $adminModel->save();
        
        //Save&手動ログイン：以下でも可 :Eroquent ORM database/seeds/UserTableSeeder内にもあるので注意
//        $admin = Admin::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => bcrypt($data['password']),
//            //'admin' => 99,
//        ]);
        
        if($editId)
            $status = '管理者情報を更新しました！';
        else
            $status = '管理者:'.$data['name'].'さんが追加されました。';
        
        return redirect('dashboard/register')->with('status', $status);
    }
    
    
    public function getLogout(Request $request) {
        //$request->session()->pull('admin');
        Auth::guard('admin')->logout();
        return redirect('dashboard/login'); //->intended('/')
    }
    
    
    public function destroy($id)
    {
        $name = $this->admin->find($id)->name;
        
//        $atcls = $this->item->where('cate_id', $id)->get()->map(function($item){
//            $item->cate_id = 0;
//            $item->save();
//        });
        
        $adminDel = $this->admin->destroy($id);
        
        $status = $adminDel ? '管理者「'.$name.'」さんが削除されました' : '管理者「'.$name.'」さんが削除出来ませんでした';
        
        return redirect('dashboard/register')->with('status', $status);
    }
}
