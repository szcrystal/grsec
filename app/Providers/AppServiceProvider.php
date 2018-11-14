<?php

namespace App\Providers;

use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

use Mail;

/* **** for dip */
//use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    	/* ***** for dip */
        //Schema::defaultStringLength(191);
        
        Validator::extend('custom_numeric', function ($attribute, $value, $parameters, $validator) {
            return $value == 'foo';
        });
        
        
        //Job失敗時のメール通知 =======================================
        Queue::failing(function (JobFailed $event) {
        	
            //return redirect('dashboard/');
 
            $event->connectionName;
            $event->job;
            $event->exception;
//            $e = $event->exception;
//            $report = report($e);
            
            
            $str = env('APP_ENV') . "\n\n";
            $str .= $event->job->getName() . "\n\n";
            $str .= $event->job->getRawBody() . "\n\n";

                    
            Mail::raw($str, function ($message) {
                $message -> from('no-reply@green-rocket.jp', 'GR-SYSTEM')
                         -> to('szk.create@gmail.com', '')
                         //-> cc('szk.create@gmail.com')
                         -> subject('Failed Job Information');
            });

        });
        //Job失敗時のメール通知 END =======================================
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
