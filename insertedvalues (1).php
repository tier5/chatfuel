<!DOCTYPE html>
<html>
<head>
	<title>InsertedValue</title>
</head>
<body>


<?php
$servername = "localhost";
$username ="root";
$password = "toor";
$dname="durgeshDB";
$tname="test";
$id=$_POST["id"];
$fname=$_POST["fname"];
$lname=$_POST["lname"];
$email=$_POST["eid"];
$age = $_POST["age"];
$conn=new mysqli($servername,$username,$password,$dname);
if($conn->connect_error){
	die("Connection failed : ".$conn->connect_error);
	}
$sql = ("INSERT INTO ".$tname." (id,firstName,lastName,age) VALUES ('".$id."','".$fname."','".$lname."','".$age."')");

if($conn->query($sql)===TRUE)
{
    echo "New Record Created succussfully";
}
else
{
    echo "Error : ".$sql."<br>".$conn->error;
}

?>
</body>
</html>