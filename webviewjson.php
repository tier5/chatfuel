<?php
include 'conn1.php';
session_start();
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
		$phone1 = $_SESSION['varname'];
		$sql = "SELECT * FROM basic WHERE phone='$phone1' ";
        $result = $conn->query($sql);
        $messages = array();
	  	if ($result->num_rows > 0) {
		     $bot_detail=array();
		     
		    while($row = $result->fetch_assoc()) {
		       /*$bot_detail["messages"][]["text"]="EmpName=".$row['name'];*/

		       $btn_obj = new stdClass();
					 $btn_obj->type="text";
		       $btn_obj="EmpName=".$row['name'].","."Email=".$row['email'].","."Gender:".$row['gender'].","."Address=".$row['address'];
		       $list_view= new stdClass();
					 $list_view->messages[] = ['text' => $btn_obj];
		    }
		    echo json_encode($list_view);
		} else {
		   return 0;
		}
		break;
	}
?>