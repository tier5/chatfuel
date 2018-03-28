
<?php
session_start();
//$mes_id = $_POST['chatData'];
//$fname = $_POST["fname"];
//$lname = $_POST["lname"];
$block = urlencode("Feedback_level1_Q1");

$form_url = "https://api.chatfuel.com/bots/5aaf6297e4b02de3348da553/user/2092869527397577/send?chatfuel_token=mELtlMAHYqR0BvgEiMq8zVek3uYUK3OJMbtyrdNPTrQB9ndV0fM7lWTFZbM4MZvD&chatfuel_block_name=".$block." ";
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
echo $response;
?>
