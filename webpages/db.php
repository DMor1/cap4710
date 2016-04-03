<?php
session_start();

$servername = "raspbiripi.ddns.net";
//$servername = "localhost";
$username = "pi";
$password = "pipipi";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
?>
