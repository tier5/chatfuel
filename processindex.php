<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

const BOT_ID = '5a86fcc2e4b05207cdc4b3f6';

const TOKEN = 'qwYLsCSz8hk4ytd6CPKP4C0oalstMnGdpDjF8YFHPHCieKNc0AfrnjVs91fGuH74';

$psid = $_GET['psid'];

$BROADCAST_API_URL = 'https://api.chatfuel.com/bots/'.BOT_ID.'/users/'.$psid.'/send?chatfuel_token='.TOKEN.'&chatfuel_block_name=';

try{
    processSearch();
} catch (Exception $exception) {
    catchErrors($exception->getMessage());
}

function processSearch() {
    if(isset($_GET['type']))  {
        $type = $_GET['type'];
        switch ($type) {
            case '1': if(isset($_GET['address'])&& isset($_GET['zip'])) {
                        $address = $_GET['address'];
                        $zip = $_GET['zip'];
                        $broadcast_url = $GLOBALS['BROADCAST_API_URL'].'Zillow Search&zillow-address='.$address.'&zillow-zip='.$zip;
                        $curl = curl_init();
                        // Set some options - we are passing in a useragent too here
                        curl_setopt_array($curl, array(
                            CURLOPT_RETURNTRANSFER => 1,
                            CURLOPT_URL => $broadcast_url,
                            CURLOPT_USERAGENT => 'Requesting search....'
                        ));
                        // Send the request & save response to $resp
                        curl_exec($curl);
                        curl_close($curl);
                      }
            case '2':
            case '3':
        }
    }
}