<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Credential;
use Response;
use Gate;
use App;

class CredentialController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('pending');
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
	    return Response::json(Credential::get());
    }
    
    public function indexOfPlatform($platform_id)
    {
        return Response::json(Credential::where('platform_id',$platform_id)->get());
    }
    
    public function indexTrashedOfPlatform($platform_id) {
	    return Response::json(Credential::onlyTrashed()->where('platform_id',$platform_id)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $platform_id)
    {
        Credential::create([
	        'username' => $request->username,
	        'password' => $request->password,
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
        $cred = Credential::find($id);
        Credential::create([
	        'username' => $request->username,
	        'password' => $request->password,
	        'comments' => $request->comments,
	        'platform_id' => $cred->platform_id
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
