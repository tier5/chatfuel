<?php
$f_name 		= $_POST['f_name'];
$l_name 		= $_POST['l_name'];
$phone_numer 	= urlencode($_POST['phone_number']);
$date 			= urlencode($_POST['date']);
$time 			= urlencode($_POST['time']);
$note 			= urlencode($_POST['note']);
$full_name		= urlencode($f_name." ".$l_name);
$block          = urlencode("RESPONSE WEBVIEW");
$form_url 		= "https://api.chatfuel.com/bots/5a8aa514e4b05207d55947d6/users/1998661866829501/send?chatfuel_token=qwYLsCSz8hk4ytd6CPKP4C0oalstMnGdpDjF8YFHPHCieKNc0AfrnjVs91fGuH74&chatfuel_block_name=".$block."&name=".$full_name."&phone_number_meet=".$phone_number."&date_appo=".$date."&time_appo=".$time."&note_appo=".$note."";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $form_url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
