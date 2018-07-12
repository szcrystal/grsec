<?php

namespace App\Jobs;

use App\User;
use App\UserNoregist;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Mail\Magazine;

use Mail;

class ProcessMagazine implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $users;
    public $datas;
    public $isUser;
    
    //public $timeout = 1200;
	
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($users, $datas, $isUser)
    {
    	$this->users = $users;
        $this->datas = $datas;
        $this->isUser = $isUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    	$us = $this->users;
        $data = $this->datas;
        
        //$userModel = $this->isUser ? $u : $nu; 
        
    
    	//foreach($us as $key => $mailArr) {
            foreach($us as $userIdKey => $mailVal) {
            
                $data['name'] = $this->isUser ? User::find($userIdKey)->name : UserNoregist::find($userIdKey)->name;
                //$data['name'] = User::find($userIdKey)->name;
                
                //$message = (new Magazine($data));
                //$when = now()->addMinutes(10);
                
                Mail::to($mailVal, $data['name'])->send(new Magazine($data));
                //Mail::to($mailVal, $nameKey)->send(new Magazine($data));
            }
        //}
        
//        foreach($us['noUser'] as $userIdKey => $mailVal) {
//            $data['name'] = UserNoregist::find($userIdKey)->name;
//            
//            //$message = (new Magazine($data));
//            //$when = now()->addMinutes(10);
//            
//            Mail::to($mailVal, $data['name'])->send(new Magazine($data));
//            //Mail::to($mailVal, $nameKey)->send(new Magazine($data));
//        }
        
        
    }
}
