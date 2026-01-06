<?php
$host = "localhost";
$username = "root";
$password = ""; 
$database = "inaugural_booking";

$mysqli = new mysqli($host, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>