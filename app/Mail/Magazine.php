<?php

namespace App\Mail;

use App\Setting;
use App\MailTemplate;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Magazine extends Mailable
{
    use Queueable, SerializesModels;

    public $setting;
    public $data;
        
    
    public function __construct($data)
    {
        $this->setting = Setting::get()->first();
        
        $this->data = $data;
        
//        $this->saleRelId = $saleRelId; 
//        
//        $this->saleRel = SaleRelation::find($saleRelId);
//        $this->sales = Sale::where(['salerel_id'=>$this->saleRel->id])->get();       
//       
//          
//        if($this->saleRel->is_user) 
//            $this->user = User::find($this->saleRel->user_id);
//        else
//            $this->user = UserNoregist::find($this->saleRel->user_id);
//        
//        $this->receiver = Receiver::find($this->saleRel->receiver_id);
//        
//        $this->pmModel = new PayMethod;
//        $this->itemModel = new Item;
//        
//        $this->isUser = $isUser;
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
      
      	$subject = $this->data['title'];

        //return $this->from($this->setting->admin_email, $this->setting->admin_name) //env('ADMIN_NAME', 'GREEN ROCKET')
        return $this->from(env('ADMIN_EMAIL', 'no-reply@green-rocket.jp'), $this->setting->admin_name)
        			->view('emails.magazine')
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
