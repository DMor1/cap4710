<html>
	<head>
		<title>System Administrator UI</title>
		<link rel="stylesheet" href="style.css">
	</head>

	<body>
		<h2>Setup a new nomination session for GTAMS</h2>

		<form>
			<table id='table'>

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
					<td><input type = "text" id = "chairName" name = "chairName"></td>
					<td><input type = "email" id = "chairEmail" name = "chairEmail"></td>
					<td><input type = "text" id = "chairUsername" name = "chairUsername"></td>
					<td><input type = "password" id = "chairPassword" name = "chairPassword"></td>
					<td></td>
				</tr>

				<tr class="list">
					<td>Member Name</td>
					<td>Member Email</td>
					<td>Member Username</td>
					<td>Member Password</td>
					<td></td>
				</tr>

				<tr class="list">
					<td><input type = "text" id = "GCName1" name = "GCName1"/></td>
					<td><input type = "email" id = "GCEmail1" name = "GCEmail1"/></td>
					<td><input type = "text" id = "GCUserName1" name = "GCUserName1"/></td>
					<td><input type = "password" id = "GCUserPassword1" name = "GCUserPassword1"/></td>
					<td><input type="button" class="buttons" value="Add" onclick="addGC()" /></td>
				</tr>

				<tr><td>&emsp;</td></tr>

				<tr>
					<td COLSPAN="2">What is the deadline for a faculty member to initiate a nomination?</td>
				</tr>

				<tr>
					<td COLSPAN="2" class="submitrow"><input type = "date" id = "facultyNominationDeadline" name = "facultyNominationDeadline"></td>
				</tr>

				<tr>
					<td COLSPAN="3">What is the deadline for a nominee to respond to a nomination?</td>
				</tr>

				<tr>
					<td COLSPAN="2" class="submitrow"><input type = "date" id = "nomineeResponseDeadline" name = "nomineeResponseDeadline"></td>
				</tr>

				<tr>
					<td COLSPAN="3">What is the deadline for the nominator to verify a nominee's information and complete the nomination?</td>
				</tr>

				<tr>
					<td COLSPAN="2" class="submitrow"><input type = "date" id = "verificationDeadline" name = "verificationDeadline"></td>
				</tr>

				<tr><td>&emsp;</td></tr>

				<tr>
					<td colspan="5" class="submitrow">
						<input type="submit" class="buttons" value="Submit">
					</td>
				</tr>
			</table>

			<script>
			
			var iii=5;
			var z=1;
			function addGC(){
					var table=document.getElementById("table");
					var row=table.insertRow(iii++);
					row.className='list';
					var cell1=row.insertCell(0);
					var cell2=row.insertCell(1);
					var cell3=row.insertCell(2);
					var cell4=row.insertCell(3);
					var cell5=row.insertCell(4);
					
					z++;
					cell1.innerHTML='<input type="text" id="GCName'+z+'" name="GCName'+z+'" />';
					cell2.innerHTML='<input type="text" id="GCEmail'+z+'" name="GCEmail'+z+'"/>';
					cell3.innerHTML='<input type="text" id="GCUserName'+z+'" name="GCUserName'+z+'"/>';
					cell4.innerHTML='<input type="text" id="GCUserPassword'+z+'" name=""GCUserPassword'+z+'" />';
					cell5.innerHTML='<input type="button" class="buttons" value="remove" onclick="removeGC(iii)"/>';
     
					table.appendChild('row');
			}
			
			function removeGC(iii){
				document.getElementById('table').deleteRow(--iii);
				z--;
			}
			</script>
				<!-- Name of GC Chair: 
				<input type = "text" name = "gcChairName"></br>

				GC Member Information</br>

				Member #1: 
				Name <input type = "text" id = "GCName1" name = "GCName1">
				Email <input type = "text" id = "GCEmail1" name = "GCEmail1">
				UserName <input type = "text" id = "GCUserName1" name = "GCUserName1">
				UserPassword <input type = "password" id = "GCUserPassword1" name = "GCUserPassword1"><br>
				
				Deadline for a faculty member to initiate a nomination
				<input type = "text" id = "facultyNominationDeadline" name = "facultyNominationDeadline"><br>			

				Deadline for a nominee to respond to a nomination
				<input type = "text" id = "nomineeResponseDeadline" name = "nomineeResponseDeadline"><br>

				Deadline for the nominator to verify nominee’s information and complete the nomination
				<input type = "text" id = "verificationDeadline" name = "verificationDeadline"><br> -->

		</form>
	</body>
</html>