<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Platform;
use Response;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($client_id)
    {
        return Response::json(Platform::where('client_id',$client_id)->get());
    }
    
    public function search($name) {
	    return Response::json(Platform::where('name','LIKE','%'.$name.'%')->get());
    }
    
    public function indexByName($name) {
	    return Response::json(Platform::where('name',$name)->first());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $client_id)
    {
	    $platform = Platform::create([
		    'name' => $request->name,
		    'url' => $request->url,
		    'client_id' => $client_id
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
    public function update(Request $request, $client_id, $id)
    {
        $platform = Platform::where('id',$id)->first();
        $platform->name = $request->name;
        $platform->url = $request->url;
        $platform->save();
        
        return Response::json([ 'success' => true ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($client_id,$id)
    {
        Platform::destroy($id);
        
        return Response::json([ 'success' => true ]);
    }
}
