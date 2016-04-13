<?php
	//Import External files
	//include_once("login_check.php"); //This must come first, import checkrole function
	include_once("db.php"); //Connect to database and initialize session

	//role_id = 3 for Nominators
	//Verify valid role
	//check_role(3);

	//Store user id
	$nominee_user_id = $_GET["u"]; 

	//Continue if form was submitted (POST is not empty)
	if(!empty($_POST))
	{
		//Store user id		
		$nominee_user_id = $_POST["u"];
		
		//Verified flag
		$isverified = -1;
		
		//Check POST request if verified, store result
		if($_POST["verify_action"] == "Yes")
			$isverified = 1;
		else if($_POST["verify_action"] == "No")
			$isverified = 0;
	
		//If user is properly verified, prompt user and update database
		if($isverified > -1)
		{
			//Prompt user - submission approved
			echo "Thank you for your submission";

			//SQL Query to update nominee table
			$sql="
					UPDATE nominees 
					SET 
					isverified = " . $isverified . ",
					verifiedNomination = CURDATE()
					WHERE nominee_user_id = " . $nominee_user_id . "
					AND session_id = (select max(session_id) from sessions)";
		
			//Execute sql query
			if ($conn->query($sql) === TRUE)
			{
				//Query successfully executed, nominee updated
			}
			else 
			{
				//Error updating nominee table
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
			
			//Close database connection
			$conn->close();	
		}
		else
		{
			//User was not properly verified
			echo "This page was submitted incorrectly.";
		}	
	
		//Exit script, don't render the rest of the page
		die();
	}
	else
	{
		//Form was not submitted
		//SQL Query to obtain nominee information
		$sql="
			SELECT 
				users.fname AS nominator_first_name,
				users.lname AS nominator_last_name,
				table1.* 
			FROM
			(
				SELECT 
					users.fname AS nominees_first_name,
					users.lname AS nominees_last_name,
					users.phonenumber AS nominees_phonenumber,
					users.pid AS nominees_pid,
					users.email AS nominees_email,
					nominees.is_curr_phd AS nominees_isphd,
					nominees.num_sem_as_grad AS nominees_numgrad,
					nominees.num_sem_as_gta AS nominees_numgta,
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
	
		//Execute query and store results
		$result=mysqli_query($conn,$sql);

		//Check if query returned any results
		if ($result)
		{
			//Result was found - Should be one row - Store 
			$nomineeUserRow=mysqli_fetch_array($result);

			//Free memory from results
			mysqli_free_result($result);
		}

	
		//SQL Query - Get data about advisor
		$sql = "
			SELECT *
			FROM advisors
			WHERE user_id = " . $nominee_user_id;
		
		//Execute query and store result
		$advisors_result=mysqli_query($conn,$sql);

		//SQL Query - Get all courses the user took
		$sql = "
			SELECT * FROM courses_taken
			INNER JOIN courses
			ON courses.course_id = courses_taken.course_id
			WHERE courses_taken.user_id = " . $nominee_user_id;
	
		//Execute Query and store results
		$courses_result=mysqli_query($conn,$sql);
	}
?>

<html>
	<head>
		<title>Verify</title>
		<link rel="stylesheet" href="styles/style.css">
	</head>

	<body>
		<h2>Verify the information of <?php echo $nomineeUserRow["nominees_first_name"] . " " .$nomineeUserRow["nominees_last_name"]; ?></h2>
		<table>
				<tr>
					<td>Your name:</td>
					<td>&emsp;&emsp;</td>
					<td>
						<?php echo $nomineeUserRow["nominator_first_name"] . " " . $nomineeUserRow["nominator_last_name"]; ?>
					</td>
				</tr>

				<tr><td>&emsp;</td></tr>

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
					<td>Name</td>
					<td></td>
					<td><?php echo $nomineeUserRow["nominees_first_name"] . " " . $nomineeUserRow["nominees_last_name"]; ?></td>
				</tr>

				<tr>
					<td>PID</td>
					<td></td>
					<td><?php echo $nomineeUserRow["nominees_pid"]; ?></td>
				</tr>

				<tr>
					<td>Email</td>
					<td></td>
					<td><?php echo $nomineeUserRow["nominees_email"]; ?></td>
				</tr>

				<tr>
					<td>Phone number</td>
					<td></td>
					<td><?php echo $nomineeUserRow["nominees_phonenumber"]; ?></td>
				</tr>

				<tr>
					<td>Ph.D. student in Computer Science?</td>
					<td></td>
					<td><?php echo $nomineeUserRow["nominees_isphd"]; ?></td>
				</tr>

				<tr>
					<td>How many semesters have they been a graduate student?</td>
					<td></td>
					<td><?php echo $nomineeUserRow["nominees_numgrad"]; ?></td>
				</tr>

				<tr>
					<td>How many semesters have they worked as a GTA?</td>
					<td></td>
					<td><?php echo $nomineeUserRow["nominees_numgta"]; ?></td>
				</tr>

				<tr>
					<td>Have they passed the SPEAK test?</td>
					<td></td>
					<td><?php echo $nomineeUserRow["speak_test_status"]; ?></td>
				</tr>

				<tr>
					<td COLSPAN="3">List of all of the graduate level courses completed, as well as the grade received:</td>
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
					<td>Cumulative GPA for the above courses:</td>
					<td></td>
					<td><?php echo $nomineeUserRow["nominees_gpa"]; ?></td>
				</tr>

				<tr>
					<td>All publications, and prove citation:</td>
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
	//Close Database connection
	//Since inline html uses the database, this must be closed at the end
	$conn->close(); 
?>
