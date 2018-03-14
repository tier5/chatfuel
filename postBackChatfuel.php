<?php
$f_name 		= $_POST['f_name'];
$l_name 		= $_POST['l_name'];
$phone_numer 	= $_POST['phone_number'];
$date 			= $_POST['date'];
$time 			= $_POST['time'];
$note 			= $_POST['note'];
$full_name		= $f_name." ".$l_name;
echo $full_name;
$form_url 		= "https://api.chatfuel.com/bots/5a8aa514e4b05207d55947d6/users/1998661866829501/send?chatfuel_token=qwYLsCSz8hk4ytd6CPKP4C0oalstMnGdpDjF8YFHPHCieKNc0AfrnjVs91fGuH74&chatfuel_block_name=RESPONSE WEBVIEW&name=".$full_name."&phone_number=".$phone_number."&date_appo=".$date."&time_appo=".$time."&note_appo=".$note."";
$request_headers = array();
$request_headers[] = 'Content-Type: '. "application/json";
// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_HTTPHEADER => $request_headers,
    CURLOPT_URL => $form_url,
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
));
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);