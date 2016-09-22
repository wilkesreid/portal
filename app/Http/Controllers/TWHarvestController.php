<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use App\TWHarvest;

class TWHarvestController extends Controller
{
    public function index() {
        $relationships = TWHarvest::get();
        return Response::json($relationships);
    }
    
    public function store(Request $request) {
        
        TWHarvest::create([
            "teamwork_milestone_id" => $request->json()->get('teamwork_milestone_id'),
            "harvest_project_id" => $request->json()->get('harvest_project_id')
        ]);
        
        return Response::json(['success' => true]);
    }
}
