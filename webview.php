<?php 
include 'conn1.php';
session_start();
if($_POST)
{
	$name=$_POST["name"];
	$email=$_POST["email"];
	$password=$_POST["password"];
	$gender=$_POST["gender"];
	$address=$_POST["comment"];
	$password1=md5("$password");
	$phone=$_POST["$phone"];
	$_SESSION['varname'] = $phone;

	$query="INSERT INTO basic (name,email,password,gender,address,phone)
VALUES ('$name', '$email', '$password1','$gender','$address','$phone')";
if ($conn->query($query) === TRUE) {
    echo "New record created successfully";

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


}


?>
<html>
<body>
<form method="post" action="">
Name:<input type="text" name="name"  required><br>
Email:<input type="text" name="email"  required><br>
Password:<input type="Password" name="Password" required><br>
Phone_Number:<input type="text" name="phone" required><br>
Gender:
Male:<input type="radio" name="gender" value="male">
Female:<input type="radio" name="gender" value="female"><br>
Address: <textarea name="comment" rows="5" cols="40" required></textarea><br>
 Submit:<input type="submit" value="submit">	

<!-- Submit<input type="button" onclick="submitForm('page1.php')" value="submit" /> -->			
</form>
</body>
</html?