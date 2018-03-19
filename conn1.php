<?php 
include 'conn.php';
session_start();
/*ini_set('display_errors', 1);
error_reporting(E_ALL);*/

if($_POST) {
    $mes_id = $_POST['messenger_user_id'];
    $assess = $_POST['assessment'];
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $dev = $_POST['device'];
    $cont = $_POST['content_type'];
    $topic = $_POST['topic_interest'];
    $inf = "";
    if( $_POST['influencer'] ) {
        $inf = $_POST['influencer'];
    }
}

/*$user_detail = new stdClass();
$user_detail ->type="text";
$user_detail=$mes_id." ".$assess." ".$fname." ".$lname." ".$dev." ".$cont." ".$topic." ".$inf;
$list_view= new stdClass();
$list_view->messages[] = ['text' => $user_detail];

*/
switch($assess) {
    case 'Short assessment' :
        $sql = "INSERT INTO `Short assessment` (`messenger_id`,`first_name`,`last_name`,`device`,`content`,`topic`) VALUES ('$mes_id','$fname','$lname','$dev','$cont','$topic')";

        $user_detail = new stdClass();
        $user_detail ->type="text";

        if (mysqli_query($con, $database)) {

            $user_detail="Values are stored";
            $list_view= new stdClass();
            $list_view->messages[] = ['text' => $user_detail];

        } else {
            $user_detail="Try again";
            $list_view= new stdClass();
            $list_view->messages[] = ['text' => $user_detail];

        }

        echo json_encode($list_view);
    break;

    case 'Long assessment' :
        $sql = "INSERT INTO `Long assessment` (`messenger_id`,`first_name`,`last_name`,`device`,`content`,`topic`,`influencer`) VALUES ('$mes_id','$fname','$lname','$dev','$cont','$topic','$inf')";

        $user_detail = new stdClass();
        $user_detail->type="text";

        if (mysqli_query($con, $sql)) {
        $user_detail="Values are stored";
        $list_view= new stdClass();
        $list_view->messages[] = ['text' => $user_detail];

        } else {
            $user_detail="Try again";
            $list_view= new stdClass();
        $list_view->messages[] = ['text' => $user_detail];

        }

        echo json_encode($list_view);
    break;
}*/

?>

