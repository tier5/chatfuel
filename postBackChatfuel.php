<?php
$f_name 		= $_POST['f_name'];
$l_name 		= $_POST['l_name'];
$phone_numer 	= $_POST['phone_number'];
$date 			= $_POST['date'];
$time 			= $_POST['time'];
$note 			= $_POST['note'];
$full_name		= $f_name." ".$l_name;
$form_url 		= "https://api.chatfuel.com/bots/5a8aa514e4b05207d55947d6/users/1998661866829501/send";

//echo $form_url;

$data = array(
	"chatfuel_token"		=>	"qwYLsCSz8hk4ytd6CPKP4C0oalstMnGdpDjF8YFHPHCieKNc0AfrnjVs91fGuH74",
	"chatfuel_block_name" 	=>   urlencode("RESPONSE WEBVIEW"),
	"name"					=>   urlencode($full_name),
	"phone_number"			=> 	 urlencode($phone_number),
	"date_appo"				=>	 urlencode($date),
	"time_appo"				=>   urlencode($time),
	"note_appo"				=>   urlencode($note)
);

foreach($data as $key=>$value) {
	$fields_string .= $key.'='.$value.'&'; 
}
rtrim($fields_string, '&');
// echo $fields_string;
// exit();
// $s = curl_init(); 

// curl_setopt($s,CURLOPT_URL,$form_url); 
// curl_setopt($s,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
// curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
// curl_setopt($s, CURLOPT_PORT , 443); 
// curl_setopt($s, CURLOPT_POSTFIELDS, $data); 
// $my_resp = curl_exec($s);
// echo $my_resp;
// curl_close($s);
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $form_url);
curl_setopt($ch,CURLOPT_POST, count($data));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
$result = curl_exec($ch);
curl_close($ch);
//check the result
var_dump($result);  
