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
        
        // Actions
        
        $gate->before(function($user){
	    	if ($user->role() == "administrator") {
		    	return true;
	    	} 
        });
        
        /*$abilities = [
	        'view-passwords',
			'edit-passwords',
			'view-websites',
			'edit-websites',
			'delete-websites',
			'edit-clients',
			'delete-clients',
			'edit-platforms',
			'delete-platforms',
			'security-menu',
			'admin-menu',
			'update-admin-settings'
        ];
        foreach ($abilities as $ability) {
	        $gate->define($ability, function($user) {
		        $user_abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
		        echo $ability."<br>";
		        if (in_array($ability,$user_abilities)) {
			        return true;
		        } else {
			        return false;
		        }
	        });
        }*/
        
        
	    $gate->define('update-admin-settings', function($user){
	        
        });
	        
	    $gate->define('view-passwords', function($user) {
	        $abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
	        //return ($user->role() == "team member" || $user->role() == "administrator");
	        if (in_array('view-passwords',$abilities)) {
		        return true;
	        } else {
		        return false;
	        }
        });
        
        $gate->define('view-management-passwords', function($user) {
	        $abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
	        //return ($user->role() == "team member" || $user->role() == "administrator");
	        if (in_array('view-management-passwords',$abilities)) {
		        return true;
	        } else {
		        return false;
	        }
        });
        
        $gate->define('edit-clients', function($user) {
	        $abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
	        if (in_array('edit-clients',$abilities)) {
		        return true;
	        } else {
		        return false;
	        }
	        //return ($user->role() == "team member" || $user->role() == "administrator");
        });
        
        $gate->define('delete-clients', function($user) {
	        $abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
	        if (in_array('delete-clients',$abilities)) {
		        return true;
	        } else {
		        return false;
	        }
	        //return ($user->role() == "administrator"); 
        });
        
        $gate->define('edit-platforms', function($user) {
	        $abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
	        if (in_array('edit-platforms',$abilities)) {
		        return true;
	        } else {
		        return false;
	        }
	        //return ($user->role() == "team member" || $user->role() == "administrator");
        });
        
        $gate->define('delete-platforms', function($user) {
	        $abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
	        if (in_array('delete-platforms',$abilities)) {
		        return true;
	        } else {
		        return false;
	        }
	        //return ($user->role() == "administrator"); 
        });
        
        $gate->define('edit-passwords', function($user) {
	        $abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
	        if (in_array('edit-passwords',$abilities)) {
		        return true;
	        } else {
		        return false;
	        }
	        //return ($user->role() == "administrator");
        });
        $gate->define('edit-management-passwords', function($user) {
	        $abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
	        if (in_array('edit-management-passwords',$abilities)) {
		        return true;
	        } else {
		        return false;
	        }
	        //return ($user->role() == "administrator");
        });
        
        $gate->define('view-websites', function($user){
	        $abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
	        if (in_array('view-websites',$abilities)) {
		        return true;
	        } else {
		        return false;
	        }
	        //return ($user->role() != "pending");
        });
        
        $gate->define('edit-websites', function($user) {
	        $abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
	        if (in_array('edit-websites',$abilities)) {
		        return true;
	        } else {
		        return false;
	        }
	        //return ($user->role() != "pending");
        });
        
        $gate->define('delete-websites', function($user) {
	        $abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
	        if (in_array('delete-websites',$abilities)) {
		        return true;
	        } else {
		        return false;
	        }
	        //return ($user->role() != "pending");
        });
        
        // Menu access
        
        $gate->define('security-menu', function($user) {
	       $abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
	       if (in_array('security-menu',$abilities)) {
		        return true;
	        } else {
		        return false;
	        }
	       //return ($user->role() != "intern" && $user->role() != "pending"); 
        });
        $gate->define('admin-menu', function($user) {
	        
        });
        
        $gate->define('edit-tactics', function($user){
            $abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
            if (in_array('edit-tactics',$abilities)) {
                return true;
            } else {
                return false;
            }
        });
        
        $gate->define('create-milestone', function($user) {
            $abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
            if (in_array('create-milestone',$abilities)) {
                return true;
            } else {
                return false;
            }
        });
        
        $gate->define('do-admin-things', function($user) {
            $abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
            if (in_array('do-admin-things',$abilities)) {
                return true;
            } else {
                return false;
            }
        });
        
        $gate->define('use-tools-menu', function($user) {
            $abilities = json_decode(\App\Role::where('name',$user->role())->first()->abilities);
            if (in_array('use-tools-menu',$abilities)) {
                return true;
            } else {
                return false;
            }
        });
		

        //
    }
}
