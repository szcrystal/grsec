<?php

namespace App\Http\Controllers\Main;

use App\Contact;
use App\Setting;
use App\MailTemplate;

use App\Mail\ContactSend;

use Mail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Ctm;
use DateTime;

class ContactController extends Controller
{
    public function __construct(Contact $contact, Setting $setting, MailTemplate $mailTemplate, Mail $mail)
    {
        //$this->middleware('auth');
        
        $this-> contact = $contact;
        $this->setting = $setting;
        $this->mailTemplate = $mailTemplate;
        //$this->category = $category;
        //$this->article = $article;
        $this->mail = $mail;
        
        //$this->user = Auth::user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	//ask category
  		$cate_option = [
    		'商品について',
      		'商品の入荷時期について',
        	'配送方法・送料について',
         	'ご注文後の変更について',
          	'サイトの使用方法について',
           	'その他',              
        ];
        
        //request day
        $now = new DateTime('now');
        $nowDate = $now->format('Y-m-d');
        $reqDays = array();
    
        for($plusDay = 1; $plusDay < 21; $plusDay++) {
            
            $d = $plusDay ? $now->modify("+1 days") : $now; //nowにmodifyすると持続されるので+1days
            
            $ymd = $d->format('Y-m-d');
            $w = $d->format('w');
            
            if($w && $w != 6) {
            	$withYoubi = Ctm::getDateWithYoubi($ymd);
	            $reqDays[$withYoubi] = $withYoubi; //引数はstr(Y-m-d)で
            }
        }
        
        //request time
        $reqTimes = [
        	'9:00〜10:00',
            '10:00〜11:00',
            '11:00〜12:00',
            '13:00〜14:00',
            '14:00〜15:00',
            '15:00〜16:00',
        ];


		$title = 'お問い合わせ';
        $type = 'contact';
        
        $metaTitle = $title;
//        $metaDesc = $setting->meta_description;
//        $metaKeyword = $setting->meta_keyword;

        return view('main.contact.index', ['cate_option'=>$cate_option, 'reqDays'=>$reqDays, 'reqTimes'=>$reqTimes, 'metaTitle'=>$metaTitle, 'title'=>$title, 'type'=>$type]);
    }
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    	$isAskType = $request->input('is_ask_type');
         
        $rules = [
        	'ask_category' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
//			'comment' => 'required',
        ];
        
        if(! $isAskType) { //Telの時
        	$telRules = [
            	'tel_num'=>'required|numeric',
                'request_day'=>'required',
                'request_time'=>'required',
            ];
            
            $rules = array_merge($rules, $telRules);
        	//array_splice($rules, 2, 0, $telRules);
        }
        
        $rules['comment'] = 'required'; //Tel/Mail両方
        
        $messages = [
            'comment.required' => '「お問い合わせ内容」は必須です。',
            //'email.required' => '「メールアドレス」を入力して下さい。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all();
        
        
        $request->session()->put('contact', $data);
        
        $metaTitle = 'お問い合わせ 確認';
//        $metaDesc = $setting->meta_description;
//        $metaKeyword = $setting->meta_keyword;
        
        return view('main.contact.confirm', ['data'=>$data, 'metaTitle'=>$metaTitle]);
        
        
//        $contactModel = $this->contact;
//        
//        $contactModel -> status = 0;
//        $contactModel->fill($data); //モデルにセット
//        $contactModel->save(); //モデルからsave
//        //$id = $postModel->id;
//        
//        $data['id'] = $contactModel->id;
//        
//        $this->sendMail($data);
//        //$this->fakeMail($data);
//        
//
//        return view('main.contact.done')->with('status', '送信されました！');
        //return redirect('mypage/'.$id.'/edit')->with('status', '記事が追加されました！');
        
    }
    
    public function postEnd(Request $request)
    {
    	if(! $request->session()->has('contact')) {
        	about(404);
        }
        
        $data = session('contact');
        
//        print_r($data);
//        exit;
        
        $contactModel = $this->contact;
        
        $contactModel -> status = 0;
        $contactModel->fill($data); //モデルにセット
        $contactModel->save(); //モデルからsave
        
        $data['id'] = $contactModel->id;
        
        $setting = $this->setting->get()->first();
        
        //for User
        Mail::to($data['email'], $data['name'])->queue(new ContactSend($data, 1));
        //for Admin
        Mail::to($setting->admin_email, $setting->admin_name)->later(now()->addMinutes(1), new ContactSend($data, 0));
        
        //$this->sendMail($data);
//        //$this->fakeMail($data);
		
        if(! Ctm::isLocal()) {
        	$request->session()->forget('contact');
        }
        
        $metaTitle = 'お問い合わせ 完了';
//        $metaDesc = $setting->meta_description;
//        $metaKeyword = $setting->meta_keyword;
        
        return view('main.contact.done', ['metaTitle'=>$metaTitle])->with('status', '送信されました！');
        //return redirect('mypage/'.$id.'/edit')->with('status', '記事が追加されました！');
        
        
    }
    
    private function sendMail($data)
    {
    	$set = $this->setting->first();
     	
                
     	$template = $this->mailTemplate->where(['type_code'=>'contact'])->first();
            
    	$admin_name = $set->admin_name;
        $admin_email = $set->admin_email; 
        
        $data['mail_footer'] = $set->mail_footer;
        
        $data['title'] = $template->title;
      	$data['header'] = $template->header;
       	$data['footer'] = $template->footer;     
     	   
        $data['is_user'] = 1;
        Mail::send('emails.contact', $data, function($message) use ($data, $admin_email, $admin_name) //引数について　http://readouble.com/laravel/5/1/ja/mail.html
        {
            //$dataは連想配列としてviewに渡され、その配列のkey名を変数としてview内で取得出来る
            $message -> from(env('ADMIN_EMAIL', 'no-reply@green-rocket.jp'), env('ADMIN_NAME', 'GREEN ROCKET'))
                     -> to($data['email'], $data['name'])
                     -> subject($data['title']);
            //$message->attach($pathToFile);
        });
        
        //for Admin
        $data['is_user'] = 0;
        //if(! env('MAIL_CHECK', 0)) { //本番時 env('MAIL_CHECK')がfalseの時
            Mail::send('emails.contact', $data, function($message) use ($data, $admin_email, $admin_name)
            {
                $message -> from($admin_email, $admin_name)
                         -> to($admin_email, $admin_name)
                         -> subject('お問い合わせがありました - ' . $data['ask_category'] . ' -');
            });
    }
    
    private function fakeMail($data)
    {
        Mail::fake();

        // 注文コードの実行…

        Mail::assertSent($this::store(), function ($mail) use ($data) {
            return $mail->name === $data['name'];
        });

        // メッセージが指定したユーザに届いたことをアサート
        Mail::assertSentTo([$data['email']], $this::store());

        // Mailableが送られなかったことをアサート
        Mail::assertNotSent($this::store());
    }
    
    public function aaa()
    {
        //$this->aaa = "aaa";
        return "aaa";
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
