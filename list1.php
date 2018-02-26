<?php
include 'conn.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
if(isset($_POST["action"]))
$action=$_POST["action"];
elseif (isset($_GET["action"])) {
	$action=$_GET["action"];
}
switch ($action) {
	case 'bot':
		$data=$_GET;
		$sql = "SELECT * FROM bot ";
        $result = $conn->query($sql);
        
	  	if ($result->num_rows > 0) {
		     $bot_detail=array();
		     
		    while($row = $result->fetch_assoc()) {
		       $bot_detail["messages"][]["text"]="EmpName=".$row['empname'];
		    }
		    echo json_encode($bot_detail);
		} else {
		   return 0;
		}
		break;
	case 'url_access':
		$data=$_GET;
		$first_name=$_GET["first_name"];
		$last_name=$_GET["last_name"];
		$office_name = $_GET["office_name"];
	 	$service_url = "http://members.lasvegasrealtor.com/search/v1/realtors?first_name=".$first_name."&last_name=".$last_name."&office_name=".$office_name;
	 //	$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
   	$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		curl_close($curl);
	  
		
		$user_detail=json_decode($result);
		/*print_r($user_detail);*/
 		
    $array1 = json_decode(json_encode($user_detail), True);
    $arrsize=sizeof($array1);
		$counter=0; 
		//echo "<pre>";
		// print_r($array1); 
		// exit; 
		$resArr = [];	
		foreach ($array1 as $rkey => $rvalue) {
		//	if ($rkey >= $offset && $counter <= 9) 
			if(isset($rvalue['status'])){

				$resArr["messages"][]["text"]="No data found";

			}else{

				if($counter==0){

						/*$resArr['messages'][$counter]['attachment']['type'] =  'template';
						$resArr['messages'][$counter]['attachment']['payload']['template_type'] =  'button';
						$resArr['messages'][$counter]['attachment']['payload']['text'] =  'Text';
						$resArr['messages'][$counter]['attachment']['payload']['buttons'][0]['type'] =  $rvalue['office_phone_number'];
						$resArr['messages'][$counter]['attachment']['payload']['buttons'][0]['url'] =  "http://portal.tier5.in";
						$resArr['messages'][$counter]['attachment']['payload']['buttons'][0]['title'] =  $rvalue['office_phone_number'];*/
						$resArr["messages"][]["text"]="data found";
						$counter++;

				}
			}
			// $resArr['messages'][$rkey] = 
		}

		/*echo "<pre>";
		print_r($resArr);*/
		print_r(json_encode($resArr));

	break;
	
	default:
		echo "no";
		break;
}
?>