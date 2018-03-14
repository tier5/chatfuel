<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

const BOT_ID = '5a86fcc2e4b05207cdc4b3f6';

const TOKEN = 'qwYLsCSz8hk4ytd6CPKP4C0oalstMnGdpDjF8YFHPHCieKNc0AfrnjVs91fGuH74';

$psid = $_GET['psid'];

$BROADCAST_API_URL = 'https://api.chatfuel.com/bots/'.BOT_ID.'/users/'.$psid.'/send?';

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
                        $request = [
                            'chatfuel_token' => TOKEN,
                            'chatfuel_block_id' => '5aa3c253e4b094306e80db8d',
                            'zillow-address' => $address,
                            'zillow-zip' => $zip
                        ];
                        $broadcast_url = $GLOBALS['BROADCAST_API_URL'];
                        $postString = http_build_query($request, '', '&');
                        $broadcast_url .= $postString;
                        $curl = curl_init($broadcast_url);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl, CURLOPT_POST, true);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/jso'));
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($curl);
                        curl_close($curl);
                      }
                      break;
            case '2':if(isset($_GET['listing_id'])) {
                        $listing_id = $_GET['listing_id'];
                        $broadcast_url = $GLOBALS['BROADCAST_API_URL'].'5a9d2ee7e4b06f59551751ac&listing-id='.$listing_id;
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
                    } else if(isset($_GET['city'])) {
                        $city = $_GET['city'];
                        $broadcast_url = $GLOBALS['BROADCAST_API_URL'].'5a9d68d0e4b06f5955df493a&city-name='.$city;
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
                    } else if(isset($_GET['postal_code'])) {
                        $postal_code = $_GET['postal_code'];
                        $broadcast_url = $GLOBALS['BROADCAST_API_URL'].'5a9fe7dce4b06f595e0a994e&postal-code='.$postal_code;
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
                    }else if(isset($_GET['address'])) {
                        $address = $_GET['address'];
                        $broadcast_url = $GLOBALS['BROADCAST_API_URL'].'5a9ff396e4b06f595e31aad3&address-detail='.$address;
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
            case '3':
        }
    }
}