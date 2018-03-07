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
	  
	  
		
		$array1=json_decode($result, True);
		/*print_r($user_detail);*/
 		$arrsize= sizeof($array1);
		$counter= 0; 
		/*echo "<pre>";
		print_r($array1); 
		 exit; */
		$resArr = [];
		$elements_array=array();
		$attachment_array=array();

			/*$resArr =array();
			$elements_array=array();
			$attachment_array=array();*/
		
			
		if(isset($array1['status'])){

				$resArr["messages"][]["text"]="No data found";

		}else{

			foreach ($array1 as $rkey => $rvalue) {
				if($counter < 2){
					
			
					
					$elements_array[$counter]['title'] =  $rvalue['full_name'];
					$elements_array[$counter]['image_url'] =  "http://www.lasvegasrealtor.com//wp-content//themes//lasvegas//images//logo.jpg";
					$elements_array[$counter]['subtitle'] =  $rvalue['office_name'];
					$elements_array[$counter]['buttons'][0]['type'] =  "URL";
					$elements_array[$counter]['buttons'][0]['url']  =  "http://portal.tier5.in/employee_control/Employee";
					$elements_array[$counter]['buttons'][0]['title']=  "View Website";
					
					$counter++;

				}
			}

			$attachment_array['type'] =  'template';
			$attachment_array['payload']['template_type'] =  'list';
			$attachment_array['payload']["top_element_style"] = "large";
			$attachment_array['payload']['elements']  = $elements_array;
		



			$resArr['messages'][]['attachment']= $attachment_array;
		}

		echo json_encode($resArr);	

	break;
	
	default:
		echo "no";
		break;
}
?>
