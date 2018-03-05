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
		
		$elements = array();
		$elements_btn_array = array();
		$messages = array();
		$attachment_arr = array();
		$array1=json_decode($result);

		
		if (gettype($array1) === 'object') {
			$msg = array('text' =>  "No Search Results!");
			$parent = array();
			array_push($parent,$msg);
			$obj  = new stdClass();
			$obj->messages = $parent;
			$variables_obj = new stdClass();
			$variables_obj->demo  =404;
			$obj->set_attributes = $variables_obj;
			print_r(json_encode($obj));
		} else{

		
	////	$resp_arr = json_decode($resp);
		if(count($array1)){
			$counter=count($array1);
		
	//	foreach ($array1 as $rkey => $rvalue) {
		$btn_obj = new stdClass();
		$btn_obj->type="phone_number";
		$btn_obj->url= $array1[1]->office_phone_number;
		$btn_obj->title="call";
		$elements_btn_array[0]=$btn_obj;

		$elem_objects = new stdClass();
		$elem_objects->title =$array1[1]->full_name;
		$elem_objects->image_url="http://159.203.81.237/test/GLVAR_transparent-logo.jpg";
		$elem_objects->subtitle=$array1[1]->office_name;
		$elem_objects->buttons = $elements_btn_array;
		array_push($elements,$elem_objects);

		$payload= new stdClass();
		$payload->template_type="list";
		$payload->top_element_style="large";
		$payload->elements=$elements;

		$attachment = new stdClass();
		$attachment->type="template";
		$attachment->payload=$payload;

		$list_view= new stdClass();
		$list_view->messages[] = ['attachment' => $attachment];
	
		//	}

		echo json_encode($list_view);
		}

			
}
	break;
	
	default:
		echo "no";
		break;
}
?>
