<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use App\Tactic;
use App\TacticType;
use DB;

class TacticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Response::json(Tactic::get());
    }
    public function indexNames() {
	    return Response::json(Tactic::get(['id','name']));
    }
    public function indexByTypeId($type) {
	    return Response::json(TacticType::find($type)->tactics()->get());
    }
    
    public function show($id) {
	    
	    return Response::json(Tactic::find($id));
    }
    
     public function showByName($name) {
	    
	    return Response::json(Tactic::where('name',$name)->first());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $tactic = Tactic::create([
	        'name' => $request->json()->get('name')
        ]);
        DB::table('tactic_tactictype')->insert(
          ['tactic_id' => $tactic->id, 'tactictype_id' => $request->json()->get('tactictype_id')]
        );
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
        Tactic::find($id)
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
        //
        Tactic::destroy($id);
        
        DB::table('tactic_tactictype')->where('tactic_id', $id)->delete();
        
        return Response::json(['success' => true]);
    }
}
