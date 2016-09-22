<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Teamwork;
use Response;
use Cache;

class TeamworkCompanyController extends Controller
{
    private $tw_url = "https://bureaugravity.teamwork.com/";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        return Response::json(Teamwork::company()->all());
    }
    
    public function indexProjectsByCompany($id)
    {
	    return Response::json(Teamwork::company((int)$id)->projects());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Response::json(Teamwork::company((int)$id)->find());
    }
}
