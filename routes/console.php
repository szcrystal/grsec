<?php

use Illuminate\Foundation\Inspiring;

use App\Setting;
use App\User;
use App\UserNoregist;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


// Set Setting For Local ===============
Artisan::command('setsetting', function () {
    $set = Setting::first();
    
    $set->admin_email = 'red.beryl@zoho.com';
    $set->admin_forward_email = 'opal@frank.fam.cx';
    $set->is_product = 0;
    $set->analytics_code = '';
    
    $set->save();
    
    $this->comment('Set Setting done');
});


// Set User Address3 ==================
Artisan::command('useraddr3', function () {
    $users = User::all();
    
    foreach($users as $user) {
        $addr_1 = $user->address_1 . $user->address_2;
        $addr_2 = $user->address_3;
        
        $user->address_1 = $addr_1;
        $user->address_2 = $addr_2;
        $user->address_3 = null;
        $user->save();
    }
    
    $this->comment('User change address3 done');
});

Artisan::command('nouseraddr3', function () {
    $noUsers = UserNoregist::all();
    
    foreach($noUsers as $noUser) {
        $addr_1 = $noUser->address_1 . $noUser->address_2;
        $addr_2 = $noUser->address_3;
        
        $noUser->address_1 = $addr_1;
        $noUser->address_2 = $addr_2;
        $noUser->address_3 = null;
        $noUser->save();
    }
    
    $this->comment('NoUser change address3 done');
});




