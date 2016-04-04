<?php
include_once("db.php");

if(isset($_COOKIE["user_id"]) && isset($_SESSION["user_id"]) && $_COOKIE["user_id"] == $_SESSION["user_id"])
{
	// the user is already logged in
	// Trash the session?
	//setcookie("user_id", $row["user_id"], -1, "/");
	unset($_SESSION["user_id"]);
	unset($_SESSION["role_id"]);
	unset($_SESSION["name"]);
	unset($_SESSION["email"]);
}

if(!empty($_POST))
{
	// check if pw is valid
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

	if ($result=mysqli_query($conn,$sql))
	{
		// Fetch one and one row
		/*
		while ($row=mysqli_fetch_row($result))
		{
			printf ("%s (%s)\n",$row[0],$row[1]);
		}
		*/
		// only need one row
		
		$row=mysqli_fetch_array($result);
		
		if($row["user_id"]!=null)
		{
			// store cookie
			//setcookie("user_id", $row["user_id"], time() + (86400 * 30), "/");
			$_SESSION["user_id"] = $row["user_id"];
			$_SESSION["role_id"] = $row["role_id"];
			$_SESSION["name"] = $row["name"];
			$_SESSION["email"] = $row["email"];
			echo "Sucessfully logged in.";
		}
		else
		{
			echo "Bad username or password.";
		}
		// Free result set
		mysqli_free_result($result);
		
	}

	mysqli_close($con);
	
	
	die(); // don't render code below this point
}
?>
<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="style.css">
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
					
					<!-- Email
					<input type = "text" id = "loginEmail" name = "loginEmail"></br>

					Password
					<input type = "password" id = "loginPassword" name = "loginPassword"></br>

					<input type="submit" value="Submit"> -->
			</form>
		</div>
	</body>
</html>