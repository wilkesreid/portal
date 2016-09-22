<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cookie;
use Config;
use Hash;

class AdminController extends Controller
{
    public function __construct() {
	    $this->middleware('auth');
	    $this->middleware('admin');
    }
    
    public function saveSettings(Request $request) {
	    $theme = $request->theme;
	    $website_check_days = $request->website_check_days;
	    $pay_period_one = $request->pay_period_one;
	    $pay_period_two = $request->pay_period_two;
	    
	    $setting = \App\Setting::get('guest_theme');
	    $setting->value = $theme;
	    $setting->save();
	    
	    $setting = \App\Setting::get('website_check_days');
	    $setting->value = $website_check_days;
	    $setting->save();
	    
	    $setting = \App\Setting::get('pay_period_one');
	    $setting->value = $pay_period_one;
	    $setting->save();
	    
	    $setting = \App\Setting::get('pay_period_two');
	    $setting->value = $pay_period_two;
	    $setting->save();
	    
	    return redirect('/admin/settings');
    }
    
    public function saveEncryptionKey(Request $request) {
	    $key = $request->key;
	    
	    // Check if key is a valid key for the cipher
	    if (\Illuminate\Encryption\Encrypter::supported($key,"AES-256-CBC") != true) {
		    return redirect('/admin/security')->with('key','invalid');
	    }
	    
	    // Get old hashed encryption key from database
	    $key_hash = \App\Setting::where('name','encryption_key')->first()->value;
	    
	    // Get current client-provided key
	    $current_key = Cookie::get('key');	    
	    
	    // Check client's given cookie key against old hashed one in database
	    // to make sure their set cookie is correct
	    if (!Hash::check($current_key,$key_hash) && $key_hash != "") {
		    return redirect('/admin/security')->with('key','not_set');
	    }
	    
	    // Create an encrypter using the new key for encrypting the
	    // database
	    $encrypter = new \Illuminate\Encryption\Encrypter( $key, Config::get( 'app.cipher' ) );
		    
		// Get models of all credentials
	    $creds = \App\Credential::get();
	    
	    // Decrypt and re-encrypt database
	    foreach ($creds as $cred) {
		    $cred->username = $encrypter->encrypt($cred->username);
		    
		    $cred->password = $encrypter->encrypt($cred->password);
		    
		    $cred->save();
	    }
	    
	    // Save new key in database
	    $setting = \App\Setting::get('encryption_key');
	    $setting->value = bcrypt($key);
	    $setting->save();
	    
	    // Return if this is the first time we're setting the encryption key
	    if ($key_hash == "") {
		    return redirect('/admin/security')->with('key','valid');
	    }
	    
	    
	    return redirect('/admin/security')->with('key','valid');
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