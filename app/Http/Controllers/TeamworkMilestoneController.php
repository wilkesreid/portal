<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Teamwork;
use Response;
use Auth;

class TeamworkMilestoneController extends Controller
{
    //private $tw_token = $this->user->teamwork_api_token;
	private $tw_url = "https://bureaugravity.teamwork.com/";
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = \Httpful\Request::get($this->tw_url."milestones.json")
            ->authenticateWith($request->user()->teamwork_api_token,'')
            ->expectsJson()
            ->send();
        $milestones = $response->body->milestones;
        $headers_array = $response->headers->toArray();
        $pages = (int) $headers_array['x-pages'];
        if ($pages > 1) {
            for ($i=2;$i<=$pages;$i++) {
                $nresponse = \Httpful\Request::get($this->tw_url."milestones.json?page=$i")
                            ->authenticateWith($request->user()->teamwork_api_token, '')
                            ->expectsJson()
                            ->send();
                foreach ($nresponse->body->milestones as $milestone) {
                    array_push($milestones, $milestone);
                }
            }
        }
        return Response::json(['milestones' => $milestones, 'pages' => $pages]);
        //return Response::json(Teamwork::milestone()->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create()
    {
        //
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tactic_name = $request->json()->get('tactic_name');
        $description = $request->json()->get('description');
        $date_due = $request->json()->get('date_due');
        $deadline_datetime = new \DateTime($date_due);
        $deadline = $deadline_datetime->format('Ymd');
        $responsible_people = $request->json()->get('responsible_people');
        
        if ($tactic_name == "" || $description == "" || $date_due == "" || $responsible_people == "") {
            return Response::json(['success' => false, 'errcode' => 41, 'error' => 'Not all fields filled in.']);
        }
        
        $user = $request->user();
        $tw_token = $user->teamwork_api_token;
        if ($tw_token == "") {
            return Response::json(['success' => false, 'errcode' => 40, 'error' => 'No TW API Token']);
        }
        
        // Operations Manager
        $roles_response = \Httpful\Request::get($this->tw_url."/projects/".$request->json()->get('project_id')."/roles.json")
        ->authenticateWith($tw_token, '')
        ->send();
        $roles = $roles_response->body->roles;
        $role_users = [];
        foreach ($roles as $role) {
            if ($role->name == "Operations Manager") {
                $role_users = $role->users;
            }
        }
        
        $followers = "";
        foreach ($role_users as $role_user) {
            $followers .= $role_user->id. ", ";
        }
        $followers = substr($followers, 0, -2);
        
        $request_body = [
            "milestone" => [
               "title"   => $tactic_name . "_" . $description,
               "description" => "",
               "deadline" => $deadline,
               "notify" => true,
               "reminder" => false,
               "responsible-party-ids" => $responsible_people,
               "tags" => "",
               "changeFollowerIds" => $followers
           ]
        ];
        
        $response = \Httpful\Request::post($this->tw_url."projects/".$request->json()->get('project_id')."/milestones.json")
        ->sendsJson()
        ->authenticateWith($tw_token,'')
        ->body(json_encode($request_body))
        ->send();

        return Response::json(["success" => true, "request" => $request_body, "response" => $response->body]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
}
