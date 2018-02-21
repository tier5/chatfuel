<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
/**
 * @const BASE_API_URL is the api url which will get hit when we gonna call the function
 */
const BASE_API_URL = "http://members.lasvegasrealtor.com/search/v1/realtors?";

try {
	// calling the realtor search api function
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
 * This function searches for the realtors
 * @param null
 * @return string
 * @throws exception if no search query given or invalid action specified
 */
function processURL() {
	$action 			= $_GET['action'];
	if (isset($_GET['first_name'])) {
		$first_name 	= $_GET['first_name'];
	}
	if (isset($_GET['last_name'])) {
		$last_name 		= $_GET['last_name'];
	}
	if (isset($_GET['office_name'])) {
		$office_name	= $_GET['office_name'];
	}
	$my_url			= "";
	if ($action === 'search') {
		// if every input is present
		if (isset($first_name) && isset($last_name) && isset($office_name)) {
			$my_url = "first_name=".$first_name.""."&"."last_name=".$last_name.""."&"."office_name=".$office_name."";
		} else {
			if (isset($first_name)) {
				$my_url .= "first_name=".$first_name;
			} 
			if (isset($last_name)) {
				if (isset($first_name)) {
					$my_url .= "&last_name=".$last_name;
				} else {
					$my_url .= "last_name=".$last_name;
				}
			} 
			if (isset($office_name)) {
				if (isset($last_name) || isset($first_name)) {
					$my_url .= "&office_name=".$office_name;
				} else {
					$my_url .= "office_name=".$office_name;
				}
			}
			//nothing present
			if (!isset($first_name) && !isset($last_name) && !isset($office_name) && !strlen($first_name) && !strlen($last_name) && !strlen($office_name)) {
				throw new Exception("Error Processing Request. No search query given", 1);
				
			}
		}
		doRequest($my_url);
	} else {
		if (!strlen($action)) {
			throw new Exception("No action defined", 1);
		} else {
			throw new Exception("Invalid action specified", 1);
		}
	}
}
/**
 * This function do the curl request to the realtor api
 * @param  string $my_url url where request is being made
 * @return array 
 * @throws exception if no url has been passed
 */
function doRequest($my_url = null) {
	if (isset($my_url) && strlen($my_url)) {
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => BASE_API_URL.$my_url,
		    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);

		processOutput($resp);
		// Close request to clear up some resources
			curl_close($curl);
	} else {
		throw new Exception("No URL has been passed to make a request", 1);
		
	}
}

function processOutput($resp = null) {
	$elements = array();
	$elements_btn_array = array();
	$messages = array();
	$attachment_arr = array();

	$btn_obj	= new stdClass();
	$btn_obj->type ="web_url";
	$btn_obj->url = "https://tier5.us";
	$btn_obj->title = "View";
	array_push($elements_btn_array, $btn_obj);


	$elem_objects1 = new stdClass();
	$elem_objects1->title = "Glvar bot";
	$elem_objects1->image_url = "http://www.lasvegasrealtor.com/wp-content/themes/lasvegas/images/logo.jpg";
	$elem_objects1->subtitle = "Glvar Search results";
	$elem_objects1->buttons = $elements_btn_array;
	array_push($elements, $elem_objects1);
	$elem_objects2 = new stdClass();
	$elem_objects2->title = "Glvar bot2";
	$elem_objects2->image_url = "http://www.lasvegasrealtor.com/wp-content/themes/lasvegas/images/logo.jpg";
	$elem_objects2->subtitle = "Glvar Search results";
	$elem_objects2->buttons = $elements_btn_array;
	array_push($elements, $elem_objects2);

	$payload = new stdClass();
	$payload->template_type = "list";
	$payload->top_element_style = "large";
	$payload->elements = $elements;

	$attachment = new stdClass();
	$attachment->type = "template";
	$attachment->payload = $payload;

	$list_view  = new stdClass();
	$list_view->messages[] = ['attachment' => $attachment];
	print_r(json_encode($list_view));
	// exit();



	// $parent 	= array();
	// $msg    	= array();
	// $counter 	= 0;
	// if (count($resp)) {
	// 	$resp_arr = json_decode($resp);
	// 	if (gettype($resp_arr) === 'object') {
	// 		$msg = array('text' =>  "No Search Results!");
	// 		$parent = array();
	// 		array_push($parent,$msg);
	// 		$obj  = new stdClass();
	// 		$obj->messages = $parent;
	// 		print_r(json_encode($obj));
	// 	} else {
	// 		if (count($resp_arr)) {
	// 			foreach ($resp_arr as $key => $each_resp) {
	// 				$counter++;
	// 				if ($counter <= 10) {
	// 					$msg  = array("text" => "Full Name: ".$each_resp->full_name." Office Name: ".$each_resp->office_name." Office Phone Number: ".$each_resp->office_phone_number);
	// 					array_push($parent,$msg);
	// 				}
					
	// 			}
	// 			$obj  = new stdClass();
	// 			$obj->messages = $parent;
	// 			print_r(json_encode($obj));
	// 		} else {
	// 			$msg = array('text' =>  "No Search Results!");
	// 			$parent = array();
	// 			array_push($parent,$msg);
	// 			$obj  = new stdClass();
	// 			$obj->messages = $parent;
	// 			print_r(json_encode($obj));
	// 		}
			
	// 	}
	// } else {
	// 	$msg = array('text' =>  "No Search Results!");
	// 	$parent = array();
	// 	array_push($parent,$msg);
	// 	$obj  = new stdClass();
	// 	$obj->messages = $parent;
	// 	print_r(json_encode($obj));
	// }
}

