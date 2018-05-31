<?php

namespace App\Http\Controllers\Main;

use App\Contact;
use App\Setting;
use App\MailTemplate;

use Mail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
//        $objs = $this->category->all();
//        
//        $cate_option = $objs->map(function ($obj) {
//            return $obj->category;
//        });
		
  		$cate_option = [
    		'商品について',
      		'商品の入荷時期について',
        	'配送方法・送料について',
         	'ご注文後の変更について',
          	'サイトの使用方法について',
           	'その他',              
        ];

//        $atclObj = NULL;
//        $select = '';
//        if($id) {
//            $atclObj = $this->article->find($id);
//            $select = '削除依頼';
//        }

        return view('main.contact.index', ['cate_option'=>$cate_option/*, 'atclObj'=>$atclObj, 'select'=>$select*/]);
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
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255', /* |unique:admins 注意:unique */
//            'admin_password' => 'required|min:6',
        ];
        
        $messages = [
            'name.required' => '「商品名」を入力して下さい。',
            'email.required' => '「メールアドレス」を入力して下さい。',
            
            //'post_thumb.filenaming' => '「サムネイル-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'post_movie.filenaming' => '「動画-ファイル名」は半角英数字、及びハイフンとアンダースコアのみにして下さい。',
            //'slug.unique' => '「スラッグ」が既に存在します。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all();
        
        $contactModel = $this->contact;
        
        $contactModel -> status = 0;
        $contactModel->fill($data); //モデルにセット
        $contactModel->save(); //モデルからsave
        //$id = $postModel->id;
        
        
        $this->sendMail($data);
        //$this->fakeMail($data);
        

        return view('main.contact.done')->with('status', '送信されました！');
        //return redirect('mypage/'.$id.'/edit')->with('status', '記事が追加されました！');
        
    }
    
    private function sendMail($data)
    {
    	$set = $this->setting->first();
     	
                
     	$template = $this->mailTemplate->where(['type_code'=>'inquire'])->first();
            
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
            $message -> from($admin_email, $admin_name)
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
