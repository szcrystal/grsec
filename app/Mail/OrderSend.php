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

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderSend extends Mailable
{
    use Queueable, SerializesModels;

	public $saleIds;
    //public $sales;
    
//    public $user;
//    public $receiver;
    
    public $setting;
    public $pmModel;
    public $itemModel;
    
    public $mailTemplate;

    //public $isUser;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($saleIds)
    {
        $this->setting = Setting::get()->first();
        
        $this->saleIds = $saleIds; 
        
//        $this->saleRel = SaleRelation::find($saleRelId);
//        $this->sales = Sale::where(['salerel_id'=>$this->saleRel->id])->get();       
       
          
        
        
        $this->pmModel = new PayMethod;
        $this->itemModel = new Item;
        
        //$this->isUser = $isUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $templ = MailTemplate::where(['type_code'=>'itemDelivery', ])->get()->first();
        
        $sales = Sale::find($this->saleIds);
        $saleRelId = $sales->first()->salerel_id;
        
        $saleRel = SaleRelation::find($saleRelId);
        
        if($saleRel->is_user) 
            $user = User::find($saleRel->user_id);
        else
            $user = UserNoregist::find($saleRel->user_id);
        

        $receiver = Receiver::find($saleRel->receiver_id);

        return $this->from($this->setting->admin_email, $this->setting->admin_name)
                    ->view('emails.orderSend')
                    ->with([
                          'header' => $templ->header,
                        'footer' => $templ->footer, 
                        'sales' => $sales,
                        'saleRel' => $saleRel,
                        'user' => $user,
                        'receiver' => $receiver,
                        'isUser' => 1,        
                    ])
                    ->subject($templ->title);
    }
}
