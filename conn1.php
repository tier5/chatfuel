<?php
$servername = "hhttp://54.197.11.249/";
$username = "root";
$password = "toor";
$dbname = "webview";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>