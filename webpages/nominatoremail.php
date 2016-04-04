$to = "$nominatorEmail";
	$subject = "Please verify this nominee's information";

	$message ="
	<html>
		<head>
			<title>Please verify this nominee's information</title>
		</head>
		<body>
			Dear *insert nominator name here*,
			</br></br>
			Nominee *insert nominee name here* has filled out their form to become a GTA.
			</br></br>
			Before they can fully become a GTA, you are required to verify their information.
			</br></br>
			Do so by clicking here: *insert url to verification form*
		</body>
		<footer>
			<hr>
			GTAMS Administration
		</footer>
	</html>";

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: <automatedcop4710@gmail.com>' . "\r\n";

	mail($to,$subject,$message,$headers);