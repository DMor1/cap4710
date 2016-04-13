<?php
	function getGCEmailBody($name, $role, $user, $pass)
	{
		$msg = '<html>
					<head>
						<title>You have been selected for the Graduate Committee</title>
					</head>			
					
					<body>
						<p>Hello ' . $name . ',</p>
		
						<p>The System Administrator for this session has chosen you as ' . $role . '</p>

						<p>
							<p>Login: ' .  $user . '</p>
							<p>Password: ' . $pass . '</p>
						</p>

						<p>In order to access the scoring table please click on the following url: <a href="http://raspbiripi.ddns.net/webpages/gcmembers.php">Click Here</a></p>
					</body>
					
					<footer>
						<hr>
							GTAMS Administration
					</footer>
				</html>';

		return $msg;
	}
?>


