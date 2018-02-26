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
	 	$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
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
		echo "<pre>";
		// print_r($array1); 
		// exit; 
		$resArr = [];	
		foreach ($array1 as $rkey => $rvalue) {
			if ($rkey >= $offset && $counter <= 9) {
				$resArr['messages'][$rkey]['attachment']['type'] =  'template';
				$resArr['messages'][$rkey]['attachment']['payload']['text'] =  'Text';
				$resArr['messages'][$rkey]['attachment']['payload']['template_type'] =  'button';
				$resArr['messages'][$rkey]['attachment']['payload']['buttons'][0]['type'] =  $rvalue['office_phone_number'];
				$resArr['messages'][$rkey]['attachment']['payload']['buttons'][0]['phone_number'] =  $rvalue['office_phone_number'];
				$resArr['messages'][$rkey]['attachment']['payload']['buttons'][0]['title'] =  $rvalue['office_phone_number'];
				$counter++;
			}
			
			// $resArr['messages'][$rkey] = 
		}
		print_r(json_encode($resArr));
     //  foreach ($array1 as $key => $value) {
     //  	if($counter<=9)
     //   $user1["messages"][]["text"]="Full Name = ".$value["full_name"].", Company Name = ".$value["office_name"].", Office Phone Number = ".$value["office_phone_number"];
     // 		$counter++;	
     // 		//continue;

		   // }
				// echo json_encode($user1);
				/*if($counter==9 && $counter<=18)
				{
					echo json_encode($user1);
					$counter++;
				}*/



				/*if($counter==11){
			foreach ($array1 as $key => $value) {
      	if($counter==11 && $counter<=18)
       $user1["messages"][]["text"]="Full Name = ".$value["full_name"].", Company Name = ".$value["office_name"].", Office Phone Number = ".$value["office_phone_number"];
     		$counter++;	
     	}
		   }*/
		   //print_r($counter);

		   //echo json_encode($user1);


			//print_r($counter);
			
		  exit();
		
		break;
	
	default:
		echo "no";
		break;
}
?>