<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$m_id = $_POST['m_id'];
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.chatfuel.com/bots/5aaf6297e4b02de3348da553/users/".$m_id."/send?chatfuel_token=oqDrKw0BaTQjhtKvZQTzaDn4s09Zi74DvYt1v9wuK572zUrILD9YEDGQqXhRqL0M&chatfuel_block_name=Feedback%20level1%20Q1",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
