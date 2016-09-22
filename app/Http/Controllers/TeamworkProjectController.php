<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Teamwork;
use Response;

class TeamworkProjectController extends Controller
{
    private $tw_token = "tulip106car";
	private $tw_url = "https://bureaugravity.teamwork.com/";
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = \Httpful\Request::get($this->tw_url."projects.json")
            ->authenticateWith($request->user()->teamwork_api_token,'')
            ->expectsJson()
            ->send();
        $projects = $response->body->projects;
        $headers_array = $response->headers->toArray();
        $pages = (int) $headers_array['x-pages'];
        if ($pages > 1) {
            for ($i=2;$i<=$pages;$i++) {
                $nresponse = \Httpful\Request::get($this->tw_url."projects.json?page=$i")
                            ->authenticateWith($request->user()->teamwork_api_token, '')
                            ->expectsJson()
                            ->send();
                foreach ($nresponse->body->projects as $project) {
                    array_push($projects, $project);
                }
            }
        }
        return Response::json(['projects' => $projects]);
        //return Response::json(Teamwork::project()->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Response::json(Teamwork::project((int)$id)->find());
    }
    
    public function getPeople($project_id) {
        $response = \Httpful\Request::get($this->tw_url."projects/".$project_id."/people.json")
        ->authenticateWith($this->tw_token,'')
        ->send();
        return Response::json($response->body);
    }
    public function getRoles(Request $request, $project_id) {
        $tw_token = $request->user()->teamwork_api_token;
        $response = \Httpful\Request::get($this->tw_url."projects/".$project_id."/roles.json")
        ->authenticateWith($tw_token,'')
        ->send();
        return Response::json($response->body);
    }
}
