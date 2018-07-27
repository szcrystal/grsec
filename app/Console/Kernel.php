<?php

namespace App\Console;

//use App\Sale;
//use App\SaleRelation;
//use App\Item;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

//use DateTime;

use App\Jobs\ProcessFollowMail;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    	$schedule->job(new ProcessFollowMail)
                ->dailyAt('5:00');
                //->everyMinute();
        
    	//$schedule->call(function () {

 
/*
            $sales = Sale::get();
            $ensureSales = array();
            
            $ensure_7 = array();
            $ensure_33 = array();
            $ensure_96 = array();
            $ensure_155 = array();
            
            $noEnsure_33 = array();
            
            $current = new DateTime('now'); 
            
            foreach($sales as $sale) {
                
                //$d = strtotime($sale->deli_start_date);
                $from = new DateTime($sale->deli_start_date);
                $diff = $current->diff($from);
                
                $ensure = Item::find($sale->item_id)->is_ensure;
                
                if($ensure) {
                    if($diff->days == 7) {
                        $ensure_7[$sale->salerel_id][] = $sale;
                    }
                    elseif($diff->days == 33) {
                        $ensure_33[$sale->salerel_id][] = $sale;
                    }
                    elseif($diff->days == 96) {
                        $ensure_96[$sale->salerel_id][] = $sale;
                    }
                    elseif($diff->days == 155) {
                        $ensure_155[$sale->salerel_id][] = $sale;
                    }
                }
                else {
                    if($diff->days == 33) {
                        $noEnsure_33[$sale->salerel_id][] = $sale;
                    }
                }
            
            }    
                
            if(count($ensure_7) > 0) {
                ProcessFollowMail::dispatch($ensure_7, 7, true);
            }
            
            if(count($ensure_33) > 0) {
                ProcessFollowMail::dispatch($ensure_33, 33, true);
            }
            
            if(count($ensure_96) > 0) {
                ProcessFollowMail::dispatch($ensure_96, 96, true);
            }
            
            if(count($ensure_155) > 0) {
                ProcessFollowMail::dispatch($ensure_155, 155, true);
            }
            
            if(count($noEnsure_33) > 0) {
                ProcessFollowMail::dispatch($noEnsure_33, 33, false);
            }
*/
                
/*
    //        $limitDay = new DateTime(date('Y-m-d', $limit));
    //        $current = new DateTime('now');
    //        $diff = $current->diff($limitDay);       
    //        return ['limit'=>date('Y/m/d', $limit), 'diffDay'=>$diff->days];

    
//    		foreach($ensure_33 as $relIdKey => $saleArr) {
//            
//                //$data = array();
//                
//                foreach($saleArr as $sale) {
//                    $saleRel = SaleRelation::find($sale->salerel_id);
//                    
//                    if($saleRel->is_user) {
//                        $u = User::find($saleRel->user_id);
//                    }
//                    else {
//                        $u = UserNoregist::find($saleRel->user_id);
//                    }
//                    
//                    $mailAdd = $u->email;
//                    $name = $u->name;
//                    
//                    break;
//                    
//                    //$item = Item::find($sale->item_id);
//                }
//            }
//            
//            echo $mailAdd . $name;
//            exit;
*/
    

//            ProcessMagazine::dispatch($users['user'], $data, 1); /*->onQueue('magazine')*/
//            ProcessMagazine::dispatch($users['noUser'], $data, 0)->delay(now()->addMinutes(5));


        //})->dailyAt('1:00');
        //})->everyMinute();
        
        
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
