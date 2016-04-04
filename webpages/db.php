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

function get_semesterString($date)
{
	$year = substr($date,0,4);
	$month = substr($date,5,2);
	$semester = "";
	if($month < 5)
	{
		$semester = "Spring ";
	}
	else if($month >= 5 && $month < 8)
	{
		$semester = "Summer ";
	}
	else
	{
		$semester = "Fall ";
	}
	return $semester . $year;
	
}
?>
