<?php 

$serverName = "localhost";
$dbUserName = "root";
$dbPassword = "";
$dbName = "blogs";

$connection = mysqli_connect($serverName, $dbUserName, $dbPassword, $dbName);

if (!$connection) {
    die("Connection failed ".mysqli_connect_error());
}

?>