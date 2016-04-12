<html>
	<head>
		<title>Please verify this nominee's information</title>
	</head>
	<body>
		Dear <?php echo nominator ?>,
		</br></br>
		Nominee <?php echo nominee ?> has filled out their form to become a GTA.
		</br></br>
		Before they can fully become a GTA, you are required to verify their information.
		</br></br>
		Do so by clicking here: <?php echo '<a href="verify.php?u=' .$uid. '">Verify</a>';?>
	</body>
	<footer>
		<hr>
		GTAMS Administration
	</footer>
</html>