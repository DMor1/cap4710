<html>
	<head>
		<title>You have been nominated to be a GTA</title>
	</head>
	<body>
		Dear <?php echo $name ?>,
		</br></br>
		Nominator <?php echo $nomName ?> has nominated you to be a GTA.
		</br></br>
		If you wish to accept this nomination, follow the link provided and fill out the form.
		</br></br>
		Your nominator will then verify your information.
		</br></br>
		Click here: <?php echo '<a href="nominee.php?u=' .$uid. '">Nominee Form</a>';?>
	</body>
	<footer>
		<hr>
		GTAMS Administration
	</footer>
</html>