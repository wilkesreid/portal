<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Credential;
use Response;
use Gate;
use App;
use Crypt;
use Hash;
use App\User;
use App\Setting;
use Config;

class CredentialController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('passwordmanager');
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
	    if (!Gate::denies('view-management-passwords')) {
	    	return Response::json(Credential::get());
	    } else {
		    return Response::json(Credential::where('type','!=','management')->get());
	    }
    }
    
    public function indexOfPlatform($platform_id)
    {
	    if (!Gate::denies('view-management-passwords')) {
        	return Response::json(Credential::where('platform_id',$platform_id)->get());
        } else {
	        return Response::json(Credential::where('type','!=','management')->where('platform_id',$platform_id)->get());
        }
    }
    
    public function indexTrashedOfPlatform($platform_id) {
	    if (!Gate::denies('view-management-passwords')) {
	    	return Response::json(Credential::onlyTrashed()->where('platform_id',$platform_id)->get());
	    } else {
		    return Response::json(Credential::onlyTrashed()->where('type','!=','management')->where('platform_id',$platform_id)->get());
	    }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $platform_id)
    {
	    // Get encryption key from client
	    $key = $request->cookie('key');
	    // Get hashed encryption key from database
	    $key_hash = Setting::where('name','encryption_key')->first()->value;
	    // Check client's given key against hashed one in database
	    if (!Hash::check($key,$key_hash)) {
		    return abort(403,'Encryption key not correct');
	    }
	    $encrypter = new \Illuminate\Encryption\Encrypter( $key, Config::get( 'app.cipher' ) );
        Credential::create([
	        'username' => $encrypter->encrypt($request->username),
	        'password' => $encrypter->encrypt($request->password),
	        'comments' => $request->comments,
	        'platform_id' => $platform_id
        ]);
        
        return Response::json(['success' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
	    // Get encryption key from client
	    $key = $request->cookie('key');
	    // Get hashed encryption key from database
	    $key_hash = Setting::where('name','encryption_key')->first()->value;
	    // Check client's given key against hashed one in database
	    if (!Hash::check($key,$key_hash)) {
		    return abort(403,'Encryption key not correct');
	    }
	    $encrypter = new \Illuminate\Encryption\Encrypter( $key, Config::get( 'app.cipher' ) );
        $cred = Credential::find($id);
        Credential::create([
	        'username' => $encrypter->encrypt($request->username),
	        'password' => $encrypter->encrypt($request->password),
	        'comments' => $request->comments,
	        'platform_id' => $cred->platform_id,
	        'type'		=> $request->type
        ]);
        $cred->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cred = Credential::withTrashed()->find($id);
        if ($cred->trashed()) {
	        if (Gate::denies('edit-passwords')) {
		    	App::abort(403, 'Unauthorized action');
	    	}
	        $cred->forceDelete();
	    } else {
		    $cred->delete();
		}
        return Response::json(['success' => true]);
    }
    
    public function restore($id) {
	    $cred = Credential::onlyTrashed()->find($id);
	    $cred->deleted_at = null;
	    $cred->save();
	    
	    return Response::json(['success' => true]);
    }
}
