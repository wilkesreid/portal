<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);
        
        $gate->define('update-admin-settings', function($user){
	        return $user->role() == "administrator";
        });
        
        $gate->define('view-passwords', function($user) {
	        return $user->role() != "pending";
        });
        
        $gate->define('edit-clients', function($user) {
	        return ($user->role() == "administrator");
        });
        
        $gate->define('edit-platforms', function($user) {
	        return ($user->role() == "administrator");
        });
        
        $gate->define('edit-passwords', function($user) {
	        return ($user->role() == "administrator");
        });

        //
    }
}
