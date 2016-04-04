for($x = 1; $x <=$maxkeyint; $x++)
{
	$to = "$GCEmail.$x";
	$subject = "You have been selected for the Graduate Committee";

	$message ="
	<html>
		<head>
			<title>You have been selected for the Graduate Committee</title>
		</head>
		<body>
			The System Administrator for this session has chosen you as *insert role*
			</br></br>
			Your login is: *insert login*
			</br></br>
			Your password is: *insert password*
			</br></br>
			In order to access the scoring table please click on the following url: *insert url to gc members page*
			</br></br>
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
}
