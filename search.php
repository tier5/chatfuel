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
		    CURLOPT_USERAGENT => 'Requesting to las vegas relator search....'
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
						$btn_obj->phone_number = $resp_arr[$i]->office_phone_number;
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
}