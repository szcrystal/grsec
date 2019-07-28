<?php

namespace App\Mail;

use App\Setting;
use App\MailTemplate;
use App\Item;
use App\SaleRelation;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FollowMail extends Mailable
{
    use Queueable, SerializesModels;

    public $setting;
    public $name;
    public $isEnsure;
    
    public $itemModel;
    
    
    public function __construct($relIdKey, $sales, $typeCode, $name)
    {
        $this->setting = Setting::get()->first();
        
        $this->relId = $relIdKey;
        $this->sales = $sales;
        $this->typeCode = $typeCode;
        $this->isEnsure = 1;
        
        $this->name = $name;
        
        $this->itemModel = new Item;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//    	if($this->dayKey == 7) {
//        	$templ = MailTemplate::where(['type_code'=>'ensure_7', ])->get()->first();
//        }
//    	elseif($this->dayKey == 33) {
//            if($this->isEnsure) {
//        		$templ = MailTemplate::where(['type_code'=>'ensure_33', ])->get()->first();
//            }
//            else {
//            	$templ = MailTemplate::where(['type_code'=>'no_ensure_33', ])->get()->first();
//            }
//        }
//        elseif($this->dayKey == 96) {
//        	$templ = MailTemplate::where(['type_code'=>'ensure_96', ])->get()->first();
//        }
//        elseif($this->dayKey == 155) {
//        	$templ = MailTemplate::where(['type_code'=>'ensure_155', ])->get()->first();
//        }

		if($this->typeCode == 'no_ensure_33') {
        	$this->isEnsure = 0;
        }
        
        $templ = MailTemplate::where(['type_code'=>$this->typeCode])->get()->first();
        
        $saleRel = SaleRelation::find($this->relId);
      
      	$subject = $templ->title;

        //return $this->from($this->setting->admin_email, $this->setting->admin_name) //env('ADMIN_NAME', 'GREEN ROCKET')
        return $this->from('no-reply@green-rocket.jp', $this->setting->admin_name)
        			->view('emails.followMail')
           			->with([
              			'header' => $templ->header,
                        'footer' => $templ->footer, 
                        'sales' => $this->sales,
                        'saleRel' => $saleRel,
                      	//'setting' => $set,
//                        'receiver' => $this->receiver,
                        //'is_user' => 1,        
                    ])
                    ->subject($subject);
    }
}
