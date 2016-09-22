<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \DrewM\MailChimp\MailChimp;

use Zoho\CRM\ZohoClient,
    Zoho\CRM\Entities\Lead,
    Zoho\CRM\Exception\ZohoCRMException
    ;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;
use Response;

class WebhookController extends Controller
{
	protected $mailchimp;
	protected $list_id = "37d5f9e9bd";
	
	protected $zoho_token = "80771d59f99433b3b8ba60defdead9bb";
	
	public function __construct() {
		$this->mailchimp = new MailChimp('35720fc2da8a66ce6953d73e11bce61f-us13');
	}
    public function mailchimp_put(Request $request) {
		
		$mailchimp = $this->mailchimp;
		
		$list_id = $this->list_id;
		
		$data = [
			'email_address' => $request->input('email'),
			'status' => 'subscribed',
			'merge_fields' => [
				'FNAME' => $request->input('fname'),
				'LNAME' => $request->input('lname'),
				'DOC' => $request->input('doc'),
			]
		];
		
		$result = $mailchimp->put("/lists/$list_id/members/".md5($request->input('email')), $data);
		
		Log::info($result);
		
		$response =  $mailchimp->get("/lists/$list_id/members/".md5($request->input('email')));
		
		return Response::json($response);
		
		//return Response::json(["success" => true]);
		
    }
    
    public function mailchimp_delete(Request $request) {
	    
	    $mailchimp = $this->mailchimp;	    
	    
	    $list_id = $this->list_id;
	    
	    $result = $mailchimp->delete("/lists/$list_id/members/".md5($request->input('email')));
	    
	    Log::info($result);
	    
	    return Response::json(['success' => true]);
	    
    }
    
    public function mailchimp_get(Request $request) {
	    $mailchimp = $this->mailchimp;
	    $list_id = $this->list_id;
	    
	    $result = $mailchimp->get("/lists/$list_id/members");
	    
	    return Response::json($result);
    }
    
    public function zoho_get(Request $request) {
	    
    }
    
    public function zoho_put(Request $request) {
	    
	    Log::info(json_encode($request->all()));
	    
	    $input = $request->all();
	    $data = [
		    'first_name' => $input["data"]["merges"]["FNAME"],
		    'last_name' => $input["data"]["merges"]["LNAME"],
		    'email' => $input["data"]["email"],
		    'lead_source' => $input["data"]["merges"]["GROUPINGS"][1]["groups"]
		    
	    ];
	    $lead = new Lead();
	    $xmlstr = $lead->serializeXml($data);
	    
	    //$lead->
	    
	    $zoho_token = $this->zoho_token;
	    
	    $ZohoClient = new ZohoClient($zoho_token);
	    $ZohoClient->setModule("Leads");
	    
	    $validXML = $ZohoClient->mapEntity($lead);
	    
	    $result = $ZohoClient->insertRecords($validXML);
	    
	    Log::info($result);
	    
	    return Response::json(['success' => true]);
    }
    
    public function zoho_delete(Request $request) {
	    
    }
    
}