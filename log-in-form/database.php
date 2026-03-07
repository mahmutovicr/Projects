<?php
$hostName = "sql102.infinityfree.com";
$dbUser = "if0_41332130";
$dbPassword = "Bosnjo12345";
$dbName = "if0_41332130_users";

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
