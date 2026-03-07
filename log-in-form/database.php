<?php
$hostName = "sqlXXX.infinityfree.com";
$dbUser = "your_db_username";
$dbPassword = "your_db_password";
$dbName = "your_db_name";

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
