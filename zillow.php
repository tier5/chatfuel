<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * @const BASE_API_URL
 */
const BASE_API_URL = "http://www.zillow.com/webservice/GetDeepSearchResults.htm";
/***
 * @const UPLOADS_DIR
 */
const UPLOADS_DIR = __DIR__."/uploads/";
/***
 * @const ZILLOW_ID
 */
const ZILLOW_ID = 'X1-ZWz1g8z3fl8suj_7kib9';
/**
 * @const GOOGLE_MAP_API_KEY
 */
const GOOGLE_MAP_API_KEY = 'AIzaSyBV60oJTBzbA7RLxNjlkUjNk2ElVYEPN9w';
/**
 * @const BASE_GOOGLE_API_URL
 */
const BASE_GOOGLE_API_URL = "https://maps.googleapis.com/maps/api/geocode/json?";

try {
    processURL();
} catch (Exception $e) {
    // handling exception
    catchErrors($e->getMessage());
}
/***
 * Function to process the url for the query strings
 * @throws Exception
 */
function processURL() {

    //Parameter flag to check the address of the property
    if(isset($_GET['address'])) {
        $address =$_GET['address'];
    }
    //Parameter flag to check the zip of the property.
    if(isset($_GET['zip'])) {
        $zip = $_GET['zip'];
    }

    //If no parameter flag is present throw an exception
    if (!isset($address) && !isset($zip) && !strlen($zip) && !strlen($zip)) {
        throw new Exception("Error Processing Request. No search query given", 1);
    }

    //create the request array
    $request = [
        'zws-id' => ZILLOW_ID,
        'address' => $address,
        'citystatezip' => $zip
    ];

    //Pass the request
    request($request);
}

/**
 * This function does the curl request to the realtor api
 * @param  string $url url where request is being made
 * @return array
 * @throws exception if no url has been passed
 */
function request($request = null) {
    if(is_null($request )){
        throw new Exception("No URL has been passed to make a request", 1);
    }
    if (isset($request ) && count($request) > 0) {
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => BASE_API_URL,
            CURLOPT_POSTFIELDS => $request
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        parseAPI($resp);
        // Close request to clear up some resources
        curl_close($curl);
    } else {
        throw new Exception("No URL has been passed to make a request", 1);
    }
}

/**
 * Function to parse the xml response and create the chatfuel response
 * @param null $response
 * @throws Exception
 */
function parseAPI($response = null) {
    if(is_null($response)){
        throw new Exception('No response found.',1);
    }

    //get the xml response
    if(isset($response)) {
        $xml = simplexml_load_string($response);
        createChatFuelResponse($xml);
    }
}

/***
 * Function to create the chat fuel json response, if errors are found then show the errors
 * @param $xmlResponse
 */
function createChatFuelResponse($xmlResponse) {
    $fetchResponseCode = $xmlResponse->message->code;
    switch ($fetchResponseCode) {
        case '0':   createResponse($xmlResponse->response->results->result);
                    break;
        default:    showErrors($fetchResponseCode);
                    break;
    }
}

/***
 * Create the chatfuel json response
 * @param $response
 */
function createResponse($response) {
    $buttons = [];
    $elementsArray = [];

    $button_obj_yes = new stdClass();
    $button_obj_yes->type = "show_block";
    $button_obj_yes->block_names = ["Property Choice: Yes"];
    $button_obj_yes->title = "Yes! This is it!";

    $button_obj_no = new stdClass();
    $button_obj_no->type = "show_block";
    $button_obj_no->block_names = ["Property Choice: No"];
    $button_obj_no->title = "No";

    array_push($buttons,$button_obj_yes);
    array_push($buttons,$button_obj_no);

    $elements = new stdClass();
    $elements->title = $response->address->street.",".$response->address->zipcode.",".$response->address->city.",".$response->address->state;
    $elements->subtitle = 'Range: $'.$response->zestimate->valuationRange->low.' - $'.$response->zestimate->valuationRange->high;
    $elements->image = 'https://s3.amazonaws.com/mlsphotos.idxbroker.com/defaultNoPhoto/noPhotoFull.png';

    array_push($elementsArray,$elements);

    $payload = new stdClass();
    $payload->template_type = 'generic';
    $payload->template_type = 'square';
    $payload->elements = $elements;

    $attachment = new stdClass();
    $attachment->type = "template";
    $attachment->payload = $payload;

    $gallery_view = new stdClass();
    $gallery_view->messages[] = ['attachment' => $attachment];

    header('Content-Type: application/json');
    echo(json_encode($gallery_view));
}

/***
 * Function to show all the errors
 * @param $message
 */
function catchErrors($message) {
    $error = new stdClass();
    $error->text =  $message;
    $parent = array();
    array_push($parent,$error);
    $obj  = new stdClass();
    $obj->messages = $parent;
    header('Content-Type: application/json');
    echo json_encode($obj);
}

/***
 * Status of all the api error codes
 * @param $responseCodes
 */
function showErrors($responseCodes) {
    switch ($responseCodes) {
        case '1':   $errorMsg = 'Service error-there was a server-side error while processing the request';
                    catchErrors($errorMsg);
                    break;
        case '2':   $errorMsg = 'The specified ZWSID parameter was invalid or not specified in the request';
                    catchErrors($errorMsg);
                    break;
        case '3':   $errorMsg = 'Web services are currently unavailable';
                    catchErrors($errorMsg);
                    break;
        case '4':   $errorMsg = 'The API call is currently unavailable';
                    catchErrors($errorMsg);
                    break;
        case '500': $errorMsg = 'Invalid or missing address parameter';
                    catchErrors($errorMsg);
                    break;
        case '501': $errorMsg = 'Invalid or missing citystatezip parameter';
                    catchErrors($errorMsg);
                    break;
        case '502': $errorMsg = 'No results found';
                    catchErrors($errorMsg);
                    break;
        case '503': $errorMsg = 'Failed to resolve city, state or ZIP code';
                    catchErrors($errorMsg);
                    break;
        case '504': $errorMsg = 'No coverage for specified area	';
                    catchErrors($errorMsg);
                    break;
        case '505': $errorMsg = 'Timeout';
                    catchErrors($errorMsg);
                    break;
        case '506': $errorMsg = 'Address string too long';
                    catchErrors($errorMsg);
                    break;
        case '507': $errorMsg = 'No exact match found.';
                    catchErrors($errorMsg);
                    break;
    }
}

