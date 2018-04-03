<!DOCTYPE HTML>  
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>

<?php
/*
include '/../conn1.php';
session_start();
$mes_id=$_SESSION["mes_id"];
*/
$m_id_php = $_GET['id'];
//exit();
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

<div class="aspect-ratio">
<iframe width="350" height="315"
src="https://www.youtube.com/embed/fXIeFJCqsPs">
</iframe>
</div>

</body>
</html>

