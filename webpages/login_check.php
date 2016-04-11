<?php 
	//Function to check if 
	function check_role($role_id)
	{	
		//Flag Variable
		$isvalid = true;
	
		//If userid is not set, role is not valid		
		if(!isset($_SESSION["user_id"]))
			$isvalid = false;
	
		//If roleid is set and roleid stored in session does not match input, not valid
		if(isset($_SESSION["role_id"]) && $_SESSION["role_id"] != $role_id)
			$isvalid = false;
	
		//Set values if role is valid
		if(!$isvalid)
		{
			// the user IS NOT already logged in
			// Trash the session and force to login page
			setcookie("user_id", $row["user_id"], -1, "/");
			unset($_SESSION["user_id"]);
			header('Location: login.php'); // kick the user to the login page
		}	
	}
	
	function check_not_role($role_id)
	{	
		//Flag Variable
		$isvalid = true;
	
		//If userid is not set, role is not valid		
		if(!isset($_SESSION["user_id"]))
			$isvalid = false;
	
		//If roleid is set and roleid stored in session does not match input, not valid
		if(isset($_SESSION["role_id"]) && $_SESSION["role_id"] == $role_id)
			$isvalid = false;
	
		//Set values if role is valid
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
