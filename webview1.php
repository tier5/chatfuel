<!DOCTYPE HTML>  
<html>
<head>
</head>
<body>  


<script>
      // Code copied from Facebook to load and initialise Messenger extensions
      (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.com/en_US/messenger.Extensions.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'Messenger'));
 </script>

<?php
$fname = $lname = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

 if (empty($_POST["fname"])) {
    $fname = "";
  } else {
    $fname = $_POST["fname"];
  }

  if (empty($_POST["lname"])) {
    $lname = "";
  } else {
    $lname = $_POST["lname"];
  }

/*function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
*/
}
?>


<form method="post" id="enter name form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
First name:<input type="text" name="fname">
<br><br>
Last name: <input type="text" name="lname">
<br><br>
<input type="submit" name="submit" value="Submit">  
</form>

<?php
$service_url='https://api.chatfuel.com/bots/${{botId}}/users/${{userId}}/send/<user_attribute_1>=$fname&<user_attribute_2>=$lname/'
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
curl_close($curl);

foreach($result as $value) {
 $btn_obj = new stdClass();
 $btn_obj->type="text";
 $btn_obj="First name:".$result['fname'].","."Last name".$result['lname'];
 $list_view= new stdClass();
 $list_view->messages[] = ['text' => $btn_obj];
}
 $r=json_decode($result);
?>

</body>
</html>
