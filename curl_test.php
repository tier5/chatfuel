<?php
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$block = urlencode["result"];
$form_url = "https://api.chatfuel.com/bots/5aa7cadbe4b02de31e5b6eda/user/1518741654872916/send?chatfuel_token=mELtlMAHYqR0BvgEiMq8zVek3uYUK3OJMbtyrdNPTrQB9ndV0fM7lWTFZbM4MZvD&chatfuel_block_name=".$block."&full_name=".$fname." ".$lname." ";
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
?>