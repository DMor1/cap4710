<?php
	//Import External Files
	include_once("login_check.php"); //This must come first, import checkrole function
	include_once("db.php"); //Connect to database and initialize session
	include_once("email_templates/nomineeemail.php");
	include_once("util.php");

	//role_id = 3 for Nominators
	//Verify valid role - kick off if not nominator
	check_role(3); 

	$sql="
		SELECT initiation_date 
		FROM sessions
		WHERE session_id = (SELECT MAX(sessions.session_id) from sessions)
		";

	$result=mysqli_query($conn,$sql);
	$date2 = mysqli_fetch_array($result);


	//Continue if form was submitted (POST is not empty)
	if(!empty($_POST) && compareDates(getCurrentDate(),$date2['initiation_date']) != 1)
	{
		//SQL Query - Create nominee user
		$sql="
			INSERT into users (fname, lname, pid, email, username)
			VALUES(
				'" . $_POST["nomineeFName"] . "',
				'" . $_POST["nomineeLName"] . "',
				'" . $_POST["nomineePID"] . "',
				'" . $_POST["nomineeEmail"] . "',
				'" . $_POST["nomineeEmail"] . "')";	
	
		//Execute sql query and continue if successful
		if($conn->query($sql)===TRUE)
		{
			// create user_role record
			$user_id = $conn->insert_id;
			$_SESSION['u'] = $user_id;

			//SQL Query - Insert user role 
			//user role = 4 for nominee
			$sql="
				INSERT INTO user_roles (user_id,role_id)
				VALUES (" . $user_id . ",4)";

			//Execute Query
			if ($conn->query($sql) === TRUE)
			{
				//Query executed successfully
				/*echo "New record created successfully1<br>";*/
			}
			else 
			{
				//Query failed
				echo "Error: " . $sql . "<br>" . $conn->error;
			}	
		
			//SQL Query - Create nominee record
			$sql="
				INSERT INTO nominees
					(session_id,
					nominee_user_id,
					nominated_by_user_id,
					ranking,
					is_curr_phd,
					is_new_phd,
					receiveNomination)
				VALUES 
				(
					(select max(session_id) from sessions),
					" . $user_id . ",
					'" . $_SESSION["user_id"]."',
					'" . $_POST["nomineeRanking"] . "',
					'" . $_POST["currentPhd"] . "',
					'" . $_POST["newPhd"] . "',
					CURDATE()
				)";		
			
			//Execute query
			if ($conn->query($sql) === TRUE)
			{
				//Query executed successfully
				/*echo "New record created successfully2<br>";*/
			}
			else 
			{
				//Query failed
				echo "Error: " . $sql . "<br>" . $conn->error;
			}	


			// $sql="
				
			// "

		}


		$to = $_POST["nomineeEmail"];
		$subject = "You have been nominated to be a GTA";
		$fname = $_POST["nomineeFName"];
		$lname = $_POST["nomineeLName"];
		$natorFName = $_SESSION["fname"];
		$natorLName = $_SESSION["lname"];
		$natorId = $_SESSION["user_id"]; //Nominator id 
		$message = getNomineeEmailBody($fname, $lname, $natorFName, $natorLName, $_SESSION["u"], $natorId); 

		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: <automatedcop4710@gmail.com>' . "\r\n";

		mail($to, $subject, $message, $headers);
	
		//Close connection to database
		$conn->close();
	
		//Prompt user - successful submission
		echo "Thank you for your submission";

		//Exit script - dont render the rest of the page
		die();
	}
	else if(compareDates(getCurrentDate(),$date2['initiation_date']) == 1)
	{
		echo "You have missed the deadline for nominations, sorry.";
		die();
	}
	else
	{
		//Form was not submitted (yet)
		// Display nominator of who nominated this person based on login
		$nominator_name = $_SESSION['fname'];
		$nominator_last_name = $_SESSION['lname'];
		$nominator_email = $_SESSION["email"];
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Nominator UI</title>
		<link rel="stylesheet" href="styles/style.css">
	</head>

	<body>
		<table>
			<tr>
				<td><h2>Nominate a student to become a GTA</h2></td>
				<td>&emsp;&emsp;&emsp;&emsp;</td>
				<td>
					<a href="changepassword.php">
						<input type="button" class="logout" value="Change Password">
					</a>
				</td>
				<td>
					<a href="logout.php">
						<input type="button" class="logout" value="Log Out">
					</a>
				</td>
			</tr>
		</table>

		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<table>
				<tr>
					<td>Name of Nominator</td>
					<td></td>
					<td><?php echo $nominator_name . " " . $nominator_last_name; ?></td>
				</tr>

				<tr>
					<td>Email of Nominator</td>
					<td></td>
					<td><?php echo $nominator_email; ?></td>
				</tr>

				<tr><td>&emsp;</td></tr>

				<tr>
					<td>Name of Nominee</td>
					<td></td>
					<td><input type = "text" name = "nomineeFName" id="nomineeFName" placeholder="First Name" required></td>
					<td><input type = "text" name = "nomineeLName" id="nomineeLName" placeholder="Last Name" required></td>
				</tr>

				<tr>
					<td>Nominee Ranking</td>
					<td></td>
					<td colspan="2" style="text-align: center;"><input type = "number" name = "nomineeRanking" id="nomineeRanking" required></td>
				</tr>
				
				<tr>
					<td>PID of Nominee</td>
					<td></td>
					<td colspan="2" style="text-align: center;"><input type = "text" name = "nomineePID" id="nomineePID" required></td>
				</tr>
				
				<tr>
					<td>Email of Nominee</td>
					<td></td>
					<td colspan="2" style="text-align: center;"><input type = "email" name = "nomineeEmail" id="nomineeEmail" required></td>
				</tr>
				
				<tr>
					<td>Is the nominee currently a Ph.D. </br> student in the Department of </br> Computer Science?</td>
					<td>&emsp;&emsp;</td>
					<td colspan="2" style="text-align: center;">
						<input type="radio" name="currentPhd" class="radios" value='1'> Yes<br>
						<input type="radio" name="currentPhd" class="radios" value='0'> No
					</td>
				</tr>
				
				<tr>
					<td>Is the nominee a newly admitted </br> Ph.D. student?</td>
					<td></td>
					<td colspan="2" style="text-align: center;">
						<input type="radio" name="newPhd" class="radios" value='1'> Yes<br>
						<input type="radio" name="newPhd" class="radios" value='0'> No
					</td>
				</tr>
				
				<tr><td>&emsp;</td></tr>
				
				<tr>
					<td colspan="4" class="submitrow">
						<input type="submit" class="buttons" value="Submit">
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>
