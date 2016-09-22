<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use App\Client;
use Auth;
use Gate;

class ClientController extends Controller
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
    public function index()
    {
        return Response::json(Client::orderby('name','asc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    if (Gate::denies('edit-clients')) {
		    App::abort(403, 'Unauthorized action');
	    }
        Client::create([
	       'name'	=>	$request->json()->get('name')
        ]);
        
        return Response::json([ 'success' => true ]);
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
	    if (Gate::denies('edit-clients')) {
		    App::abort(403, 'Unauthorized action');
	    }
        Client::find($id)
        ->update([
	        'name'	=>	$request->json()->get('name')
        ]);
        
        return Response::json([ 'success' => true ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    if (Gate::denies('edit-clients')) {
		    App::abort(403, 'Unauthorized action');
	    }
        Client::destroy($id);
        
        return Response::json([ 'success' => true ]);
    }
}
