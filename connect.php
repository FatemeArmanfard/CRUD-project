<?php
$servername = "<put your server's address here";
$username = "<put your username here>";
$password = "<put your passsword here>";
$dbname = "<put your database name here>";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
?>