<?php
include_once("login_check.php"); // this must come first
include_once("db.php");

// TODO: Email users on submit

//debug_print($_POST);

// check the role and kick them off if they aren't a nominator
check_role(3); // role_id 3 is for nominators

if(!empty($_POST))
{

	// create nominee user
	$sql="INSERT into users (name, pid, email)
	VALUES(
	'" . $_POST["nomineeName"] . "',
	'" . $_POST["nomineePID"] . "',
	'" . $_POST["nomineeEmail"] . "')";
	
	
	if($conn->query($sql)===TRUE)
	{
		// create user_role record
		$user_id = $conn->insert_id;
		$sql="INSERT INTO user_roles (user_id,role_id)
		VALUES (" . $user_id . ",4)";//4=nominee
		if ($conn->query($sql) === TRUE){/*echo "New record created successfully1<br>";*/}
		else {echo "Error: " . $sql . "<br>" . $conn->error;}	
		
		// create nominee record
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
			
			
		if ($conn->query($sql) === TRUE){/*echo "New record created successfully2<br>";*/}
		else {echo "Error: " . $sql . "<br>" . $conn->error;}	
		
	}
	
	
	$conn->close();
	
	echo "Thank you for your submission";
	die();
}
else
{
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
					<td><input type = "text" name = "nomineeName" id="nomineeName"></td>
				</tr>

				<tr>
					<td>Nominee Ranking</td>
					<td></td>
					<td><input type = "text" name = "nomineeRanking" id="nomineeRanking"></td>
				</tr>
				
				<tr>
					<td>PID of Nominee</td>
					<td></td>
					<td><input type = "text" name = "nomineePID" id="nomineePID"></td>
				</tr>
				
				<tr>
					<td>Email of Nominee</td>
					<td></td>
					<td><input type = "email" name = "nomineeEmail" id="nomineeEmail"></td>
				</tr>
				
				<tr>
					<td>Is the nominee currently a Ph.D. </br> student in the Department of </br> Computer Science?</td>
					<td>&emsp;&emsp;</td>
					<td>
						<input type="radio" name="currentPhd" class="radios" value="yes"> Yes<br>
						<input type="radio" name="currentPhd" class="radios" value="no"> No
					</td>
				</tr>
				
				<tr>
					<td>Is the nominee a newly admitted </br> Ph.D. student?</td>
					<td></td>
					<td>
						<input type="radio" name="newPhd" class="radios" value="yes"> Yes<br>
						<input type="radio" name="newPhd" class="radios" value="no"> No
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
