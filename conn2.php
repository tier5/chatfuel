<?php

session_start();
include 'conn.php';
//include 'sample_feedback.php';
/*ini_set('display_errors', 1);
error_reporting(E_ALL);*/

if($_POST) {
    $mes_id = $_POST['messenger_user_id'];
    $feedback1 = $_POST['fdb1'];
    $feedback2 = $_POST['fdb2'];
        $inf = $_POST['inf'];
	$vid = $_POST['video'];
        $last_id="";
	$level = $_POST['level'];
}

$last_id=$con->insert_id;

$sql1 = "INSERT INTO `feedback` (`messenger_id`,`feedback1`,`feedback2`,`influencer`,`video`,`level`) VALUES ('$mes_id','$feedback1','$feedback2','$inf','$vid','$level')";

if (mysqli_query($con, $sql1)) {
	//$_SESSION["id"]=$last_id;

        $user_detail = new stdClass();
        $user_detail ->type="text";
        $user_detail="Feedback saved successfully";
        $list_view= new stdClass();
        $list_view->messages[] = ['text' => $user_detail];
  
  } else {
	 $user_detail = new stdClass();
         $user_detail ->type="text";
         $user_detail="Try again";
         $list_view= new stdClass();
         $list_view->messages[] = ['text' => $user_detail]; 

  }

  echo json_encode($list_view);

//  feedback_count($con,$mes_id,$inf);

?>

