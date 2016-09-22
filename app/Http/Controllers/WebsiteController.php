<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use App\Website;
use Auth;
use Gate;

class WebsiteController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('websitelist');
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json(Website::orderby('name','asc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('edit-websites')) {
	        App::abort(403, 'Unauthorized action');
        }
        Website::create([
	        'name' => $request->json()->get('name'),
	        'url'  => $request->json()->get('url')
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function check($id) {
	    if (Gate::denies('edit-websites')) {
		    App::abort(403, 'Unauthorized action');
	    }
	    Website::find($id)->update([
		    'checked_last' => date("Y-m-d")
	    ]);
	    
        return Response::json([ 'success' => true ]);
    }
    
    public function uncheck($id) {
	    if (Gate::denies('edit-websites')) {
		    App::abort(403, 'Unauthorized action');
	    }
	    Website::find($id)->update([
		    'checked_last' => NULL
	    ]);
	    
        return Response::json([ 'success' => true ]);
    }
}
