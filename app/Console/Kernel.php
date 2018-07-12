<?php

namespace App\Console;

use App\Sale;
use App\SaleRelation;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use DateTime;

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
        $sales = Sale::get();
        $saleForMail = array();
        
        $saleNo33 = array();
        
        $current = new DateTime('now'); 
        
        foreach($sales as $sale) {
        	
        	//$d = strtotime($sale->deli_start_date);
            $from = new DateTime($sale->deli_start_date);
            $diff = $current->diff($from);
            
            $ensure = Item::find($sale->item_id)->is_ensure;
            
            if($ensure) {
                if($diff->days == 7) {
                    $saleForMail[7] = $sale;
                }
                elseif($diff->days == 33) {
                	$saleForMail[33] = $sale;
                }
                elseif($diff->days == 96) {
                	$saleForMail[96] = $sale;
                }
                elseif($diff->days == 155) {
                	$saleForMail[155] = $sale;
                }
            }
            else {
            	if($diff->days == 33) {
                	
                }
            }
            

//        $limitDay = new DateTime(date('Y-m-d', $limit));
//        $current = new DateTime('now');
//        $diff = $current->diff($limitDay);
//        
//        return ['limit'=>date('Y/m/d', $limit), 'diffDay'=>$diff->days];

		}
        print_r($saleForMail);
        exit;

        
        
    	$schedule->call(function () {
            ProcessMagazine::dispatch($users['user'], $data, 1); /*->onQueue('magazine')*/
            ProcessMagazine::dispatch($users['noUser'], $data, 0)->delay(now()->addMinutes(5));
        })->dailyAt('1:00');
        
        
        
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
