<?php
include 'conn.php';
if(isset($_POST["action"]))
$action=$_POST["action"];
elseif (isset($_GET["action"])) {
	$action=$_GET["action"];
}
switch ($action) {
	case 'bot':
		$data=$_GET;
		$sql = "SELECT * FROM bot  ";
        $result = $conn->query($sql);
        //echo "asdfgjk";
        //print_r($result->num_rows);
	  	if ($result->num_rows > 0) {
		     $bot_detail=array();
		     
		    while($row = $result->fetch_assoc()) {
		       $bot_detail["messages"][]["text"]="Empname=".$row['empname'],"Empslary".$row['salary'];
		    }
		    echo json_encode($bot_detail);
		} else {
		   return 0;
		}
		break;
	
	default:
		echo "no";
		break;
}
?>
