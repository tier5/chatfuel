<?php
include 'conn.php';
session_start();

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
		$first_name=$_GET["first_name"]
		$last_name=$_GET["last_name"]
		$c_name=$_GET["c_name"]
	  

	  $user_detail={}

	  $user_detail["messages"]["text"]="First Name : ".$first_name." Last Name : ".$last_name." Company Name : ".$c_name
		echo json_encode($user_detail);
		break;
	
	default:
		echo "no";
		break;
}
?>
