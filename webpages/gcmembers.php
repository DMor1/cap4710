<!doctype html>

<html> 
	 <head>  
		<title>GC Members</title> 
		<link rel="stylesheet" href="styles/style.css">
	 </head>
   
	<body>   
	  	<table class="gctable">        
			<tr class="gctable">              
	        	<th>Name of Nominator</th>
				<th>Name of nominee</th>         
				<th>Rank</th>            
				<th>Student status</th>            
				<th><!-- LOOP-name="GClastname1 and Score given--> </th>               
				<th>Average</th>          
				<th>Score</th>        
		 	</tr>
              
		
			<!-- php code here, number of row = number of nominees-->
			<tr>
				<td><!--nominator--></td>
				<td><!--nominee--></td>
				<td><!--rank--></td>
				<td><!--existing/new student--></td>
				<td><!--Score given by each GC--></td>
				<td><!--average--></td>
				<td><input type="text" name="score"></td>
			</tr>
		 </table> 
          
	 	<input type="submit" class="buttons" value="Submit" />
	</body>

</html>
