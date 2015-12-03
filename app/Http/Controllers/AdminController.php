<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct() {
	    $this->middleware('auth');
	    $this->middleware('admin');
    }
    
    public function saveSettings(Request $request) {
	    $theme = $request->theme;
	    $setting = \App\Setting::get('guest_theme');
	    $setting->value = $theme;
	    $setting->save();
	    
	    return redirect('/admin/settings');
    }
    
    public function saveUser(Request $request) {
	    $settings = \App\User::find($request->user_id)->settings;
	    $role = $request->role;
	    $settings->role = $role;
	    $settings->save();
	    
	    return redirect('/admin/users');
    }
    
    public function deleteUser(Request $request) {
	    $user_id = $request->id;
	    $user = \App\User::find($user_id);
	    $user_settings = $user->settings;
	    $user->forceDelete();
	    $user_settings->forceDelete();
	    
	    
	    return redirect('/admin/users');
    }
    
    public function createRole(Request $request) {
	    $role = $request->role;
	    \App\Role::create([
		    'name' => $role
	    ]);
	    
	    return redirect('/admin/actions');
    }
}