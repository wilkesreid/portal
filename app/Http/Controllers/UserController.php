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
