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
   	$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		curl_close($curl);
	  // print_r($result);
		//exit();

		$user_detail=json_decode($result);

		/*print_r($user_detail);*/
 		

    $array1 = json_decode(json_encode($user_detail), True);
     /*print_r($array1);
     exit();*/

 			$user=array();
	 
      foreach ($array1 as $key => $value) {
       $user1["messages"][]["text"]="Full Name = ".$value["full_name"].", Company Name = ".$value["office_name"].", Office Phone Number = ".$value["office_phone_number"];
		   
      }
      
			
			echo json_encode($user1);
			
		exit();

		
			
    

		


		 //curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		// print_r($user_detail);
		 

		/*if(count($user_detail)===1)
		{
			
			$user_detail["messages"][]["text"]="Status : ".$user_detail['first_name']."Status :".$user_detail['last_name']." Status = ".$user_detail['office_name'];

			 

		}
		else
    {*/
	/*  $user_detail["messages"][]["text"]="First Name = ".$user_detail['first_name']."Last Name = ".$user_detail['last_name']." Company Name = ".$user_detail['office_name'];*/
	
	  /*$user_detail["messages"][0]["text"]="First Name : ".$user_detail["first_name"]."Last Name : ".$user_detail["last_name"]." Company Name : ".$user_detail["office_name"];*/


		
		//}
		/*echo json_encode($user_detail);*/
		break;
	
	default:
		echo "no";
		break;
}
?>
