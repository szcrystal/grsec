<?php

namespace App\Mail;

use App\Setting;
use App\MailTemplate;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactSend extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $setting;

	public $isUser;
    
    
    public function __construct($data, $isUser)
    {
        $this->data = $data;
        $this->setting = Setting::get()->first();
        
        $this->isUser = $isUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $templ = MailTemplate::where(['type_code'=>'contact'])->get()->first();
      
      	$subject = $this->isUser ? $templ->title : 'お問い合わせがありました。-'. $this->data['ask_category'] . '-';

        //return $this->from($this->setting->admin_email, $this->setting->admin_name)
        return $this->from('no-reply@green-rocket.jp', $this->setting->admin_name)
        			->view('emails.contact')
           			->with([
              			'header' => $templ->header,
                        'footer' => $templ->footer, 
                        //'sales' => $sales,
                        //'order_number' => $this->order_number,
                      	//'setting' => $set,
//                        'receiver' => $this->receiver,
                        //'is_user' => 1,        
                    ])
                    ->subject($subject);
    }
}
