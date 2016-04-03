<html>
	<head>
		<title>Nominee UI</title>
		<link rel="stylesheet" href="style.css">
	</head>

	<body>
		<h2>Fill out your GTA application</h2>
		<form>
			<table id='table'>
				<tr>
					<td>Name of the nominator</td>
					<td>&emsp;&emsp;</td>
					<td><input type="text" name="nominatorName" id="nominatorName" /></td>
				</tr>

				<tr>
					<td>Name of current Ph.D. advisor</td>
					<td></td>
					<td><input type="text" name="advisorName" id="advisorName" /></td>
				</tr>

				<tr>
					<td COLSPAN="3">List your past advisors and the years you had them:</td>
				</tr>

				<tr class="list">
					<td>Advisor Name</td>
					<td></td>
					<td>Start Year</td>
					<td>End Year</td>
					<td></td>
				</tr>

				<tr class="list" id='advisor'>
					<td><input type="text" name="past1" id="past1" /></td>
					<td></td>
					<td><input type="text" name="startAdvisor1" id="startAdvisor1" /></td>
					<td><input type="text" name="endAdvisor1" id="endAdvisor1" /></td>
					<td><input type="button" class='buttons' value="add" onclick="addAdvisor()" id="button_advisor"/></td>
				</tr>

				<tr><td>&emsp;</td></tr>

				<tr>
					<td>Your name</td>
					<td></td>
					<td><input type="text" name="nomineeName" id="nomineeName" /></td>
				</tr>

				<tr>
					<td>Your PID</td>
					<td></td>
					<td><input type="text" name="pid" id="pid" /></td>
				</tr>

				<tr>
					<td>Your email</td>
					<td></td>
					<td><input type="email" name="nomineeEmail" id="nomineeEmail" /></td>
				</tr>

				<tr>
					<td>Your phone number</td>
					<td></td>
					<td><input type="tel" name="nomineePhone" id="nomineePhone" /></td>
				</tr>

				<tr>
					<td>Are you a Ph.D. student in Computer Science?</td>
					<td></td>
					<td>
						<input type="radio" name="isPhd" class="radios" value="yes"> Yes
						</br>
						<input type="radio" name="isPhd" class="radios" value="no"> No
					</td>
				</tr>

				<tr>
					<td>How many semesters have you been a graduate student?</td>
					<td></td>
					<td><input type="text" name="numGradSemesters" id="numGradSemesters" /></td>
				</tr>

				<tr>
					<td>Have you passed the SPEAK test?</td>
					<td></td>
					<td>
						<input type="radio" name="passSpeak" class="radios" value="yes"> Yes
						</br>
						<input type="radio" name="passSpeak" class="radios" value="no"> No
					</td>
				</tr>

				<tr>
					<td COLSPAN="3">List all graduate-level courses you have completed, as well as the grade you received for each:</td>
				</tr>

				<tr class="list">
					<td>Course Name</td>
					<td></td>
					<td>Grade Received</td>
					<td></td>
					<td></td>
				</tr>

				<tr class="list">
					<td>
						<input type="text" name="course1" id="course1" />
					</td>
					<td></td>
					<td>
						<input type="text" name="grade1" id="grade1" />
					</td>
					<td></td>
					<td><input type="button" class="buttons" value="Add" onclick="addCourse()" /></td>
				</tr>

				<tr><td>&emsp;</td></tr>

				<tr>
					<td>Enter your cumulative GPA for the above courses:</td>
					<td></td>
					<td><input type="text" name="GPA" id="GPA" /></td>
				</tr>

				<tr>
					<td>List all publications, and prove citation:</td>
					<td></td>
					<td><textarea rows="5" cols="50" name="publications" id="publications"></textarea></td>
				</tr>

				<tr><td>&emsp;</td></tr>

				<tr>
					<td colspan="5" class="submitrow">
						<input type="submit" class="buttons" value="Submit">
					</td>
				</tr>
			</table>
			
			<script>
				var index_current_ad=5;
				var num_Ad=1; var num_course=1;
				var index_current_course=16;
			
			</script>
			
			<script>
                
            
                document.getElementById('button_course').onclick=addCourse;

                document.getElementById('button_advisor').onclick=addAdvisor;

                /*function addCourse() {
                    var div = document.createElement('div');

                    div.className = 'row';

                    div.innerHTML = 'Course #'+i+':\<input type="text" name="course'+i+'" id="course'+i+'" />\ Grade #'+i+':\<input type="text" name="grade'+i+'" id="cousre'+i+'" />\<input type="button" value="-" onclick="removeCourse(this)">';
    
                    i++;
                    document.getElementById('course').appendChild(div);
                }*/
				
			
				function addCourse(){
					var table=document.getElementById("table");
					var row=table.insertRow(index_current_course++);
					row.className='list';
					var cell1=row.insertCell(0);
					var cell2=row.insertCell(1);
					var cell3=row.insertCell(2);
					var cell4=row.insertCell(3);
					var cell5=row.insertCell(4);
					
					num_course++;
					cell1.innerHTML='<input type="text" name="course'+num_course+'" id="course'+num_course+'" />';
					cell2.innerHTML='';
					cell3.innerHTML='<input type="text" name="grade'+num_course+'" id="grade'+num_course+'"/>';
					cell4.innerHTML='';
					cell5.innerHTML='<input type="button" class="buttons" value="remove" onclick="removeAdvisor(index_current_course)" />';
     
					table.appendChild('row');
					
					
				}
				function addAdvisor(){
					var table=document.getElementById("table");
					var row=table.insertRow(index_current_ad++);
					row.className='list';
					var cell1=row.insertCell(0);
					var cell2=row.insertCell(1);
					var cell3=row.insertCell(2);
					var cell4=row.insertCell(3);
					var cell5=row.insertCell(4);
					
					num_Ad++;
					index_current_course++;
					cell1.innerHTML='<input type="text" name="past'+num_Ad+'" id="past'+num_Ad+'" />';
					cell2.innerHTML='';
					cell3.innerHTML='<input type="text" name="startAdvisor'+num_Ad+'" id="startAdvisor'+num_Ad+'"/>';
					cell4.innerHTML='<input type="text" name="endAdvisor'+num_Ad+'" id=""endAdvisor'+num_Ad+'" />';
					cell5.innerHTML='<input type="button" class="buttons" value="remove" onclick="removeAdvisor(index_current_ad)" />';
     
					table.appendChild('row');

				}
                /*unction addAdvisor() {
                    var tr = document.createElement('tr');
                    tr.className = 'list';
                    tr.innerHTML ='<td>\<input type="text" name="past1" id="past1" />\</td>\<td>\</td>\<td>\<input type="text" name="startAdvisor1" id="startAdvisor1" />\</td>\<td>\<input type="text" name="endAdvisor1" id="endAdvisor1" />\</td>\<td>\<input type="button" value="-" onclick="removeAdvisor(this)\>"\</td>\<td>\</td>'
                    ii++;
                    document.getElementById('advisor').appendChild(tr);
                }*/

                function removeCourse(input) {
                document.getElementById('course').deleteRow(--index_current_course);
				num_course--;
                }
                
                function removeAdvisor(input) {
                document.getElementById('table').deleteRow(--index_current_ad);
                num_Ad--;
				index_current_course--;
                }
            </script>
			<!-- Name of the nominator
			<input type="text" name="nominatorName" id="nominatorName" />
			</br>

			Name of current Ph.D. advisor
			<input type="text" name="advisorName" id="advisorName" />
			</br>

			List your past advisors and years involved:
			</br>
			Name:
			<input type="text" name="past1" id="past1" />
			&emsp;
			<input type="text" name="startAdvisor1" id="startAdvisor1" /> to
			<input type="text" name="endAdvisor1" id="endAdvisor1" />
			&emsp;
			<input type="button" value="Add" />
			</br>

			Your name
			<input type="text" name="nomineeName" id="nomineeName" />
			</br>

			Your PID
			<input type="text" name="pid" id="pid" />
			</br>

			Your email
			<input type="text" name="nomineeEmail" id="nomineeEmail" />
			</br>

			Your phone number
			<input type="text" name="nomineePhone" id="nomineePhone" />
			</br>

			Are you a Ph.D. student in Computer Science?
			</br>
			<input type="radio" name="isPhd" id="isPhd" value="yes">Yes
			</br>
			<input type="radio" name="isPhd" id="isPhd" value="no">No
			</br>

			How many semesters have you been a graduate student?
			<input type="text" name="numGradSemesters" id="numGradSemesters" />
			</br>

			Have you passed the SPEAK test?
			</br>
			<input type="radio" name="passSpeak" id="passSpeak" value="yes">Yes
			</br>
			<input type="radio" name="passSpeak" id="passSpeak" value="no">No
			</br>
			<input type="radio" name="passSpeak" id="passSpeak" value="grad">Graduated from a U.S. institution
			</br>

			How many semesters (including Summers) have you worked as a GTA?
			<input type="text" name="numGtaSemesters" id="numGtaSemesters" />
			</br>

			List all graduate-level courses you have completed, and the grade you received for each:
			</br>
			Course #1:
			<input type="text" name="course1" id="course1" />
			Grade #1:
			<input type="text" name="grade1" id="grade1" />
			&emsp;
			<input type="button" value="Add" />
			Will able to add more courses
			</br>

			Enter your cumulative GPA for the above courses
			<input type="text" name="GPA" id="GPA" />
			</br>

			List all publications, and provide citation:
			</br>

			<textarea rows="5" cols="50" name="publications" id="publications"></textarea> -->
		</form>
	</body>
</html>