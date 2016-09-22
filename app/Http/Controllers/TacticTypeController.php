<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use App\TacticType;
use DB;

class TacticTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json(TacticType::get());
    }
    public function indexNames() {
	    return Response::json(TacticType::get(['id','name']));
    }
    
    public function show($id) {
	    return Response::json(TacticType::find($id));
    }
    
    public function showByName($name) {
	    return Response::json(TacticType::where('name',$name)->first());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        TacticType::create([
	        'name' => $request->json()->get('name')
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
        TacticType::find($id)
        ->update([
	        'name' => $request->json()->get('name')
        ]);
        return Response::json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TacticType::destroy($id);
        
        DB::table('tactic_tactictype')->where('tactictype_id', $id)->delete();
        
        return Response::json(['success' => true]);
    }
}
