<?php
$office_name =urlencode($_POST["office_name"]);
$user_id = $_POST["user_id"];
$block_name = urlencode('Ask office name');

$form_url     = "https://api.chatfuel.com/bots/5a86fcc2e4b05207cdc4b3f6/users/".$user_id."/send?chatfuel_token=fhV81JypiEPqBGIvU7CeKUbESzLIjYdXbsonkNaRKh7yh5TImLuYWGWeEN1FTHgX&chatfuel_block_name=".$block_name."&office_name=".$office_name;
//echo $form_url;die;
$curl= curl_init();
curl_setopt_array($curl, array(
	CURLOPT_URL => $form_url,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_HTTPHEADER => array(
	"cache-control = no cache" ),
	));
$curl_ex = curl_exec($curl);
?>
