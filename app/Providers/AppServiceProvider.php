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
        
        Queue::failing(function (JobFailed $event) {
        	
            //return redirect('dashboard/');
 
            $event->connectionName;
            $event->job;
            $event->exception;
            
            $str = '/' . env('APP_ENV') . var_dump($event->exception->getMessage());
            //$event->job->getName();
                    
            Mail::raw($str, function ($message) {
                $message -> from('no-reply@green-rocket.jp', '送信元の名前')
                         -> to('szk.create@gmail.com', 'サンプル')
                         -> subject('Failed Job Information');
            });

        });
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
