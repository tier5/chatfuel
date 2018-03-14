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

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$form_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close ($ch);