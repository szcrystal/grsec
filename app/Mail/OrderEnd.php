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

class OrderEnd extends Mailable
{
    use Queueable, SerializesModels;

	//public $data;
	
	public $saleRel;
	public $sales;
	
	public $user;
    public $receiver;
	
	public $setting;
	public $pmModel;
	public $itemModel;
	
	public $mailTemplate;

	public $isUser;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($saleRelId, $isUser)
    {
        $this->setting = Setting::get()->first();
        
        $this->saleRelId = $saleRelId; 
        
        $this->saleRel = SaleRelation::find($saleRelId);
        $this->sales = Sale::where(['salerel_id'=>$this->saleRel->id])->get();       
       
          
        if($this->saleRel->is_user) 
            $this->user = User::find($this->saleRel->user_id);
        else
            $this->user = UserNoregist::find($this->saleRel->user_id);
        
        $this->receiver = Receiver::find($this->saleRel->receiver_id);
        
        $this->pmModel = new PayMethod;
        $this->itemModel = new Item;
        
        $this->isUser = $isUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    	//$set = Setting::get()->first();
        
     	$templ = MailTemplate::where(['type_code'=>'itemEnd', ])->get()->first();

        return $this->from($this->setting->admin_email, $this->setting->admin_name)
        			->view('emails.itemEnd')
           			->with([
              			'header' => $templ->header,
                        'footer' => $templ->footer, 
                        //'sales' => $sales,
                        //'order_number' => $this->order_number,
                      	//'setting' => $set,
//                        'receiver' => $this->receiver,
                        //'is_user' => 1,        
                    ])
                    ->subject($templ->title);
        
       
    }
}
