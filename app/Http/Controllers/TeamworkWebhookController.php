<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Log;
use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;

class TeamworkWebhookController extends Controller
{
    public function time_created(Request $request) {
        
        $objectId = $request->input('objectId');
        
        Mail::send('emails.webhook_notification', [
            
            'input' => $request->all()
            
        ], function($m) {
            $m->from('notifications@mg.bureaugravity.com', 'Bureau Gravity Portal');
            
            $m->to('samr@bureaugravity.com', 'Samuel Reid')->subject('Webhook Received from Teamwork');
        });
        
        Log::info('Webhook received from Teamwork');
        
        return response('', 200);
    }
}
