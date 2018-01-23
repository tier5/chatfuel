<?php 
include 'conn.php';

//session_start();

if($_POST)
{

$id=$_POST['empid'];
$name=$_POST['empname'];
$position=$_POST['empositon'];
$salary=$_POST['salary'];
$work=$_POST['work'];

$sql="INSERT INTO bot( empid,empname ,position ,salary,work) VALUES ('$id','$name','$position','$salary','$work') ";
//echo $conn;
$conn->query($sql);


 
	echo "success";


}








?>


<html>
<body>
<form  method="post" action="">

EmpId<input type="number" name="empid" placeholder="EMP_ID">require<br><br>
EmpName<input type="text" name="empname" placeholder="EMP_NAME"require><br><br>
Position<input type="text" name="empositon" placeholder="EMP_POSITION"require><br><br>
Salary<input type="number" name="salary" placeholder="EMP_SALARY"require><br><br>
Work<input type="text" name="work" placeholder="EMP_WORK"require><br><br>

Submit<input type="Submit" value="Submit">



</form>
</body>
</html>
