<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

const BOT_ID = '5a86fcc2e4b05207cdc4b3f6';

const TOKEN = 'qwYLsCSz8hk4ytd6CPKP4C0oalstMnGdpDjF8YFHPHCieKNc0AfrnjVs91fGuH74';

$psid = $_POST['psid'];

$BROADCAST_API_URL = 'https://api.chatfuel.com/bots/'.BOT_ID.'/users/'.$psid.'/send?';

try{
    processSearch();
} catch (Exception $exception) {
    catchErrors($exception->getMessage());
}

function processSearch() {
    $broadcast_url = $GLOBALS['BROADCAST_API_URL'];
    if(isset($_POST['type']))  {
        $type = $_POST['type'];
        switch ($type) {
            case '1': if(isset($_POST['address'])&& isset($_POST['zip'])) {
                        $address = $_POST['address'];
                        $zip = $_POST['zip'];
                        $request = [
                            'chatfuel_token' => TOKEN,
                            'chatfuel_block_id' => '5aa3c253e4b094306e80db8d',
                            'zillow-address' => $address,
                            'zillow-zip' => $zip
                        ];
                        $response = getResponse($request,$broadcast_url);
                      }
                      break;
            case '2':if(isset($_POST['listing_id'])) {
                        $listing_id = $_POST['listing_id'];
                        $request = [
                            'chatfuel_token' => TOKEN,
                            'chatfuel_block_id' => '5a9d2ee7e4b06f59551751ac',
                            'listing-id' => $listing_id,
                        ];
                        $response = getResponse($request,$broadcast_url);
                    } else if(isset($_POST['city'])) {
                        $city = $_POST['city'];
                        $request = [
                            'chatfuel_token' => TOKEN,
                            'chatfuel_block_id' => '5a9d68d0e4b06f5955df493a',
                            'city-name' => $city,
                        ];
                        $response = getResponse($request,$broadcast_url);
                    } else if(isset($_POST['postal_code'])) {
                        $postal_code = $_POST['postal_code'];
                        $request = [
                            'chatfuel_token' => TOKEN,
                            'chatfuel_block_id' => '5a9fe7dce4b06f595e0a994e',
                            'postal-code' => $postal_code,
                        ];
                        $response = getResponse($request,$broadcast_url);
                    }else if(isset($_POST['address'])) {
                        $address = $_POST['address'];
                        $request = [
                            'chatfuel_token' => TOKEN,
                            'chatfuel_block_id' => '5a9ff396e4b06f595e31aad3',
                            'address-detail' => $address,
                        ];
                        $response = getResponse($request,$broadcast_url);
                    }
                    break;
            case '3':if(isset($_POST['first_name'])) {
                        $first_name = $_POST['first_name'];
                        $request = [
                            'chatfuel_token' => TOKEN,
                            'chatfuel_block_id' => '5a8d4352e4b05207dcb79107',
                            'first_name' => $first_name,
                        ];
                        $response = getResponse($request,$broadcast_url);
                    } else if(isset($_POST['last_name'])) {
                        $last_name = $_POST['last_name'];
                        $request = [
                            'chatfuel_token' => TOKEN,
                            'chatfuel_block_id' => '5a8d438be4b05207dcb80405',
                            'last_name' => $last_name,
                        ];
                        $response = getResponse($request,$broadcast_url);
                    } else if(isset($_POST['office_name'])) {
                        $office_name = $_POST['office_name'];
                        $request = [
                            'chatfuel_token' => TOKEN,
                            'chatfuel_block_id' => '5a8d43a6e4b05207dcb82cf0',
                            'office_name' => $office_name,
                        ];
                        $response = getResponse($request,$broadcast_url);
                    }
                    break;
        }
        if(isset($response) && !$response->success) {
            $request = [
                'chatfuel_token' => TOKEN,
                'chatfuel_block_id' => '5a9fd9cee4b06f595de23f67',
            ];
            $response = getResponse($request,$broadcast_url);
        }
    } else {
            $request = [
                'chatfuel_token' => TOKEN,
                'chatfuel_block_id' => '5a9fd9cee4b06f595de23f67',
            ];
            $response = getResponse($request,$broadcast_url);
    }
}

function getResponse($request,$broadcast_url) {
    $postString = http_build_query($request, '', '&');
    $broadcast_url .= $postString;
    // $broadcast_url = $GLOBALS['BROADCAST_API_URL'].'5a9d68d0e4b06f5955df493a&city-name='.$city;
    $curl = curl_init($broadcast_url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}