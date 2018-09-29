<?php

namespace App\Jobs;

use App\Sale;
use App\SaleRelation;
use App\User;
use App\UserNoregist;
use App\Item;

use App\Mail\FollowMail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use DateTime;


class ProcessFollowMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//    public $sale;
//    public $dayKey;
//    public $isEnsure;
    
    
    public function __construct()
    {
		
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
	   	//$ss = $this->sales;
		
        $sales = Sale::where('deli_done', 1)->get();
                    
        $ensure_7 = array();
        $ensure_33 = array();
        $ensure_96 = array();
        $ensure_155 = array();
        $noEnsure_33 = array();
        
        // For Test ==================================================================
        $day_7 = 7;
        $day_33 = 33;
        $day_96 = 96;
        $day_155 = 155;
        $dayNo_33 = 33;
        
        $current = new DateTime('now'); 
            
        foreach($sales as $sale) {
            
            $from = new DateTime($sale->deli_start_date);
            $diff = $current->diff($from);
            
            $ensure = Item::find($sale->item_id)->is_ensure;
            
            if($ensure) {
                if($diff->days == 0 && $diff->h == 0 && $diff->i == 3) {
                    $ensure_7[$sale->salerel_id][] = $sale;
                
                //elseif($diff->days == $day_33) 
                    $ensure_33[$sale->salerel_id][] = $sale;
                
                //elseif($diff->days == $day_96) 
                    $ensure_96[$sale->salerel_id][] = $sale;
                
                //elseif($diff->days == $day_155) 
                    $ensure_155[$sale->salerel_id][] = $sale;
                }
                
            }
            else {
                //if($diff->days == $dayNo_33) 
                    $noEnsure_33[$sale->salerel_id][] = $sale;
                
            }
        
        }
        // For Test END ==================================================================
        
        
        /* For 本番 ========================================================== 
        $day_7 = 7;
        $day_33 = 33;
        $day_96 = 96;
        $day_155 = 155;
        $dayNo_33 = 33;
        
        $current = new DateTime('now'); 
            
        foreach($sales as $sale) {
            
            //$d = strtotime($sale->deli_start_date);
            $from = new DateTime($sale->deli_start_date);
            $diff = $current->diff($from);
            
            $ensure = Item::find($sale->item_id)->is_ensure;
            
            if($ensure) {
                if($diff->days == $day_7) {
                    $ensure_7[$sale->salerel_id][] = $sale;
                }
                elseif($diff->days == $day_33) {
                    $ensure_33[$sale->salerel_id][] = $sale;
                }
                elseif($diff->days == $day_96) {
                    $ensure_96[$sale->salerel_id][] = $sale;
                }
                elseif($diff->days == $day_155) {
                    $ensure_155[$sale->salerel_id][] = $sale;
                }
            }
            else {
                if($diff->days == $dayNo_33) {
                    $noEnsure_33[$sale->salerel_id][] = $sale;
                }
            }
        
        }
        For 本番 END ==========================================================  */   
                
        if(count($ensure_7) > 0) {
        	$this->sendFollowMail($ensure_7, 'ensure_7'); //Obj, typeCode
            //ProcessFollowMail::dispatch($ensure_7, 7, true);
        }
        
        if(count($ensure_33) > 0) {
            $this->sendFollowMail($ensure_33, 'ensure_33');
        }
        
        if(count($ensure_96) > 0) {
            $this->sendFollowMail($ensure_96, 'ensure_96');
        }
        
        if(count($ensure_155) > 0) {
            $this->sendFollowMail($ensure_155, 'ensure_155');
        }
        
        if(count($noEnsure_33) > 0) {
        	$this->sendFollowMail($noEnsure_33, 'no_ensure_33');
            //ProcessFollowMail::dispatch($noEnsure_33, 33, false);
        }  
        
    }
    
    public function sendFollowMail($saleObjs, $typeCode)
    {
    	foreach($saleObjs as $relIdKey => $saleArr) {
            
            $saleRel = SaleRelation::find($relIdKey);
                
            if($saleRel->is_user) {
                $u = User::find($saleRel->user_id);
            }
            else {
                $u = UserNoregist::find($saleRel->user_id);
            }
            
            $mailAdd = $u->email;
            $name = $u->name;
            
            
            //$message = (new Magazine($data));
            //$when = now()->addMinutes(10);
            Mail::to($mailAdd, $name)->send(new FollowMail($relIdKey, $saleArr, $typeCode, $name));
            //Mail::to($mailVal, $nameKey)->send(new Magazine($data));
        }
    }
    
    public function failed(Exception $exception)
    {
		Mail::raw($exception->getMessage(), function ($message) {
    		$message -> from('info@green-rocket.jp', '送信元の名前')
                     -> to('crunch.butter777@gmail.com', 'サンプル')
                     -> subject('queue-exception');
		});
    }
}
