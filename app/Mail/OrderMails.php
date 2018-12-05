<?php

namespace App\Mail;

use App\Setting;
use App\Sale;
use App\SaleRelation;
use App\User;
use App\UserNoregist;
use App\Receiver;
use App\MailTemplate;
use App\Item;
use App\PayMethod;
use App\PayMethodChild;
use App\DeliveryCompany;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderMails extends Mailable
{
    use Queueable, SerializesModels;

    //public $saleId;
	public $saleIds;
    public $mailId;
    
//    public $user;
//    public $receiver;
    
    public $setting;
    public $pmModel;
    public $pmChildModel;
    public $itemModel;
    public $dcModel;
    
    public $mailTemplate;
    
    
    public function __construct($saleIds, $mailId)
    {
        $this->setting = Setting::get()->first();
        
        //$this->saleId = $saleId;
        $this->saleIds = $saleIds; 
        $this->mailId = $mailId;
        
//        $this->saleRel = SaleRelation::find($saleRelId);
//        $this->sales = Sale::where(['salerel_id'=>$this->saleRel->id])->get();       

//        $this->pmModel = new PayMethod;
//        $this->itemModel = new Item;
        
        //$this->isUser = $isUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    	$this->pmModel = new PayMethod;
        $this->pmChildModel = new PayMethodChild;
        $this->itemModel = new Item;
        $this->dcModel = new DeliveryCompany;
        
        //$templ = MailTemplate::where(['type_code'=>'itemDelivery', ])->get()->first();
        $templ = MailTemplate::find($this->mailId);
        
        //$thisSale = Sale::find($this->saleId);
        
        $sales = Sale::find($this->saleIds);
        $saleRelId = $sales->first()->salerel_id;
        
        $saleRel = SaleRelation::find($saleRelId);
        
        if($saleRel->is_user) 
            $user = User::find($saleRel->user_id);
        else
            $user = UserNoregist::find($saleRel->user_id);
        

        $receiver = Receiver::find($saleRel->receiver_id);

        //return $this->from($this->setting->admin_email, $this->setting->admin_name)
        return $this->from(env('ADMIN_EMAIL', 'no-reply@green-rocket.jp'), $this->setting->admin_name)
                    ->view('emails.orderMails')
                    ->with([
                    	'templ' => $templ, //ここをコメントアウトすればFailedJobの確認ができる
                        //'header' => $templ->header,
                        //'footer' => $templ->footer, 
                        //'thisSale' => $thisSale,
                        'sales' => $sales,
                        'saleRel' => $saleRel,
                        'user' => $user,
                        'receiver' => $receiver,
                        'isUser' => 1,        
                    ])
                    ->subject($templ->title);
    }
}
