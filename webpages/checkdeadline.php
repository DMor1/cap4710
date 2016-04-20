<?php
	include_once("util.php");
	include_once("db.php");
	include_once("email_templates/nomineeReminderEmail.php");
	
	echo "Reminding Nominees";

	//Get Current date
	$currDate = getCurrentDate();

	//Get Deadline date
	$sql = "SELECT end_date 
			FROM sessions
			WHERE session_id = (SELECT max(session_id) FROM sessions)";

	//Fetch current 
	if($result = mysqli_query($conn, $sql)) {
		//Pull results from query res	
		$row = mysqli_fetch_array($result);

		//Verify result exists
		if($row["end_date"] != null) {
			//Store as deadline date
			$deadlineDate = $row["end_date"];

			//Compare the dates
			$diff = dayDifference($currDate, $deadlineDate);

			//If deadline is in two days
			if($diff === 2) {
				//Query nominees
				$sql = "SELECT nominee_user_id
						FROM nominees
						WHERE respondNomination is NULL";

				if($result = mysqli_query($conn, $sql)) {
					while($row = mysqli_fetch_array($result)) {
						//Get user id of the nominee who needs to be reminded
						$nid = $row['nominee_user_id'];	

						//Get information
						$ninfo = getNomineeInfo($nid);
						
						$neefname = $ninfo["fname"];
						$neelname = $ninfo["lname"];
						$neeEmail = $ninfo["email"];
						
						//Get list of all nominators
						$nators = getNominators($nid);

						//Loop through all nators
					    while($row = mysqli_fetch_array($nators)) {
							$natorID = $row["user_id"];
							$natorfname = $row["fname"];
							$natorlname = $row["lname"];
							
							//Get Email Body 
							$msg = getNomineeReminderEmail($neefname, $neelname, $natorfname, $natorlname, $nid, $natorID);			
							//Send email
							sendEmailReminder($neeEmail, $msg);

							echo "Email Sent to: " . $neefname . " " . $neelname . "\t" . $neeEmail . ". Nominated by:\t" . $natorID . "\t" . $natorfname . " " . $natorlname . "\n"; 
						}						
					}
				}
			}
		}
	}

	//Get info about nominee
	function getNomineeInfo($nid) {
		//SQL Query to get nee info
		$sql = "SELECT fname, lname, email  
				FROM users
				WHERE user_id = " . $nid;

		//Execute query
		global $conn;
		if($result = mysqli_query($conn, $sql)) {
        	//Fetch row - should only be one result 
         	$row = mysqli_fetch_array($result);
			
			//Return results	
			return $row;
		}
	}

	
	function getNominators($nid) {
		$sql = "SELECT user_id, fname, lname
				FROM (SELECT nominated_by_user_id
					  FROM nominees
					  WHERE nominee_user_id = " . $nid . ") AS nom
				INNER JOIN users
				ON nom.nominated_by_user_id = users.user_id";

		global $conn;
		if($result = mysqli_query($conn, $sql)) {
        	//Fetch results 
         	return $result;
		}
		else 
			return null;
	}

	//Send reminder email to nominee
	function sendEmailReminder($to, $message) {
		$subject = "Urgent! 2 Days until the deadline!";

		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: <automatedcop4710@gmail.com>' . "\r\n";

		mail($to, $subject, $message, $headers);
	}
?>
