<?php

namespace App\Mail;

use App\Setting;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NoStocked extends Mailable
{
    use Queueable, SerializesModels;
    
    public $str;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($str)
    {
    	//$this->setting = Setting::get()->first();
        
        $this->str = $str;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    	$setting = Setting::get()->first();
//        return $this->raw($this->str, function($message){
//        	$setting = Setting::get()->first();
//        	
//            $message -> from('no-reply@green-rocket.jp', $setting->admin_name)
//                     -> to($setting->admin_email, $setting->admin_name)
//                     -> subject('商品の在庫がなくなりました。');
//                     //-> later(now()->addMinutes(10), new NoStocked());
//        });
        
        return $this->from(env('ADMIN_EMAIL', 'no-reply@green-rocket.jp'), $setting->admin_name)
        			-> to($setting->admin_email, $setting->admin_name)
                    ->view('emails.raw')
                    ->with([
                        'str' => $this->str,
//                        'footer' => $templ->footer, 
//                        'sales' => $sales,
//                        'saleRel' => $saleRel,
//                        'payName' => $payName,
//                        'user' => $user,
//                        'receiver' => $receiver,
//                        'isUser' => 1,
						'mail_footer' => $setting->mail_footer,        
                    ])
                    ->subject('商品の在庫がなくなりました。');
    }
}
