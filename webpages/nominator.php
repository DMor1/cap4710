<?php
	//Import External Files
	include_once("login_check.php"); //This must come first, import checkrole function
	include_once("db.php"); //Connect to database and initialize session

	//TODO: Email users on submit

	//role_id = 3 for Nominators
	//Verify valid role - kick off if not nominator
	check_role(3); 

	//Continue if form was submitted (POST is not empty)
	if(!empty($_POST))
	{
		//SQL Query - Create nominee user
		$sql="
			INSERT into users (name, pid, email)
			VALUES(
				'" . $_POST["nomineeName"] . "',
				'" . $_POST["nomineePID"] . "',
				'" . $_POST["nomineeEmail"] . "')";	
	
		//Execute sql query and continue if successful
		if($conn->query($sql)===TRUE)
		{
			// create user_role record
			$user_id = $conn->insert_id;

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
					is_new_phd)
				VALUES 
				(
					(select max(session_id) from sessions),
					" . $user_id . ",
					'" . $_SESSION["user_id"]."',
					'" . $_POST["nomineeRanking"] . "',
					'" . $_POST["currentPhd"] . "',
					'" . $_POST["newPhd"] . "'
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
		}
	
		//Close connection to database
		$conn->close();
	
		//Prompt user - successful submission
		echo "Thank you for your submission";

		//Exit script - dont render the rest of the page
		die();
	}
	else
	{
		//Form was not submitted (yet)
		// Display nominator of who nominated this person based on login
		$nominator_name = $_SESSION["name"];
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
		<h2>Nominate and existing or incoming Ph.D student for a GTA</h1>

		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<table>
				<tr>
					<td>Name of Nominator</td>
					<td></td>
					<td><?php echo $nominator_name; ?></td>
				</tr>

				<tr>
					<td>Email of Nominator</td>
					<td></td>
					<td><?php echo $nominator_email; ?></td>
				</tr>

				<tr>
					<td>Name of Nominee</td>
					<td></td>
					<td><input type = "text" name = "nomineeName" id="nomineeName" required ></td>
				</tr>

				<tr>
					<td>Nominee Ranking</td>
					<td></td>
					<td><input type = "text" name = "nomineeRanking" id="nomineeRanking" required></td>
				</tr>
				
				<tr>
					<td>PID of Nominee</td>
					<td></td>
					<td><input type = "text" name = "nomineePID" id="nomineePID" required></td>
				</tr>
				
				<tr>
					<td>Email of Nominee</td>
					<td></td>
					<td><input type = "email" name = "nomineeEmail" id="nomineeEmail" required></td>
				</tr>
				
				<tr>
					<td>Is the nominee currently a Ph.D. </br> student in the Department of </br> Computer Science?</td>
					<td>&emsp;&emsp;</td>
					<td>
						<input type="radio" name="currentPhd" class="radios" value="yes" required> Yes<br>
						<input type="radio" name="currentPhd" class="radios" value="no" required> No
					</td>
				</tr>
				
				<tr>
					<td>Is the nominee a newly admitted </br> Ph.D. student?</td>
					<td></td>
					<td>
						<input type="radio" name="newPhd" class="radios" value="yes" required> Yes<br>
						<input type="radio" name="newPhd" class="radios" value="no" required> No
					</td>
				</tr>
				
				<tr><td>&emsp;</td></tr>
				
				<tr>
					<td colspan="3" class="submitrow">
						<input type="submit" class="buttons" value="Submit">
					</td>
				</tr>
			</table>

		<!--
				Name of Nominator
				<input type = "text" name = "nominatorName"></br>

				Email of Nominator
				<input type = "text" name = "nominatorEmail"></br>

				Name of Nominee
				<input type = "text" name = "nomineeName"></br>

				Nominee Ranking
				<input type = "text" name = "nomineeRanking"></br>

				PID of Nominee
				<input type = "text" name = "nomineePID"></br>

				Email of Nominee
				<input type = "text" name = "nomineeEmail"></br>

				Is the nominee currently a Ph.D. student in the Department of Computer Science? </br>
				<input type="radio" name="currentPhd" value="yes"> Yes<br>
				<input type="radio" name="currentPhd" value="no"> No<br>

				Is the nominee a newly admitted Ph.D. student?</br>
				<input type="radio" name="newPhd" value="yes"> Yes<br>
				<input type="radio" name="newPhd" value="no"> No<br>
		-->
		</form>
	</body>
</html>
