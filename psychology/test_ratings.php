<!DOCTYPE HTML>  
<html>
<head>
</head>
<body>  
<h1 align="centre">Rate us!</h1>


<?php

/*include '/../conn1.php';
session_start();

$remarks = $_POST["remarks"];
$last_id = $_POST["short_id"];
/*if($con->query($sql)===TRUE)
{
   // echo "New Record Created succussfully";
  $last_id=$con->insert_id;
}

$sqli = "UPDATE `user_assessment` SET `remarks`='$remarks' WHERE `short_id`='$last_id'";

if($con->query($sqli)===TRUE)
{
   // echo "New Record Created succussfully";

}
*/

$ratings = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $ratings = ($_POST["ratings"]);
  //$comment = ($_POST["comment"]);
}

?>


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
<form method="post" action="thanks.html">
<br><br>
 <input type="radio" name="ratings" <?php if (isset($ratings) && $ratings=="good") echo "checked";?> value="like">Was good!
 <br><br>
<input type="radio" name="ratings" <?php if (isset($ratings) && $ratings=="fun") echo "checked";?> value="dislike">Was fun!
 <br><br>
<input type="radio" name="ratings" <?php if (isset($ratings) && $ratings=="excellent") echo "checked";?> value="dislike">Was excellent!
<br><br>
<button name="submit" action="submit">Submit</button>
<br><br>
</form>

</body>
</html>
