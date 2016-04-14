<?php
	include_once("util.php");
	include_once("db.php");

	//Get Current date
	$currDate = getCurrentDate();

	//Get Deadline date
	$sql = "SELECT end_date 
			FROM sessions
			WHERE session_id = (SELECT max(session_id) FROM sessions)";

	//Fetch current 
	if($result = mysqli_query($conn, $sql)) {
		$row = mysqli_fetch_array($result);

		if($row["end_date"] != null) {
			echo $row;
		}
	}

	$deadlineDate = ""; 
		
	//Compare the dates
	$diff = dayDifference($currDate, $deadlineDate);

	//If deadline is in two days
	if(diff === 2 && $_SESSION['emailReminderSent'] === false) {
		//Query nominees

		//Send emails to nominees

		$_SESSION['emailReminderSent'] = true;
	}
?>
