<?php
	function getGCEmailBody($name, $role, $user, $pass) {
		$msg = '<html>
	<head>
		<title>You have been selected for the Graduate Committee</title>
	</head>
	<body>
		Hello ' . $name . ',
		</br></br>
		The System Administrator for this session has chosen you as ' . $role . '
		</br></br>
		Your login is: ' .  $user . '
		</br></br>
		Your password is: ' . $pass . '
		</br></br>
		In order to access the scoring table please click on the following url: <a href="gcmembers.php">Click Here</a>
		</br></br>
	</body>
	<footer>
		<hr>
		GTAMS Administration
	</footer>
</html>';


		return $msg;
	}
?>


