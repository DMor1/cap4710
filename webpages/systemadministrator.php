<?php
	//Import External Files
	include_once("login_check.php"); //This must come first, import checkrole function
	include_once("db.php"); //Connect to database and initialize session
	include_once("email_templates/gcemail.php");
	include_once("email_templates/jobemail.php");

	//role_id = 1 for system administrator
	//verify role and kick off if not system administrator
	check_role(1); 

	//Continue if form was submitted
	if(!empty($_POST))
	{

		$to = "";
		$subject = "You have been chosen as the chair of the Graduate Committee";
		$user = $_POST["chairUsername"];
		$pass = $_POST["chairPassword"];
		$name = $_POST["chairName"];
		$role = "GC Chair";
		$message = getGCEmailBody($name, $role, $user , $pass); 

		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: <automatedcop4710@gmail.com>' . "\r\n";

		mail($to, $subject, $message, $headers);

		//SQL Query - Insert GC User
		$sql="
			INSERT into users (name, email, username, password)
			VALUES('" . $_POST["chairName"] . "','" .  $_POST["chairEmail"] . "','" . $_POST["chairUsername"] . "','" . md5($_POST["chairPassword"]) . "')";
		
		//Execute query
		if($conn->query($sql)===TRUE)
		{	
			//If successfully added GC User, also update user_roles table
			$sql="
				INSERT INTO user_roles (user_id,role_id)
				VALUES (" . $conn->insert_id . ",2)";
			
			//Execute query
			if ($conn->query($sql) === TRUE)
			{
				//Successfully updated user_roles
				/*echo "New record created successfully1<br>";*/
			}
			else 
			{	
				//Query failed
				echo "Error: " . $sql . "<br>" . $conn->error;
			}	
		}
	
		//Get the total number of dynamic rows
		$maxkeyint = intval("0");
		foreach($_POST as $key=>$value)
		{
	  		if(preg_match('/GCName/',$key))
	  		{
		  		$temp_key = intval(filter_var($key, FILTER_SANITIZE_NUMBER_INT));
		  		
		  		
				if($temp_key > $maxkeyint)
					$maxkeyint = $temp_key;
	  		}
		}	

		for($x = 1; $x<=$maxkeyint; $x++)
		{
			$to = "";
			$subject = "You have been chosen as a member of the Graduate Committee";
			$user = $_POST["GCUserName".$x];
			$pass = $_POST["GCUserPassword".$x];
			$name = $_POST["GCName".$x];
			$role = "GC Member";
			$message = getGCEmailBody($name, $role, $user , $pass); 
					
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: <automatedcop4710@gmail.com>' . "\r\n";

			mail($to, $subject, $message, $headers);
		}
	
		//Since names of the columns and the max number is known, iterate through the users one at a time
		for($i = 1; $i<=$maxkeyint; $i++)
		{
			//insert user $i
			//insert user_role for user
			//GCName1=GCEmail1=GCUserName1=GCUserPassword1=
			$sql="
				INSERT into users (name, email, username, password)
				VALUES('" . $_POST["GCName".$i] . "','" .  $_POST["GCEmail".$i] . "','" . $_POST["GCUserName".$i] . "','" . md5($_POST["GCUserPassword".$i]) . "')";
			
			//Execute query
			if($conn->query($sql)===TRUE)
			{
				//SQL Query - add user roles
				$sql="
					INSERT INTO user_roles (user_id,role_id)
					VALUES (" . $conn->insert_id . ",3)";
				
				//Execute query
				if ($conn->query($sql) === TRUE)
				{
					//Query successful
					/*echo "New record created successfully2<br>";*/
				}
				else 
				{
					//Query failed
					echo "Error: " . $sql . "<br>" . $conn->error;
				}	
			}
		
		}
	
		//SQL Query - Create/Insert new session
		$sql="
			INSERT INTO sessions (start_date, end_date, initiation_date, verify_deadline_date)
			VALUES 
			(CURDATE(), 
			STR_TO_DATE('" . $_POST["nomineeResponseDeadline"] . "','%Y-%m-%d'),
			STR_TO_DATE('" . $_POST["facultyNominationDeadline"] . "','%Y-%m-%d'),
			STR_TO_DATE('" . $_POST["verificationDeadline"] . "','%Y-%m-%d'))";

		//Execute query
		if ($conn->query($sql) === TRUE)
		{
			/*echo "New record created successfully3<br>";*/
		}
		else 
		{
			echo "Error: " . $sql . "<br>" . $conn->error;
		}	
		
		//Close database connection
		$conn->close();
	
		//Prompt user
		echo "Thank you for your submission";
		
		//Kill script - dont render the rest
		die();
	}	
?>

<html>
	<head>
		<title>System Administrator UI</title>
		<link rel="stylesheet" href="styles/style.css">
	</head>

	<body>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<table id='table'>
				<tr>
					<td colspan="3"><h2>Setup a new nomination session for GTAMS</h2></td>
					<td>
						<a href="changepassword.php">
							<input type="button" class="logout" value="Change Password">
						</a>
					</td>
					<td>
						<a href="logout.php">
							<input type="button" class="logout" value="Log Out">
						</a>
					</td>
				</tr>

				<tr>
					<td>GC Members:</td>
				</tr>
				
				<tr class="list">
					<td>GC Chair Name</td>
					<td>GC Chair Email</td>
					<td>GC Chair Username</td>
					<td>GC Chair Password</td>
					<td></td>
				</tr>

				<tr class="list">
					<td><input type = "text" id = "chairName" name = "chairName" required   pattern="^[-a-zA-Z ]*" ></td>
					<td><input type = "email" id = "chairEmail" name = "chairEmail" required ></td>
					<td><input type = "text" id = "chairUsername" name = "chairUsername" required   pattern="^[-a-zA-Z ]*" ></td>
					<td><input type = "password" id = "chairPassword" name = "chairPassword" required></td>
					<td></td>
				</tr>

				<tr class="list">
					<td>GC Member Name</td>
					<td>GC Member Email</td>
					<td>GC Member Username</td>
					<td>GC Member Password</td>
					<td></td>
				</tr>

				<tr class="list">
					<td><input type = "text" id = "GCName1" name = "GCName1" required   pattern="^[-a-zA-Z ]*"  /></td>
					<td><input type = "email" id = "GCEmail1" name = "GCEmail1" required /></td>
					<td><input type = "text" id = "GCUserName1" name = "GCUserName1" required   pattern="^[-a-zA-Z ]*" /></td>
					<td><input type = "password" id = "GCUserPassword1" name = "GCUserPassword1" required /></td>
					<td><input type="button" class="buttons" value="Add" onclick="addGC()" /></td>
				</tr>

				<tr><td>&emsp;</td></tr>

				<tr>
					<td>Nominators:</td>
				</tr>

				<tr class="list">
					<td>Nominator's Name</td>
					<td>Nominator's Email</td>
					<td>Nominator's Username</td>
					<td>Nominator's Password</td>
					<td></td>
				</tr>

				<tr class="list">
					<td><input type = "text" id = "nomName1" name = "nomName1" required pattern="^[-a-zA-Z ]*"  /></td>
					<td><input type = "email" id = "nomEmail1" name = "nomEmail1" required /></td>
					<td><input type = "text" id = "nomUserName1" name = "nomUserName1" required pattern="^[-a-zA-Z ]*" /></td>
					<td><input type = "password" id = "nomUserPassword1" name = "nomUserPassword1" required /></td>
					<td><input type="button" class="buttons" value="Add" onclick="addNom()" /></td>
				</tr>

				<tr><td>&emsp;</td></tr>

				<tr>
					<td COLSPAN="2">What is the deadline for a faculty member to initiate a nomination? (mm/dd/yyyy)</td>
				</tr>

				<tr>
					<td COLSPAN="2" class="submitrow"><input type = "date" id = "facultyNominationDeadline" name = "facultyNominationDeadline" required /></td>
				</tr>

				<tr>
					<td COLSPAN="3">What is the deadline for a nominee to respond to a nomination? (mm/dd/yyyy)</td>
				</tr>

				<tr>
					<td COLSPAN="2" class="submitrow"><input type = "date" id = "nomineeResponseDeadline" name = "nomineeResponseDeadline" required /></td>
				</tr>

				<tr>
					<td COLSPAN="3">What is the deadline for the nominator to verify a nominee's information and complete the nomination? (mm/dd/yyyy)</td>
				</tr>

				<tr>
					<td COLSPAN="2" class="submitrow"><input type = "date" id = "verificationDeadline" name = "verificationDeadline" required /></td>
				</tr>

				<tr><td>&emsp;</td></tr>

				<tr>
					<td colspan="5" class="submitrow">
						<input type="submit" class="buttons" value="Submit">
					</td>
				</tr>
			</table>

			<script>
			
			var iii=6;
			var z=1;
			var nomRows=10;
			var nomNum=1;

			function addGC()
			{
				var table=document.getElementById("table");
				var row=table.insertRow(iii++);
				nomRows++;
				row.className='list';
				var cell1=row.insertCell(0);
				var cell2=row.insertCell(1);
				var cell3=row.insertCell(2);
				var cell4=row.insertCell(3);
				var cell5=row.insertCell(4);
				
				z++;
				cell1.innerHTML='<input type="text" id="GCName'+z+'" name="GCName'+z+'" required   pattern="^[-a-zA-Z ]*"  />';
				cell2.innerHTML='<input type="email" id="GCEmail'+z+'" name="GCEmail'+z+'" required />';
				cell3.innerHTML='<input type="text" id="GCUserName'+z+'" name="GCUserName'+z+'" required   pattern="^[-a-zA-Z ]*" />'; 
				cell4.innerHTML='<input type="password" id="GCUserPassword'+z+'" name=""GCUserPassword'+z+'" required />';
				cell5.innerHTML='<input type="button" class="buttons" value="Remove" onclick="removeGC(iii)" required />';
 
				table.appendChild('row');
			}
			
			function removeGC(input)
			{
				document.getElementById('table').deleteRow(--input);
				nomRows--;
				z--;
				iii--;
			}

			function addNom()
			{
				var table=document.getElementById("table");
				var row=table.insertRow(nomRows++);
				row.className='list';
				var cella=row.insertCell(0);
				var cellb=row.insertCell(1);
				var cellc=row.insertCell(2);
				var celld=row.insertCell(3);
				var celle=row.insertCell(4);
				
				nomNum++;
				cella.innerHTML='<input type="text" id="nomName'+nomNum+'" name="nomName'+nomNum+'" required   pattern="^[-a-zA-X ]*"  />';
				cellb.innerHTML='<input type="email" id="nomEmail'+nomNum+'" name="nomEmail'+nomNum+'" required />';
				cellc.innerHTML='<input type="text" id="nomUserName'+nomNum+'" name="nomUserName'+nomNum+'" required   pattern="^[-a-zA-Z ]*" />'; 
				celld.innerHTML='<input type="password" id="nomUserPassword'+nomNum+'" name=""nomUserPassword'+nomNum+'" required />';
				celle.innerHTML='<input type="button" class="buttons" value="Remove" onclick="removeNom(nomRows)" required />';
 
				table.appendChild('row');
			}

			function removeNom(input)
			{
				document.getElementById('table').deleteRow(--input);
				nomRows--;
				nomNum--;
			}
			</script>
		</form>
	</body>
</html>
