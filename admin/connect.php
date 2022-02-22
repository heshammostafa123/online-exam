<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dpname="quiz_adb";
// Create connection
$conn = mysqli_connect($servername, $username, $password,$dpname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
