<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;

class HarvestController extends Controller
{
    private $harvest_url = "https://bureaugravity.harvestapp.com/";
    
    private function get($url) {
        return \Httpful\Request::get($this->harvest_url.$url)
        ->expectsJson()
        ->addHeader('Authorization', 'Basic c2FtckBidXJlYXVncmF2aXR5LmNvbTpTeVgyI3czcj9aQit5MlVjP3RtU2dXZzIhSG1jKz8=')
        ->send();
    }
    
    public function getClients() {
        $response = $this->get("clients");
        
        return Response::json($response->body);
    }
    
    public function getProjects() {
        $response = $this->get("projects");
        
        return Response::json($response->body);
    }
    
    public function getProjectsByClient($client_id) {
        $response = $this->get("projects?client=".$client_id);
        
        return Response::json($response->body);
    }
    
    public function getTasks() {
        $response = $this->get("tasks");
        
        return Response::json($response->body);
    }
    
    public function getDaily() {
        $response = $this->get("daily");
        
        return Response::json($response->body);
    }
    
    public function newEntry(Request $request) {
        $hours = (int) $request->input('hours');
        $description = $request->input('description');
        $project_id = $request->input('project_id');
        
        $data = [
            "notes" => $description,
            "project_id" => $project_id
        ];
        
        if ($hours != -1) {
            $data['hours'] = $hours;
        }
        
        $body = json_encode($data);
        
        if ($hours == -1) {
            return \Httpful\Request::post($this->harvest_url."/daily/add")
            ->sendsJson()
            ->addHeader('Authorization', 'Basic c2FtckBidXJlYXVncmF2aXR5LmNvbTpTeVgyI3czcj9aQit5MlVjP3RtU2dXZzIhSG1jKz8=')
            ->body($body)
            ->send();
        } else {
            return \Httpful\Request::post($this->harvest_url."/daily/add")
            ->sendsJson()
            ->addHeader('Authorization', 'Basic c2FtckBidXJlYXVncmF2aXR5LmNvbTpTeVgyI3czcj9aQit5MlVjP3RtU2dXZzIhSG1jKz8=')
            ->body($body)
            ->send();
        }
    }
    
}
