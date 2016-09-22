<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;

use App\Form;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::json(Form::get());
    }
    
    public function show($id)
    {
	    return Response::json(Form::find($id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Form::create([
	        'id'   => 0,
	        'name' => $request->input('name'),
	        'data' => json_encode($request->input('data')),
	        'hash' => md5(json_encode($request->input('data')))
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
        $form = Form::find($id);
        
        $form->name = $request->input('name');
        $form->data = json_encode($request->input('data'));
        $hash = md5(json_encode($request->input('data')));
        $form->hash = $hash;
        
        $form->save();
        
        return Response::json(['hash' => $hash]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Form::destroy($id);
        return Response::json(['success' => true]);
    }
}
