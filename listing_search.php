<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * @const BASE_API_URL
 */
const BASE_API_URL = "http://rets-cache.homelasvegas.com/api/rets/v2/global_listings_search?";
/***
 * @const UPLOADS_DIR
 */
const UPLOADS_DIR = __DIR__."/uploads/";
try {
    processURL();
} catch (Exception $e) {
    // handling exception
    $error = new stdClass;
    $error->text =  $e->getMessage();
    $parent = array();
    array_push($parent,$error);
    $obj  = new stdClass();
    $obj->messages = $parent;
    echo json_encode($obj);
}

/**
 * This function searches for the the query string present in the url
 * @param null
 * @return string
 * @throws exception if no search query given or invalid action specified
 */
function processURL() {
    $url			= "";
    $page_count = 1;
    //current page calculation
    if(isset($_GET['page_count'])) {
        $page_count =$_GET['page_count'];
    }
    //Parameter flag to search the agent details for a particular listing id.
    if(isset($_GET['agent_search'])) {
        $agent_search = $_GET['agent_search'];
    }
    //Parameter flag to determine whether the search takes place via listing id
    if (isset($_GET['listing_id'])) {
        $listing_id 	= $_GET['listing_id'];
        $url .= "listing_id=".$listing_id;
        //checks whether agent details flag is present or not.If present trigger the agent detail search function.
        if(!isset($agent_search)) {
            request($url,1);
        } else if(isset($agent_search) && $agent_search == true){
            request($url,5);
        }
    }
    //Parameter flag to determine whether the search takes place via city name
    if (isset($_GET['city'])) {
        $city 		= str_replace(' ', '', $_GET['city']);
        $url .= "city=".$city."&per_page=5&page=".$page_count;
        request($url,2);
    }
    //Parameter flag to determine whether the search takes place via postal code
    if (isset($_GET['postal_code'])) {
        $postal_code	= $_GET['postal_code'];
        $url .= "postal_code=".$postal_code."&per_page=5&page=".$page_count;
        request($url,3);
    }
    //Parameter flag to determine whether the search takes place via address
    if (isset($_GET['address'])) {
        $address	= $_GET['address'];
        $url .= "address=".$address."&per_page=5&page=".$page_count;
        request($url,4);
    }

    //Parameter flag to determine the agent details if the search takes place via city, postal code or address.
    // If phone number not present, send a text object else send the agent details in a text object alongside a call button.

    if(isset($_GET['agent_name']) && isset($_GET['agent_off']) && isset($_GET['agent_phn'])) {
        $agent_name = $_GET['agent_name'];
        $agent_office_name = $_GET['agent_off'];
        $agent_phone_number = $_GET['agent_phn'];
        agentListSearch($agent_name,$agent_office_name,$agent_phone_number);
    }

    //If no parameter flag is present throw an exception
    if (!isset($listing_id) && !isset($city) && !isset($postal_code) && !isset($address) && !strlen($listing_id) && !strlen($city) && !strlen($postal_code) && !strlen($address)) {
        throw new Exception("Error Processing Request. No search query given", 1);
    }
}

/**
 * This function does the curl request to the realtor api
 * @param  string $url url where request is being made
 * @return array
 * @throws exception if no url has been passed
 */
function request($url = null,$choice = 1) {
    if(is_null($url)){
        throw new Exception("No URL has been passed to make a request", 1);
    }
    if (isset($url) && strlen($url)) {
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => BASE_API_URL.$url,
            CURLOPT_USERAGENT => 'Requesting search....'
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        switch ($choice){
            case 1: listingSearchViaId($resp);
                    break;
            case 2: listingSearch($resp,"City");
                    break;
            case 3: listingSearch($resp,"Postal Code");
                    break;
            case 4: listingSearch($resp,"Address");
                    break;
            case 5: agentListSearchFromListId($resp);
                    break;
            default:listingSearchViaId($resp);
                    break;
        }

        // Close request to clear up some resources
        curl_close($curl);
    } else {
        throw new Exception("No URL has been passed to make a request", 1);
    }
}

/***
 * Search on the basis of list id.
 * @param null $resp
 * @throws Exception
 */
function listingSearchViaId($resp = null) {
    if(is_null($resp)){
        throw new Exception("No response found.", 1);
    }

    if (count($resp)) {
        $elements = array();
        $resp = json_decode($resp);
        if(isset($resp->success) && $resp->success) {
            //create the button response structure
            $elements_btn_array = createListingIdSearchButtons($resp);
            //create the element response structure with the button response structure created
            $elem_objects       = createListingIdElement($resp,$elements_btn_array);
            array_push($elements, $elem_objects);
            // payload
            $payload = new stdClass();
            $payload->template_type = "generic";
            $payload->image_aspect_ratio = "square";
            $payload->elements = $elements;
            // configure gallery
            $attachment = new stdClass();
            $attachment->type = "template";
            $attachment->payload = $payload;
            //gallery structure
            $gallery_view  = new stdClass();
            $gallery_view->messages[] = ['attachment' => $attachment];
            header('Content-Type: application/json');
            echo(json_encode($gallery_view));
        } else {
            //No results found
            $msg = new stdClass();
            $msg->text = "No Search Results!";
            $parent = array();
            array_push($parent,$msg);
            $obj  = new stdClass();
            $obj->messages = $parent;
            $variables_obj = new stdClass();
            $variables_obj->demo  =404;
            $obj->set_attributes = $variables_obj;
            header('Content-Type: application/json');
            echo(json_encode($obj));
        }
    } else {
        //No results found
        $msg = new stdClass();
        $msg->text = "No Search Results!";
        $parent = array();
        array_push($parent,$msg);
        $obj  = new stdClass();
        $obj->messages = $parent;
        header('Content-Type: application/json');
        echo(json_encode($obj));
    }
}

/***
 * Searches for the agent details for a particular property
 * @param null $resp
 * @throws Exception
 */
function agentListSearchFromListId($resp = null)
{
    if (is_null($resp)) {
        throw new Exception("No response found.", 1);
    }

    if (count($resp)) {
        $resp = json_decode($resp);
        $parent = array();
        $elements_btn_array = [];
        if (isset($resp->success) && $resp->success) {
            //if response is present
            if (!empty($resp->results->data[0]->propertyadditional->ListAgentDirectWorkPhone)) {
                //create call button response structure
                $btn_obj = new stdClass();
                $btn_obj->type = "phone_number";
                $btn_obj->phone_number = $resp->results->data[0]->propertyadditional->ListAgentDirectWorkPhone;
                $btn_obj->title = "Call Agent";
                array_push($elements_btn_array, $btn_obj);

                //create payload response structure
                $payload = new stdClass();
                $payload->template_type = "button";
                $payload->text = ((!empty($resp->results->data[0]->propertyadditional->ListAgentFullName)) ? $resp->results->data[0]->propertyadditional->ListAgentFullName : 'Agent name not available ') . "," . ((!empty($resp->results->data[0]->propertyadditional->ListOfficeName)) ? $resp->results->data[0]->propertyadditional->ListOfficeName : 'Office name not available');
                $payload->buttons = $elements_btn_array;

                // configure buttons
                $attachment = new stdClass();
                $attachment->type = "template";
                $attachment->payload = $payload;
                $buttons_view = new stdClass();

                $buttons_view->attachment = $attachment;
                array_push($parent, $buttons_view);

                //configure the agent details with a text and a button
                $agent_detail = new stdClass();
                $agent_detail->messages = $parent;
                header('Content-Type: application/json');
                echo(json_encode($agent_detail));

            } else {
                // If no phone number is present send a text only.
                $textobj = new stdClass();
                $textobj->text = ((!empty($resp->results->data[0]->propertyadditional->ListAgentFullName)) ? $resp->results->data[0]->propertyadditional->ListAgentFullName : 'Agent name not available ') . "," . ((!empty($resp->results->data[0]->propertyadditional->ListOfficeName)) ? $resp->results->data[0]->propertyadditional->ListOfficeName : 'Office name not available');
                array_push($parent, $msg);
                $agent_detail = new stdClass();
                $agent_detail->messages = $parent;
                header('Content-Type: application/json');
                echo(json_encode($agent_detail));

            }

        } else {
            //No results found
            $msg = new stdClass();
            $msg->text = "No Search Results!";
            $parent = array();
            array_push($parent, $msg);
            $obj = new stdClass();
            $obj->messages = $parent;
            $variables_obj = new stdClass();
            $variables_obj->demo = 404;
            $obj->set_attributes = $variables_obj;
            header('Content-Type: application/json');
            echo(json_encode($obj));
        }
    } else {
        //No results found
        $msg = new stdClass();
        $msg->text = "No Search Results!";
        $parent = array();
        array_push($parent, $msg);
        $obj = new stdClass();
        $obj->messages = $parent;
        header('Content-Type: application/json');
        echo(json_encode($obj));
    }
}


/***
 * Creates the button structure for the chatfuel response on the  basis of listing id search
 * @param $resp_arr
 * @return array
 */
function createListingIdSearchButtons($resp_arr) {
    $elements_btn_array = [];
    $btn_obj_details	    = new stdClass();
    $btn_obj_details->type  ="web_url";
    $btn_obj_details->url   = "http://search.homelasvegas.com/idx/details/listing/b015/".$resp_arr->results->data[0]->MLSNumber;
    $btn_obj_details->title = "View Listing Details";

    $btn_obj_agent              = new stdClass();
    $btn_obj_agent->type        = "show_block";
    $btn_obj_agent->block_names = ["View Listing Agent"];
    $btn_obj_agent->title        = "Agent Details";

    if($resp_arr->results->data[0]->Status == "Active" && !empty($resp_arr->results->data[0]->VirtualTourLink)){
        $btn_obj_virtual_tour	    = new stdClass();
        $btn_obj_virtual_tour->type  ="web_url";
        $btn_obj_virtual_tour->url   = $resp_arr->results->data[0]->VirtualTourLink;
        $btn_obj_virtual_tour->title = "Virtual Tour";
    }

    array_push($elements_btn_array,$btn_obj_details);
    array_push($elements_btn_array,$btn_obj_agent);

    if(!empty($resp_arr->results->data[0]->VirtualTourLink) && isset($btn_obj_virtual_tour)) {
        array_push($elements_btn_array, $btn_obj_virtual_tour);
    }

    return $elements_btn_array;
}

/***
 * Creates the listing id search element for the chatfuel response
 * @param $resp_arr
 * @param $elements_btn_array
 * @return stdClass
 */
function createListingIdElement($resp_arr,$elements_btn_array) {
    $elem_objects = new stdClass();
    $elem_objects->title = (!empty($resp_arr->results->data[0]->PublicAddress)) ? $resp_arr->results->data[0]->PublicAddress :
                            ((!empty($resp_arr->results->data[0]->StreetNumber) || !empty($resp_arr->results->data[0]->StreetName) || !empty($resp_arr->results->data[0]->City) || !empty($resp_arr->results->data[0]->PostalCode)) ? $resp_arr->results->data[0]->StreetNumber." ".$resp_arr->results->data[0]->StreetName." ".$resp_arr->results->data[0]->City." ".$resp_arr->results->data[0]->PostalCode : 'None');
    $elem_objects->image_url =  (!empty($resp_arr->results->data[0]->propertyimage[0]->Encoded_image)) ? convertImageUrl($resp_arr->results->data[0]->propertyimage[0]->Encoded_image) : 'https://s3.amazonaws.com/mlsphotos.idxbroker.com/defaultNoPhoto/noPhotoFull.png';
    $elem_objects->subtitle = "List Price : $ ".((!empty($resp_arr->results->data[0]->ListPrice)) ? $resp_arr->results->data[0]->ListPrice : '0');
    $elem_objects->buttons = $elements_btn_array;
    return $elem_objects;
}

/***
 * Convert base64 images to image urls.
 * @param $encodedImage
 * @return string
 */
function convertImageUrl($encodedImage){
    $filename_path = md5(time().uniqid()).".jpg";
    $decoded=base64_decode($encodedImage);
    if(!file_exists('uploads')) {
        mkdir('uploads',777);
        chmod('uploads',777);
    }
    file_put_contents(UPLOADS_DIR.$filename_path,$decoded);
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/uploads/".$filename_path;
    return $actual_link;
}

/***
 * Creates the response for chatfuel on the basis of list search for postal code, address and city
 * list search
 * @param null $resp
 * @throws Exception
 */
function listingSearch($resp = null,$choice = null) {
    if(is_null($resp) || is_null($choice)){
        throw new Exception("No response found.", 1);
    }
    if (count($resp)) {
        $elements = array();
        $page_count = 1;
        $resp = json_decode($resp);
        //Checks the current page for the response
        if(isset($_GET['page_count'])) {
            $page_count =$_GET['page_count'];
        }

        if (isset($resp->success) && $resp->success) {
            $resp_arr = $resp->results->data;
            if (count($resp_arr)) {
                //If response is present configure the gallery structure.
                $gallery_view  = new stdClass();
                foreach ($resp_arr as $data) {
                    $elements_btn_array = createlistingSearchButtons($data,$choice);
                    $elem_objects       = createlistingElement($data,$elements_btn_array);
                    array_push($elements, $elem_objects);
                }
                //configure the payload for the gallery.
                $payload = new stdClass();
                $payload->template_type = "generic";
                $payload->image_aspect_ratio = "square";
                $payload->elements = $elements;

                //configure the attachment for the gallery.
                $attachment = new stdClass();
                $attachment->type = "template";
                $attachment->payload = $payload;

                $gallery_view->messages[] = ['attachment' => $attachment];

                // if counter is more than 5 need to have a pagination
                if ($page_count < $resp->results->last_page) {
                    // set user attribute here
                    $variables_obj1 = new stdClass();
                    $variables_obj1->demo  =200;
                    $variables_obj1->page_count = $page_count + 1;
                    $gallery_view->set_attributes = $variables_obj1;
                } else {
                    $variables_obj = new stdClass();
                    $variables_obj->demo  =404;
                    $gallery_view->set_attributes = $variables_obj;
                }
                header('Content-Type: application/json');
                echo(json_encode($gallery_view));

            } else {
                //No results found.
                $msg = new stdClass();
                $msg->text =  "No Search Results!";
                $parent = array();
                array_push($parent,$msg);
                $obj  = new stdClass();
                $obj->messages = $parent;
                $variables_obj = new stdClass();
                $variables_obj->demo  =404;
                $obj->set_attributes = $variables_obj;
                print_r(json_encode($obj));
            }

        }
    } else {
        //No results found.
        $msg = new stdClass();
        $msg->text =  "No More Results!";
        $parent = array();
        array_push($parent,$msg);
        $obj  = new stdClass();
        $obj->messages = $parent;
        print_r(json_encode($obj));
    }
}

/***
 * Creates the response for buttons for the listing search on the basis of postal code, address and city
 * @param $resp_arr
 * @return array
 */
function createlistingSearchButtons($resp_arr,$choice) {
    $elements_btn_array = [];
    $btn_obj_details	    = new stdClass();
    $btn_obj_details->type  ="web_url";
    $btn_obj_details->url   = "http://search.homelasvegas.com/idx/details/listing/b015/".$resp_arr->MLSNumber;
    $btn_obj_details->title = "View Listing Details";

    $btn_obj_agent              = new stdClass();
    $set_attributes             = new stdClass();
    $set_attributes->agent_name = ((!empty($resp_arr->propertyadditional->ListAgentFullName)) ? $resp_arr->propertyadditional->ListAgentFullName : 'Agent name not available ');
    $set_attributes->agent_off_name = ((!empty($resp_arr->propertyadditional->ListOfficeName)) ? $resp_arr->propertyadditional->ListOfficeName : 'Office name not available');
    $set_attributes->agent_phn_no = (!empty($resp_arr->propertyadditional->ListAgentDirectWorkPhone)) ? $resp_arr->propertyadditional->ListAgentDirectWorkPhone : '0';
    $btn_obj_agent->set_attributes   = $set_attributes;
    $btn_obj_agent->type        = "show_block";
    $btn_obj_agent->block_names = ["View Listing Agent ".$choice];
    $btn_obj_agent->title        = "Agent Details";


    if($resp_arr->Status == "Active" && !empty($resp_arr->VirtualTourLink)){
        $btn_obj_virtual_tour	    = new stdClass();
        $btn_obj_virtual_tour->type  ="web_url";
        $btn_obj_virtual_tour->url   = $resp_arr->VirtualTourLink;
        $btn_obj_virtual_tour->title = "Virtual Tour";
    }

    array_push($elements_btn_array,$btn_obj_details);
    array_push($elements_btn_array,$btn_obj_agent);

    if(!empty($resp_arr->VirtualTourLink) && isset($btn_obj_virtual_tour)) {
        array_push($elements_btn_array, $btn_obj_virtual_tour);
    }

    return $elements_btn_array;
}

/***
 * Creates the listing id search element for the chatfuel response
 * @param $resp_arr
 * @param $elements_btn_array
 * @return stdClass
 */
function createlistingElement($resp_arr,$elements_btn_array) {
    $elem_objects = new stdClass();
    $elem_objects->title = (!empty($resp_arr->PublicAddress)) ? $resp_arr->PublicAddress :
        ((!empty($resp_arr->StreetNumber) || !empty($resp_arr->StreetName) || !empty($resp_arr->City) || !empty($resp_arr->PostalCode)) ? $resp_arr->StreetNumber." ".$resp_arr->StreetName." ".$resp_arr->City." ".$resp_arr->PostalCode : 'None');
    $elem_objects->image_url =  (!empty($resp_arr->propertyimage[0]->Encoded_image)) ? convertImageUrl($resp_arr->propertyimage[0]->Encoded_image) : 'https://s3.amazonaws.com/mlsphotos.idxbroker.com/defaultNoPhoto/noPhotoFull.png';
    $elem_objects->subtitle = "List Price : $ ".((!empty($resp_arr->ListPrice)) ? $resp_arr->ListPrice : '0');
    $elem_objects->buttons = $elements_btn_array;
    return $elem_objects;
}

/***
 * Function for creating the response for searching agent details from a list of properties on the basis of postal code, address or city
 * @param $agent_name
 * @param $agent_office_name
 * @param $agent_phone_number
 */
function agentListSearch($agent_name,$agent_office_name,$agent_phone_number) {
    if ($agent_phone_number == '0') {
        //If no phone number is present send a text object only.

        $textobj = new stdClass();
        $textobj->text = $agent_name. "," .$agent_office_name;
        array_push($parent, $msg);
        $agent_detail = new stdClass();
        $agent_detail->messages = $parent;
        header('Content-Type: application/json');
        echo(json_encode($agent_detail));
    } else {
        //If phone number is present send a text object alongside a call button.
        $parent = [];
        $elements_btn_array = [];
        $btn_obj = new stdClass();
        $btn_obj->type = "phone_number";
        $btn_obj->phone_number = $agent_phone_number;
        $btn_obj->title = "Call Agent";
        array_push($elements_btn_array, $btn_obj);


        $payload = new stdClass();
        $payload->template_type = "button";
        $payload->text = $agent_name. "," .$agent_office_name;
        $payload->buttons = $elements_btn_array;

        // configure chart
        $attachment = new stdClass();
        $attachment->type = "template";
        $attachment->payload = $payload;
        $buttons_view = new stdClass();

        $buttons_view->attachment = $attachment;
        array_push($parent, $buttons_view);

        $agent_detail = new stdClass();
        $agent_detail->messages = $parent;
        header('Content-Type: application/json');
        echo(json_encode($agent_detail));
    }
}
