<?php
$f_name 		= $_POST['f_name'];
$l_name 		= $_POST['l_name'];
$phone_numer 	= $_POST['phone_number'];
$date 			= $_POST['date'];
$time 			= $_POST['time'];
$note 			= $_POST['note'];
$full_name		= $f_name." ".$l_name;
$form_url 		= "https://api.chatfuel.com/bots/5a8aa514e4b05207d55947d6/users/1998661866829501/send";

echo $form_url;

$data = array(
	"chatfuel_token"		=>	"qwYLsCSz8hk4ytd6CPKP4C0oalstMnGdpDjF8YFHPHCieKNc0AfrnjVs91fGuH74",
	"chatfuel_block_name" 	=>  "RESPONSE WEBVIEW",
	"name"					=>   $full_name,
	"phone_number"			=> 	 $phone_number,
	"date_appo"				=>	 $date,
	"time_appo"				=>   $time,
	"note_appo"				=>   $note
);
$s = curl_init(); 

curl_setopt($s,CURLOPT_URL,$form_url); 
curl_setopt($s,CURLOPT_HTTPHEADER,array('Content-Type:application/json'));
curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
curl_setopt($s, CURLOPT_PORT , 443); 
curl_setopt($s, CURLOPT_POSTFIELDS, $data); 
$my_resp = curl_exec($s);
echo $my_resp;
curl_close($s);  
