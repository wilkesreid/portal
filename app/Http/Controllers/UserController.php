<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use \App\Setting;
use \App\User;
use Hash;

class UserController extends Controller
{
	
	public function __construct() {
		$this->middleware('auth');
	}
	
	public function clock_in() {
		// Create a new Time entry with current time as time_started
		// Set the user to be clocked in
	}
	
	public function clock_out() {
		// Set the most recent Time entry's time_ended to now
		// Set the user to be clocked out
	}
	
	public function saveSettings(Request $request) {
		$theme = $request->theme;
		$settings = Auth::user()->settings;
		$settings->theme = $theme;
		$settings->save();
		return redirect('/user/settings');
	}
	
	public function setEncryptionKey(Request $request) {
		$key = $request->key;
		$key_hash = Setting::where('name','encryption_key')->first()->value;
		if (Hash::check($key,$key_hash)) {
			return redirect('/user/security')->withCookie(cookie()->forever('key',$key))->with('key','valid');
		} else {
			return redirect('/user/security')->with('key','invalid');
		}
	}
}
