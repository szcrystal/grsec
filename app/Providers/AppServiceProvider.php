<?php

namespace App\Providers;

use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

use Mail;
use Ctm;

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
            
            
            $str = config('app.env') . "\n\n";
            $str .= $event->job->getName() . "\n\n";
            $str .= $event->job->getRawBody() . "\n\n";

        	//FailedJobはOrderMails.php内で、->with[ templ...]のラインをコメントアウトし、サンクスメールを送信すれば確認できる。
            //この辺りを変更した後は、php artisan queue:restart が必要となる
            Mail::raw($str, function ($message) {
            	
                if(Ctm::isEnv('product') || Ctm::isEnv('alpha')) {
                    $message -> from('no-reply@green-rocket.jp', 'GR-SYSTEM')
                             -> to(env('FAILED_JOB_MAIL'))
                             -> cc('szk.create@gmail.com')
                             -> subject('Failed Job Information');
                }
                else {
                	$message -> from('no-reply@green-rocket.jp', 'GR-SYSTEM')
                             -> to('szk.create@gmail.com')
                             -> subject('Failed Job Information');
                }
                
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
