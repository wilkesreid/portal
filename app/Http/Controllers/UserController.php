<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	
	public function __construct() {
		return $this->middleware('auth');
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
		$user = Auth::user();
		$user->theme_id = $theme;
		$user->save();
		return redirect('/user/settings');
	}
}
