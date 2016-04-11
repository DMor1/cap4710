<?php
	include_once("db.php");
	session_destroy();
	echo "You have been successfully logged out.<br> <a href='login.php'>Return to login page.</a>";

?>