<?php
	//Import database connection and user session
	include_once("db.php");

	//Verify session and cookie match
	if(isset($_COOKIE["user_id"]) && 
	   isset($_SESSION["user_id"]) && 
	   $_COOKIE["user_id"] == $_SESSION["user_id"])
	{
		//User already logged in - Trash the session?
		//setcookie("user_id", $row["user_id"], -1, "/");
		unset($_SESSION["user_id"]);
		unset($_SESSION["role_id"]);
		unset($_SESSION["name"]);
		unset($_SESSION["email"]);
	}
	
	//Execute if POST is NOT empty (Form Submitted)
	if(!empty($_POST))
	{
		//SQL Query to check if username/password pair is valid and exists
		$sql="
		SELECT
			users.user_id as user_id,
			users.name as name,
			users.email as email,
			user_roles.role_id as role_id
		FROM
			users
		INNER JOIN user_roles 
		ON users.user_id = user_roles.user_id
		WHERE
			users.username='" . $_POST["loginEmail"] ."' 
			AND users.password ='" . md5($_POST["loginPassword"]) . "'";
		
		//Execute query and store result.
		//Continue if result exists
		if ($result = mysqli_query($conn,$sql))
		{
			//Store first row of query results
			$row = mysqli_fetch_array($result);
		
			//Continue if user_id exists in query results
			if($row["user_id"] != null)
			{
				//Store session values
				$_SESSION["user_id"] = $row["user_id"];
				$_SESSION["role_id"] = $row["role_id"];
				$_SESSION["name"] = $row["name"];
				$_SESSION["email"] = $row["email"];

				//Display success message
				echo "Sucessfully logged in.";
			}
			else
			{
				//Display Error - Unsuccessful login
				echo "Bad username or password.";
			}

			//Free memory from query result
			mysqli_free_result($result);
		}

		//Close connection to database
		mysqli_close($conn);
	
		//If form submitted, don't render login page
		die(); 
	}
?>

<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="styles/style.css">
	</head>

	<body>
		<div class="loginscreen">
			<h1>Login to your account</h1>

			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<table>
					<tr>
						<td>Username:</td>
						<td>&emsp;</td>
						<td><input type = "text" id = "loginEmail" name = "loginEmail" /></td>
					</tr>

					<tr>
						<td>Password:</td>
						<td>&emsp;</td>
						<td><input type = "password" id = "loginPassword" name = "loginPassword"></td>
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
