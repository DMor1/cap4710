<?php
	include_once("login_check.php"); //This must come first, import checkrole function
	include_once("db.php"); //Connect to database and initialize session
	
	//if role is nominee, will kick out
	//check_not_role(4);
	
	$newpassword1=md5($_POST["newloginPassword"]);
	$newpassword2=md5($_POST["newloginPasswordR"]);
	
	$passwordErr="";
	if(!empty($_POST))
	{
		//check if the typed in login password is right
		
		
		//check if the 2 new passwords match
		if($newpassword1 == $newpassword2){
		
			
			//update the the newpassword
			$sql="
			UPDATE users
			SET password=$newpassword1
			WHERE user_id='".$_SESSION["user_id"]."'
			";
			
			if($conn->query($sql)===TRUE){
				$conn->close();
				session_destroy();
				die("Password has been changed <br><a href='login.php'>Return</a> the the login page");
			}
			
			else{
				echo "Error: " . $sql . "<br>" . $conn->error;

			}
		}
		
		else{
			die("New passwords don't match");
		}
		
		
	}	
	
		
		//Prompt user
		//echo "Thank you for your submission";
		
	
	//check if the role isn't nominee
	
?>


<html>
	<head>
		<title>Change Password</title>
		<link rel="stylesheet" href="styles/style.css">
	</head>

	<body>
		<div class="loginscreen">
			<h1>Change Password</h1>

			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<table>
					<!--<tr>
						<td>Current password:</td>
						<td>&emsp;</td>
						<td><input type = "password" id = "loginPassword" name = "loginPassword" /><span class="error"><</span></td>
					</tr-->

					<tr>
						<td>New Password:</td>
						<td>&emsp;</td>
						<td><input type = "password" id = "newloginPassword" name = "newloginPassword"></td>
					</tr>
					
					<tr>
						<td>Retype New Password:</td>
						<td>&emsp;</td>
						<td><input type = "password" id = "newloginPasswordR" name = "newloginPasswordR"></td>
					</tr>

					<tr><td>&emsp;</td></tr>

					<tr>
						<td colspan="3" class="submitrow">
							<input type="submit" class="buttons" value="Submit">
						</td>
					</tr>
				</table>		
			</form>
		</div>
	</body>
</html>
