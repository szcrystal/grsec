<?php

namespace App\Providers;

use App\Admin;
use App\Policies\AdminPolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        //Admin::class => AdminPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

		Gate::define('is-super', function ($user) {
            return $user->permission == 1;
        });
        
        Gate::define('is-admin', function ($user) {

            return $user->permission > 0 && $user->permission < 3;
        });
        
        Gate::define('is-designer', function ($user) {
            return $user->permission == 3;
        });
    }
}
