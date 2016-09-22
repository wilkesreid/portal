<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;
use DB;
use Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AbilityController extends Controller
{
    public function get($role) {
        $role = Role::where('name',$role)->first();
        return $role->abilities;
    }
    public function save(Request $request, $role) {
        $abilities = json_encode($request->json()->get('abilities'));
        $role = DB::table('roles')->where('name',$role)->update(['abilities'=>$abilities]);
        return Response::json(['success' => true]);
    }
}
