<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * @const BASE_API_URL
 */
const BASE_API_URL = "http://rets-cache.homelasvegas.com/api/rets/v2/global_search?";
/***
 *
 */
const UPLOADS_DIR = __DIR__."/uploads/";
try {
    processURL();
} catch (Exception $e) {
    // handling exception
    $error = array('text' =>  $e->getMessage());
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
    if(isset($_GET['page_count'])) {
        $page_count =$_GET['page_count'];
    }
    if(isset($_GET['agent_search'])) {
        $agent_search = $_GET['agent_search'];
    }
    if (isset($_GET['listing_id'])) {
        $listing_id 	= $_GET['listing_id'];
        $url .= "listing_id=".$listing_id;
        if(!isset($agent_search)) {
            request($url,1);
        } else if(isset($agent_search) && $agent_search == true){
            request($url,5);
        }
    }
    if (isset($_GET['city'])) {
        $city 		= str_replace(' ', '', $_GET['city']);
        $url .= "city=".$city."&per_page=5&page=".$page_count;
        request($url,2);
    }
    if (isset($_GET['postal_code'])) {
        $postal_code	= $_GET['postal_code'];
        $url .= "postal_code=".$postal_code."&per_page=5&page=".$page_count;
        request($url,3);
    }
    if (isset($_GET['address'])) {
        $address	= $_GET['address'];
        $url .= "address=".$address."&per_page=5&page=".$page_count;
        request($url,4);
    }

    if(isset($_GET['agent_name']) && isset($_GET['agent_off']) && isset($_GET['agent_phn'])) {
        $agent_name = $_GET['agent_name'];
        $agent_office_name = $_GET['agent_off'];
        $agent_phone_number = $_GET['agent_phn'];
        agentListSearch($agent_name,$agent_office_name,$agent_phone_number);
    }

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
            case 1: listidSearch($resp);
                    break;
            case 2: listSearch($resp,"City");
                    break;
            case 3: listSearch($resp,"Postal Code");
                    break;
            case 4: listSearch($resp,"Address");
                    break;
            case 5: agentListSearchFromListId($resp,$choice);
                    break;
            default:listidSearch($resp);
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
function listidSearch($resp = null) {
    if(is_null($resp)){
        throw new Exception("No response found.", 1);
    }

    if (count($resp)) {
        $elements = array();
        $resp = json_decode($resp);
        if(isset($resp->success) && $resp->success) {
            $elements_btn_array = listingIdSearchButtons($resp);
            $elem_objects       = listingIdElement($resp,$elements_btn_array);
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
            $gallery_view  = new stdClass();
            $gallery_view->messages[] = ['attachment' => $attachment];
            header('Content-Type: application/json');
            echo(json_encode($gallery_view));
        } else {
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
function agentListSearchFromListId($resp = null,$choice = null)
{
    if (is_null($resp)) {
        throw new Exception("No response found.", 1);
    }

    if (count($resp)) {
        $resp = json_decode($resp);
        $parent = array();
        $elements_btn_array = [];
        if (isset($resp->success) && $resp->success) {
            //if phone number is there
            if (!empty($resp->results->data[0]->propertyadditional->ListAgentDirectWorkPhone)) {
                $btn_obj = new stdClass();
                $btn_obj->type = "phone_number";
                $btn_obj->phone_number = $resp->results->data[0]->propertyadditional->ListAgentDirectWorkPhone;
                $btn_obj->title = "Call Agent";
                array_push($elements_btn_array, $btn_obj);


                $payload = new stdClass();
                $payload->template_type = "button";
                $payload->text = ((!empty($resp->results->data[0]->propertyadditional->ListAgentFullName)) ? $resp->results->data[0]->propertyadditional->ListAgentFullName : 'Agent name not available ') . "," . ((!empty($resp->results->data[0]->propertyadditional->ListOfficeName)) ? $resp->results->data[0]->propertyadditional->ListOfficeName : 'Office name not available');
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

            } else {

                $textobj = new stdClass();
                $textobj->text = ((!empty($resp->results->data[0]->propertyadditional->ListAgentFullName)) ? $resp->results->data[0]->propertyadditional->ListAgentFullName : 'Agent name not available ') . "," . ((!empty($resp->results->data[0]->propertyadditional->ListOfficeName)) ? $resp->results->data[0]->propertyadditional->ListOfficeName : 'Office name not available');
                array_push($parent, $msg);
                $agent_detail = new stdClass();
                $agent_detail->messages = $parent;
                header('Content-Type: application/json');
                echo(json_encode($agent_detail));

            }

        } else {
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
 * Function for creating the response for searching agent details from a list of properties on the basis of postal code, address or city
 * @param $agent_name
 * @param $agent_office_name
 * @param $agent_phone_number
 */
function agentListSearch($agent_name,$agent_office_name,$agent_phone_number) {
    if ($agent_phone_number == '0') {
        $textobj = new stdClass();
        $textobj->text = $agent_name. "," .$agent_office_name;
        array_push($parent, $msg);
        $agent_detail = new stdClass();
        $agent_detail->messages = $parent;
        header('Content-Type: application/json');
        echo(json_encode($agent_detail));
    } else {
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

/***
 * Creates the button structure for the chatfuel response on the  basis of listing id search
 * @param $resp_arr
 * @return array
 */
function listingIdSearchButtons($resp_arr) {
    $elements_btn_array = [];
    $btn_obj_details	    = new stdClass();
    $btn_obj_details->type  ="web_url";
    $btn_obj_details->url   = "http://search.homelasvegas.com/idx/details/listing/b015/".$resp_arr->results->data[0]->MLSNumber;
    $btn_obj_details->title = "View Listing Details";

    $btn_obj_agent              = new stdClass();
    $btn_obj_agent->type        = "show_block";
    $btn_obj_agent->block_names = ["View Listing Agent"];
    $btn_obj_agent->title        = "Agent Details";

    if($resp_arr->Status == "Active" && !empty($resp_arr->results->data[0]->VirtualTourLink)){
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
function listingIdElement($resp_arr,$elements_btn_array) {
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
function listSearch($resp = null,$choice = null) {
    if(is_null($resp) || is_null($choice)){
        throw new Exception("No response found.", 1);
    }
    if (count($resp)) {
        $elements = array();
        $page_count = 1;
        $resp = json_decode($resp);
        if(isset($_GET['page_count'])) {
            $page_count =$_GET['page_count'];
        }

        if (isset($resp->success) && $resp->success) {
            $resp_arr = $resp->results->data;
            if (count($resp_arr)) {
                    $gallery_view  = new stdClass();
                    foreach ($resp_arr as $data) {
                        $elements_btn_array = createlistingSearchButtons($data,$choice);
                        $elem_objects       = createlistingElement($data,$elements_btn_array);
                        array_push($elements, $elem_objects);
                    }
                    $payload = new stdClass();
                    $payload->template_type = "generic";
                    $payload->image_aspect_ratio = "square";
                    $payload->elements = $elements;

                    $attachment = new stdClass();
                    $attachment->type = "template";
                    $attachment->payload = $payload;

                    $gallery_view->messages[] = ['attachment' => $attachment];

                    // if counter is more than 5 need to have a pagination
                    if ($page_count <= $resp->results->last_page) {
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

/*function listSearch($resp = null) {
    if(is_null($resp)){
        throw new Exception("No response found.", 1);
    }
    if (count($resp)) {
        $elements = array();
        $elements_btn_array = array();
        $messages = array();
        $attachment_arr = array();
        $resp_arr = json_decode($resp);
        $counter  = 0;
        if (isset($_GET['start'])) {
            $paginate_start = $_GET['start'];
        } else {
            $paginate_start = 0;
        }
        if (isset($_GET['end'])) {
            $paginate_end  = $_GET['end'];
        } else {
            $paginate_end  = 2;
        }
        if (gettype($resp_arr) === 'object') {
            $msg = array('text' =>  "No Search Results!");
            $parent = array();
            array_push($parent,$msg);
            $obj  = new stdClass();
            $obj->messages = $parent;
            $variables_obj = new stdClass();
            $variables_obj->demo  =404;
            $obj->set_attributes = $variables_obj;
            print_r(json_encode($obj));
        } else {
            if (count($resp_arr)) {
                //count total number of objects
                $counter = count($resp_arr);
                if (array_key_exists($paginate_start, $resp_arr) && array_key_exists($paginate_end, $resp_arr)) {
                    for ($i=$paginate_start; $i < $paginate_end ; $i++) {
                        $btn_obj	= new stdClass();
                        $btn_obj->type ="phone_number";
                        $btn_obj->url = $resp_arr[$i]->office_phone_number;
                        $btn_obj->title = "Call";
                        $elements_btn_array[0] = $btn_obj;
                        //array_push($elements_btn_array[0], $btn_obj);
                        // creating element object
                        $elem_objects = new stdClass();
                        $elem_objects->title = $resp_arr[$i]->full_name;
                        $elem_objects->image_url = "http://159.203.81.237/test/GLVAR_transparent-logo.jpg";
                        $elem_objects->subtitle = $resp_arr[$i]->office_name;
                        $elem_objects->buttons = $elements_btn_array;
                        array_push($elements, $elem_objects);
                        // payload
                        $payload = new stdClass();
                        $payload->template_type = "list";
                        $payload->top_element_style = "large";
                        $payload->elements = $elements;
                        // configure chart
                        $attachment = new stdClass();
                        $attachment->type = "template";
                        $attachment->payload = $payload;
                        $list_view  = new stdClass();
                        $list_view->messages[] = ['attachment' => $attachment];
                    }
                    // print_r($counter);
                    // if counter is more than 2 need to have a pagination
                    if ($counter > 2) {
                        // set user attribute here
                        $variables_obj = new stdClass();
                        $variables_obj1 = new stdClass();
                        $variables_obj1->demo  =200;
                        $variables_obj1->page_strt = $paginate_start+2;
                        $variables_obj1->page_end = $paginate_end+2;
                        $list_view->set_attributes = $variables_obj1;
                    } else {
                        $variables_obj = new stdClass();
                        $variables_obj->demo  =404;
                        $list_view->set_attributes = $variables_obj;
                    }
                    print_r(json_encode($list_view));
                } else {
                    $msg = array('text' =>  "No More Results!");
                    $parent = array();
                    array_push($parent,$msg);
                    $obj  = new stdClass();
                    $obj->messages = $parent;
                    $variables_obj = new stdClass();
                    $variables_obj->demo  =404;
                    $obj->set_attributes = $variables_obj;
                    print_r(json_encode($obj));
                }

            } else {
                $msg = array('text' =>  "No Search Results!");
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
        $msg = array('text' =>  "No Search Results!");
        $parent = array();
        array_push($parent,$msg);
        $obj  = new stdClass();
        $obj->messages = $parent;
        print_r(json_encode($obj));
    }
}*/