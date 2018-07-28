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

class PayDone extends Mailable
{
    use Queueable, SerializesModels;

   	public $saleRelId;
    
    public $setting;
    public $pmModel;
    public $itemModel;
    
    public $mailTemplate;
    
    
    public function __construct($saleRelId)
    {
        $this->setting = Setting::get()->first();
        
        $this->saleRelId = $saleRelId;
        //$this->saleIds = $saleIds; 
        
//        $this->saleRel = SaleRelation::find($saleRelId);
//        $this->sales = Sale::where(['salerel_id'=>$this->saleRel->id])->get();       

//        $this->pmModel = new PayMethod;
//        $this->itemModel = new Item;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    	$this->pmModel = new PayMethod;
        $this->itemModel = new Item;
        
        $templ = MailTemplate::where(['type_code'=>'payDone', ])->get()->first();
        
        $saleRel = SaleRelation::find($this->saleRelId);
        
        $sales = Sale::where('order_number', $saleRel->order_number)->get();
        //$saleRelId = $sales->first()->salerel_id;
        
        $payName = $this->pmModel->find($saleRel->pay_method)->name;
        
        if($saleRel->is_user) 
            $user = User::find($saleRel->user_id);
        else
            $user = UserNoregist::find($saleRel->user_id);
        

        $receiver = Receiver::find($saleRel->receiver_id);

        //return $this->from($this->setting->admin_email, $this->setting->admin_name)
        return $this->from(env('ADMIN_EMAIL', 'no-reply@green-rocket.jp'), $this->setting->admin_name)
                    ->view('emails.payDone')
                    ->with([
                        'header' => $templ->header,
                        'footer' => $templ->footer, 
                        'sales' => $sales,
                        'saleRel' => $saleRel,
                        'payName' => $payName,
                        'user' => $user,
                        'receiver' => $receiver,
                        'isUser' => 1,        
                    ])
                    ->subject($templ->title);

    }
}
