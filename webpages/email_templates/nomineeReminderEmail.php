<?php
	include_once(dirname(__FILE__).'/../config/config.php');

	function getNomineeReminderEmail($fname, $lname, $nomName, $uid, $nator)
	{
		$msg = '<html>
					<head>
						<title>Urgent! 2 Days till the deadline!</title>
					</head

					<body>
						<p>Dear ' . $fname . ' ' . $lname . ',</p>

						<p>' . $nomName . ' has nominated to you be a GTA and this is your final reminder to complete the form in order to be considered as a GTA.</p>

						<p>If you wish to accept this nomination, follow the link provided and fill out the form.</p>

						<p>After you have you successfully entered your information and submitted, your nominator will
						 then look, and verify, your information.</p> 

						<p><a href="http://' . getHostURL()  . 'nominee.php?u=' . $uid . '&nator=' . $nator .'">Click here</a> to fill out your nominee form.</p>
					</body>

					<footer>
						<hr>
						GTAMS Administration
					</footer>
				</html>';

		return $msg;
	}
?>
