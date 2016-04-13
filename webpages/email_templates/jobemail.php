<?php
	include_once(dirname(__FILE__).'/../config/config.php');

	function getJobEmailBody($name, $login, $pass)
	{
		$msg = '<html>
					<head>
						<title>You have been chosen as a nominator</title>
					</head>

					<body>
						<p>Dear ' . $name . ',</p>

						<p>You have been selected by the system administrator to be a nomiator for this session</p>

						<p>Login: ' . $login . '</p>
						<p>Password: ' . $pass . '</p>
						<p>As a nominator you must choose students to become GTAs, and rank them against each other.</p>

						<p>To start doing so <a href="http://' . getHostURL()  . 'nominator.php">click here</a>.</p>
					</body>

					<footer>
						<hr>
						GTAMS Administration
					</footer>
				</html>';
		return $msg;
	}
?>
