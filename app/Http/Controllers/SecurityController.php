<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SecurityController extends Controller
{
    public function securityMenu() {
	    
	    $this->authorize('security-menu');
	    
	    return view('user/security');
    }
    
}
