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
 * @return string|exception
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

function doRequest($my_url = null) {
	if (isset($my_url) && strlen($my_url)) {
		if (!file_exists('log/info.log')) {
			throw new Exception("create a log file log/info.log", 1);
		} else {
			// get the requested url inside log
			file_put_contents('log/info.log', "Requested url :: ".BASE_API_URL.$my_url);
			$curl = curl_init();
		    curl_setopt($curl, CURLOPT_URL, $my_url);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		    $result = curl_exec($curl);
		    curl_close($curl);
		    print_r($result);
		}
	} else {
		throw new Exception("No URL has been passed to make a request", 1);
		
	}
}