<?php 

function check_role($role_id)
{
	$isvalid = true;
	
	//if(!(isset($_COOKIE["user_id"]) && isset($_SESSION["user_id"]) && $_COOKIE["user_id"] == $_SESSION["user_id"]))
	if(!isset($_SESSION["user_id"]))
	{
		$isvalid = false;
	}
	
	if(isset($_SESSION["role_id"]) && $_SESSION["role_id"] != $role_id)
	{
		$isvalid = false;
	}
	
	if(!$isvalid)
	{
		// the user IS NOT already logged in
		// Trash the session and force to login page
		setcookie("user_id", $row["user_id"], -1, "/");
		unset($_SESSION["user_id"]);
		header('Location: login.php'); // kick the user to the login page
	}	
}
?>