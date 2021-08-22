<?php
$dbServerName = "gator4029.hostgator.com";
$dbUsername = "palabra1_q7admin";
$dbPassword = "Znjfflxl7";
$dbName = "palabra1_q7inquiry";

$connect = mysqli_connect($dbServerName, $dbUsername, $dbPassword, $dbName);
if (!$connect) {
  die("Connection failed: " . mysqli_connect_error());
}
?>