<?php 


$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "login_register";
$conn = mysqli_connect("localhost", "root", "", "login_register", 3307);
if (!$conn) {
 die("Connection failed: ".mysqli_connect_error());
}


?>