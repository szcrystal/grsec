<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
