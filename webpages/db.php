<?php
	//Initialize Session
	session_start();

	//Database Connection Information
	$servername = "localhost"; 
	$dbName = "cop4710db";
	$username = "pi";
	$password = "pipipi";

	//Create connection using specified credentials 
	$conn = new mysqli($servername, $username, $password);

	// Check connection for errors
	if ($conn->connect_error) {
		//Kill and exit script and print error message
    	die("Connection failed: " . $conn->connect_error);
	} 

	//Select default database to query
	mysqli_select_db($conn, $dbName);

	//Print information about a variable
	function debug_print($input)
	{
		echo '<pre>';
		echo var_dump($input);
		echo '</pre>';
	}

	//Given a date, return the semester it is part of (Fall, Spring, Summer)
	function get_semesterString($date)
	{	
		//Strip out year and month
		$year = substr($date,0,4);
		$month = substr($date,5,2);
		$semester = "";
		
		//Set Semester
		if($month < 5)
			$semester = "Spring ";
		else if($month >= 5 && $month < 8)
			$semester = "Summer ";
		else
			$semester = "Fall ";
		
		//Return semester and year
		return $semester . $year;	
	}
	
	function getUserEmail($user_id)
	{
		$returnValue = "error@raspbiripi.ddns.net";
		$sql = "SELECT email FROM users WHERE user_id = " . $user_id;
		$result=mysqli_query($conn,$sql);
		if ($result)
		{
			$row=mysqli_fetch_array($result);
			$returnValue=$row["email"];
		}
		
		return $returnValue;
	}
?>
