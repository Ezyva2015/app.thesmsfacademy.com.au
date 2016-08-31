<?php 

define("ZDAPIKEY", "7RNCSJXYkd90KxrnRC9KL6FjiO8qDHrTDuJgt84C");
define("ZDUSER", "tim@paratus.com.au");
define("ZDURL", "https://paratus.zendesk.com/api/v2");
 
/* Note: do not put a trailing slash at the end of v2 */

function curlWrap($url, $json, $action)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
	curl_setopt($ch, CURLOPT_URL, ZDURL.$url);
	curl_setopt($ch, CURLOPT_USERPWD, ZDUSER."/token:".ZDAPIKEY);
	switch($action){
		case "POST":
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
			break;
		case "GET":
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			break;
		case "PUT":
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
			break;
		case "DELETE":
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			break;
		default:
			break;
	}
 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$output = curl_exec($ch);
	curl_close($ch);
	$decoded = json_decode($output);
	return $decoded;
}





		// CREATE AN ARRAY WITH POST DATA AND DESIRED TICKET CONTENT/ATTRIBUTES
		$arr = array(
		"new_req_name" => 'Tim Foster',//$_POST["req_name"],
		"new_req_email" => 'tim.foster@me.com',//$_POST["req_email"],
		//"new_tick_group" => "20622784",
		"new_tick_assignee" => "279358764",
		"new_tick_subj" => 'New Order Test Test Test',//$_POST["subject"],
		"new_tick_desc" => 'Test Description'//$_POST["tick_desc"]
		);

		// CREATE JSON FORMATTED VARIABLE TO PASS AS PARAMETER TO API
		$create = json_encode(
		array(
		'ticket' => array(
		'requester' => array(
		'name' => $arr['new_req_name'],
		'email' => $arr['new_req_email']
		),
		'group_id' => $arr['new_tick_group'],
		'assignee_id' => $arr['new_tick_assignee'],
		'subject' => $arr['new_tick_subj'],
		'description' => $arr['new_tick_desc']
		)
		),
		JSON_FORCE_OBJECT
		);

		$data = curlWrap("/tickets.json", $create, "POST");
		var_dump($data);

		print $data->ticket->id;
		print "\n";

?>