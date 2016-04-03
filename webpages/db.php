<?php
session_start();

$servername = "raspbiripi.ddns.net";
$servername = "localhost";
$dbName = "cop4710db";
$username = "pi";
$password = "pipipi";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

mysqli_select_db($conn, $dbName);
//echo "Connected successfully";

function debug_print($input)
{
	echo '<pre>';
	echo var_dump($input);
	echo '</pre>';
}
?>
