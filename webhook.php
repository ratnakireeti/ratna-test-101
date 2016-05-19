<?php
define ('ACCESS_TOKEN', 'CAAQT29ZAbjxMBAFsQMkAr48QtCfyK7Pot6pHXPeG3Scq7WZCQnKiLtYr0IYxzPmJ1RrZB3aP7pWgqSNsEzskvdRacAoTG2vQ6isqT1qEIupBu2GKvDQdIvUIyPZB3Ai8i2dBtiYKIvOkjI3Wn3fwwoDmDfZB9zNv6j7fW2ez4Kdonpx4Sz1S0ONPr0SxwRUqWSojCiFhAZCgZDZD');
define( 'TOKEN', 'FACEBOOK-APPOINTMENT-WEBHOOKS');

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

function send_data_to_messenger($responseData){
	$jsonData = json_encode($responseData);
	syslog(LOG_INFO,"Data To Send To Messenger=". $jsonData);
	
	//API Url and Access Token, generate this token value on your Facebook App Page
	$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.ACCESS_TOKEN;
	
	//Initiate cURL.
	$curl = curl_init($url);
	
	//Tell cURL that we want to send a POST request.
	curl_setopt($curl, CURLOPT_POST, 1);
	
	//Attach our encoded JSON string to the POST fields.
	curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
	
	//Set the content type to application/json
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$result = curl_exec($curl);
}

function isMatchDate($mmDDYYYY){
	return (bool)preg_match("/^(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\/[0-9]{4}$/",$mmDDYYYY);
}

function isMatchApptHour($hhMM){	
	return (bool)preg_match('/(?:[01][0-9]|2[0-4]):[0-5][0-9]:[AM]|[PM]/',$hhMM);
}

// Set this Verify Token Value on your Facebook App 
if ($verify_token === TOKEN) {
  echo $challenge;
  syslog(LOG_INFO, "CHALLENGE=".$challenge);
  return;
}else{
	$input = json_decode(file_get_contents('php://input'), true);
	
	//syslog(LOG_INFO,"INPUT:");
	//syslog(LOG_INFO,print_r($input, TRUE));
	syslog(LOG_INFO,"INPUT:".json_encode($input));
	
	// Get the Senders Graph ID
	$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
	//syslog(LOG_INFO,"SENDER=". $sender);
	$sender = number_format($sender, 0, '', '');// json_decode  scientific notation so now convert into a string
	//syslog(LOG_INFO,"SENDER2=". $sender);
	
	// Get the returned message
	$message = $input['entry'][0]['messaging'][0]['message'];//['text'];
	
	if(!empty($message) && isset($message)){
		$msgTxt = $message['text'];
		$responseData = array();
		$responseData['recipient'] = array('id'=> $sender );
		if(stripos($msgTxt, "HI") !== false || stripos($msgTxt, "HELLO") !== false || stripos($msgTxt, "HEY") !== false || stripos($msgTxt, "HOLA") !== false ){
			$responseData['message'] = array('text'=> 'How may I help you? ' );
			send_data_to_messenger($responseData);
		}else if(stripos($msgTxt, "BOOK") !== false || stripos($msgTxt, "MAKE") !== false || stripos($msgTxt, "RESERVE") !== false){
			$responseData['message'] = array('text'=> 'Which date? Please enter as mm/dd/yyyy' );
			send_data_to_messenger($responseData);
		}else if(isMatchDate($msgTxt)){
			$responseData['message'] = array('text'=> 'What time? Please use HH:MM AM' );
			send_data_to_messenger($responseData);
		}else if(isMatchApptHour($msgTxt)){
			$responseData['message'] = array('text'=> 'Your confirmation is '.microtime(true) );
			send_data_to_messenger($responseData);
		}else if(stripos($msgTxt, "HELP") !== false ){
			$responseData['message'] = array('text'=> 'You could say: BOOK - to book appointment. Date mm/dd/yy. Time HH:MM AM' );
			send_data_to_messenger($responseData);
		}else if(stripos($msgTxt, "WHAT CAN I DO") !== false ){
			$responseData['message'] = array('text'=> 'Really!, you can do alot of things' );
			send_data_to_messenger($responseData);
		}else if(stripos($msgTxt, "thankyou") !== false || stripos($msgTxt, "thank you") !== false ){
			$responseData['message'] = array('text'=> 'Nothing better than a pleasure to serving you' );
			send_data_to_messenger($responseData);
		}else{
			$responseData['message'] = array('text'=> 'Sorry, I dont understand. Please type help' );
			send_data_to_messenger($responseData);
		}
	  return;
	}
	
	return;
}