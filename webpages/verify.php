<?php
include_once("login_check.php"); // this must come first
include_once("db.php");

check_role(3); // role_id 3 is for nominators

$nominee_user_id = $_GET["u"]; // user_id


if(!empty($_POST))
{
	$nominee_user_id = $_POST["u"];
	$isverified = -1;
	if($_POST["verify_action"] == "Yes")
	{
		$isverified = 1;
	}
	else if($_POST["verify_action"] == "No")
	{
		$isverified = 0;
	}
	
	if($isverified > -1)
	{
		echo "Thank you for your submission";
		// Update nominees table
		$sql="
				UPDATE nominees 
				SET 
				isverified = " . $isverified . "
				WHERE nominee_user_id = " . $nominee_user_id . "
				AND session_id = (select max(session_id) from sessions)";
			if ($conn->query($sql) === TRUE){/*echo "New record created successfully2<br>";*/}
			else {echo "Error: " . $sql . "<br>" . $conn->error;}	
		$conn->close();	
	}
	else
	{
		echo "This page was submitted incorrectly.";
	}
	
	
	die();
}
else
{
// Get basic data about nominee
	$sql="
		SELECT 
			users.name AS nominator_name,
			table1.* 
		FROM
		(
			SELECT 
				users.name AS nominees_name,
				users.phonenumber AS nominees_phonenumber,
				users.pid AS nominees_pid,
				users.email AS nominees_email,
				nominees.is_curr_phd AS nominees_isphd,
				nominees.num_sem_as_grad AS nominees_numgrad,
				speak_test.status AS speak_test_status,
				nominees.phd_advisor_name AS nominees_phdadvisor,
				nominees.cummulative_gpa AS nominees_gpa,
				publications.publication_name_and_citations AS pub_namesandcits,
				nominees.nominated_by_user_id AS nominated_by_user_id
			FROM users 
			INNER JOIN nominees
			ON nominees.nominee_user_id = users.user_id
			AND nominees.session_id = (select max(session_id) from sessions)
			INNER JOIN speak_test
			ON speak_test.speak_test_id = nominees.speak_test_id
			INNER JOIN publications
			ON publications.nominee_user_id = users.user_id
			AND publications.session_id = (select max(session_id) from sessions)
			WHERE user_id = " . $nominee_user_id . "
		) table1
		INNER JOIN users
		ON table1.nominated_by_user_id = users.user_id";
	//debug_print($sql);
	$result=mysqli_query($conn,$sql);
		//debug_print($result);

	if ($result)
	{
		// should only be one row
		$nomineeUserRow=mysqli_fetch_array($result);
		// Free result set
		mysqli_free_result($result);
	}

	
	// Get data for advisors
	$sql = "
	SELECT *
	FROM advisors
	WHERE user_id = " . $nominee_user_id;
	//debug_print($sql);
	$advisors_result=mysqli_query($conn,$sql);
		//debug_print($result);

	$sql = "
		SELECT * FROM courses_taken
		INNER JOIN courses
		ON courses.course_id = courses_taken.course_id
		WHERE courses_taken.user_id = " . $nominee_user_id;
	//debug_print($sql);
	$courses_result=mysqli_query($conn,$sql);
	
	
}
?>
<html>
	<head>
		<title>Verify</title>
		<link rel="stylesheet" href="style.css">
	</head>

	<body>
		<h2>Verify the information of <?php echo $nomineeUserRow["nominees_name"]; ?></h2>
		<table>
				<tr>
					<td>Name of the nominator:</td>
					<td>&emsp;&emsp;</td>
					<td>
						<?php echo $nomineeUserRow["nominator_name"]; ?>
					</td>
				</tr>

				<tr>
					<td>Name of current Ph.D. advisor:</td>
					<td></td>
					<td><?php echo $nomineeUserRow["nominees_phdadvisor"]; ?></td>
				</tr>

				<tr>
					<td COLSPAN="3">List your past advisors and the years you had them:</td>
				</tr>

				<tr class="list">
					<td>Advisor Name</td>
					<td></td>
					<td>Start Year</td>
					<td>End Year</td>
					<td></td>
				</tr>
				<?php
					if ($advisors_result)
					{
						while ($row=mysqli_fetch_array($advisors_result))
						{
							echo '<tr class="list">';
							echo '<td>' . $row["advisor_name"] . '</td>';
							echo '<td></td>';
							echo '<td>' . $row["start_year"] . '</td>';
							echo '<td>' . $row["end_year"] . '</td>';
							echo '<td></td>';
							echo '</tr>';
						}
						
						// Free result set
						mysqli_free_result($advisors_result);
					}
				?>
			

				<tr><td>&emsp;</td></tr>

				<tr>
					<td>Your name</td>
					<td></td>
					<td><?php echo $_SESSION["name"]; ?></td>
				</tr>

				<tr>
					<td>Your PID</td>
					<td></td>
					<td><?php echo $nomineeUserRow["nominees_pid"]; ?></td>
				</tr>

				<tr>
					<td>Your email</td>
					<td></td>
					<td><?php echo $nomineeUserRow["nominees_email"]; ?></td>
				</tr>

				<tr>
					<td>Your phone number</td>
					<td></td>
					<td><?php echo $nomineeUserRow["nominees_phonenumber"]; ?></td>
				</tr>

				<tr>
					<td>Are you a Ph.D. student in Computer Science?</td>
					<td></td>
					<td><?php echo $nomineeUserRow["nominees_isphd"]; ?></td>
				</tr>

				<tr>
					<td>How many semesters have you been a graduate student?</td>
					<td></td>
					<td><?php echo $nomineeUserRow["nominees_numgrad"]; ?></td>
				</tr>

				<tr>
					<td>Have you passed the SPEAK test?</td>
					<td></td>
					<td><?php echo $nomineeUserRow["speak_test_status"]; ?></td>
				</tr>

				<tr>
					<td COLSPAN="3">List all graduate-level courses you have completed, as well as the grade you received for each:</td>
				</tr>

				<tr class="list">
					<td>Course Name</td>
					<td></td>
					<td>Grade Received</td>
					<td></td>
					<td></td>
				</tr>
				<?php
				
					if ($courses_result)
					{
						while ($row=mysqli_fetch_array($courses_result))
						{
							echo '<tr class="list">';
							echo '<td>' . $row["course_name"] . '</td>';
							echo '<td></td>';
							echo '<td>' . $row["course_grade"] . '</td>';
							echo '<td></td>';
							echo '<td></td>';
							echo '</tr>';
						}
						
						// Free result set
						mysqli_free_result($courses_result);
					}
					
				?>
				

				<tr><td>&emsp;</td></tr>

				<tr>
					<td>Enter your cumulative GPA for the above courses:</td>
					<td></td>
					<td><?php echo $nomineeUserRow["nominees_gpa"]; ?></td>
				</tr>

				<tr>
					<td>List all publications, and prove citation:</td>
					<td></td>
					<td><pre><?php echo $nomineeUserRow["pub_namesandcits"]; ?></pre></td>
				</tr>

				<tr><td>&emsp;</td></tr>

				<tr>
					<td colspan="5" class="submitrow">Is the above information correct?</td>
				</tr>

				<tr>
					<td colspan="5" class="submitrow">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<input type="hidden" id="u" name="u" value="<?php echo $nominee_user_id; ?>" />
							<input type="submit" class="buttons" value="Yes" name="verify_action" id="verified" />
							&emsp;
							<input type="submit" class="buttons" value="No" name="verify_action" />
						</form>
					</td>
				</tr>
			</table>
	</body>
</html>
<?php
$conn->close(); // since inline html the db is being used, this has to be closed at the end
?>