<?php
	function getNominatorEmailBody($nominator, $nominee, $uid)
	{
		$msg = '<html>
					<head>
						<title> Please verify the information of a nominee</title>
					</head>

					<body>
						<p>Dear ' . $nominator . ',</p>

						<p>Nominee ' . $nominee . ' has filled out their form to become a GTA.</p>

						<p>Before that can fully become a GTA, you must verify their information.</p>

						<p><a href="verify.php?u=' . $uid . '">Click here</a> to verify their information.</p>
					</body>

					<footer>
						<hr>
						GTAMS Administration
					</footer>
				</html>';

		return $msg;
	}
?>