$to = "$nomineeEmail";
	$subject = "You have been nominated to be a GTA";

	$message ="
	<html>
		<head>
			<title>You have been nominated to be a GTA</title>
		</head>
		<body>
			Dear *insert nominee name here*,
			</br></br>
			Nominator *insert nominator name here* has nominated you to be a GTA.
			</br></br>
			If you wish to accept this nomination, follow the link provided and fill out the form.
			</br></br>
			Your nominator will then verify your information.
			</br></br>
			Click here: *insert url to nominee form*
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