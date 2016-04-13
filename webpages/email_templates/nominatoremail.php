<?php
	include_once(dirname(__FILE__).'/../config/config.php');

	function getNominatorEmailBody($nominator, $nominee, $uid)
	{
		$msg = '<html>
					<head>
						<title>Please verify the information of a nominee</title>
					</head>

					<body>
						<p>Dear ' . $nominator . ',</p>

						<p>Nominee ' . $nominee . ' has filled out their form to become a GTA.</p>

						<p>In order to finalize their nomination, you must verify their information.</p>

						<p><a href="http://' . getHostURL()  . 'verify.php?u=' . $uid . '">Click here</a> to verify their information.</p>
					</body>

					<footer>
						<hr>
						GTAMS Administration
					</footer>
				</html>';

		return $msg;
	}
?>
