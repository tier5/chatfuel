<?php 
session_start();
include 'conn.php';
/*ini_set('display_errors', 1);
error_reporting(E_ALL);*/

if($_POST) {
    $mes_id = $_POST['messenger_user_id'];
    $_SESSION["mes_id"]=$mes_id;
 //   $assess = $_POST['assessment'];
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $dev = $_POST['device'];
   $cont = $_POST['content'];
    $topic = $_POST['topic'];
   // $inf = "";
   // if( $_POST['influencer'] ) {
        $inf = $_POST['inf'];
   // }
	$last_id="";

}

/* $btn_obj = new stdClass();
 $btn_obj->type="text";
 $btn_obj="EmpName=";
 $list_view= new stdClass();
 $list_view->messages[] = ['text' => $btn_obj];
 
 echo json_encode($list_view);
*/
 $sql = "INSERT INTO `user_assessment` (`messenger_user_id`,`first_name`,`last_name`,`device`,`content`,`topic`,`influencer`) VALUES ('$mes_id','$fname','$lname','$dev','$cont','$topic','$inf')";

  if (mysqli_query($con, $sql)) {
	$last_id=$con->insert_id;
	$_SESSION["id"]=$last_id;

	$user_detail = new stdClass();
	$user_detail ->type="text";
	$user_detail=$_SESSION['mes_id'];
	$list_view= new stdClass();
	$list_view->messages[] = ['text' => $user_detail];

  } else {

        $user_detail = new stdClass();
	$user_detail ->type="text";
	$user_detail="Try Again";
	$list_view= new stdClass();
	$list_view->messages[] = ['text' => $user_detail]; 

  }
  echo json_encode($list_view);

?>

