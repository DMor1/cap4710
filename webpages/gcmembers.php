<?php
	include_once("login_check.php"); //This must come first, import checkrole function
	include_once("db.php"); //Connect to database and initialize session
	include_once("config/config.php");
	check_role(2); //Verify valid role - kick off if not gcchair type
		
	$updated_values=false; // for output to screen that scores have been updated or not on page load
	
	if(!empty($_POST))
	{	
		// loop through to find the number of score rows that need to be updated
		// get the total number of dynamic rows
		$maxkeyint = intval("0");

		foreach($_POST as $key=>$value)
		{
			if(preg_match('/nomineeUserID/',$key))
	  		{
		  		$temp_key = intval(filter_var($key, FILTER_SANITIZE_NUMBER_INT));
		  		//debug_print($temp_key);
		  		//debug_print($maxkeyint);
		  		//max($maxkeyint, $temp_key); // this was for some reason, super buggy
		  	
				if($temp_key > $maxkeyint)
		  		{
					$maxkeyint = $temp_key;
		  		}
	  		}
		}
		
		// for loop through those scores to perform update
		//Since names of columns and the max number to iterate just iterate through the users one at a time
		for($i = 1; $i<=$maxkeyint; $i++)
		{
			// insert user $i
			// insert user_role for user
		
			//["past1"], ["startAdvisor1"],["endAdvisor1"]
			// since past is a primary key value it cannot be null
			
			if($_POST["nomineeUserID".$i] != null || $_POST["nomineeUserID".$i] != "")
			{ //scoreValue
				if(isset($_POST["scoreValue".$i]) || isset($_POST["scoreValue".$i]))
				{

					$sql="INSERT INTO scores (session_id, nominee_user_id, gc_user_id, score, comment)
						VALUES(" . $_POST["session_id"] . ", " . $_POST["nomineeUserID".$i] . ", " . $_SESSION["user_id"] . ", " . $_POST["scoreValue".$i] . ", '" . $_POST["commentValue".$i] . "') ON DUPLICATE KEY UPDATE 
						score= " . (isset($_POST["scoreValue".$i])?$_POST["scoreValue".$i]:'') . ",
						comment= '" . (isset($_POST["commentValue".$i])?$_POST["commentValue".$i]:'') . "'";
						
					if ($conn->query($sql) === TRUE){$updated_values = true;}
					else {echo "Error: " . $sql . "<br>" . $conn->error;}	
				}
			}
		}	
		
	}
	
	
	function getReverseOrderString($input)
	{
		// This function will return either asc or desc (the opposite of) based on whatever is given as input.
		if($input=="asc")
			return "desc";
		else if($input=="desc")
			return "asc";
		else
			return "asc"; //default
	}
	// Get overrides whatever is in Session for ordering
	// Get Order (asc/desc)
	if($_GET["order"]=="asc")
	{
		$_SESSION["gcmember_order"] = "asc";
	}
	else if($_GET["order"]=="desc")
	{
		$_SESSION["gcmember_order"] = "desc";
	}
	
	// Get Column to order by
	if($_GET["column"]=="nominator_name")
	{
		$_SESSION["gcmember_column"] = "nominator_name";
	}
	else if($_GET["column"]=="score_avg")
	{
		$_SESSION["gcmember_column"] = "score_avg";
	}
	
	// If session is still null on the order and column to order by, init with defaults
	// Init Order
	if(!isset($_SESSION["gcmember_order"]))
	{
		$_SESSION["gcmember_order"] = "asc";
	}
	// Init field
	if(!isset($_SESSION["gcmember_column"]))
	{
		$_SESSION["gcmember_column"] = "nominator_name";
	}
	
	//$orderString = 

	// default sort is nominator_name
	$orderby = $_SESSION["gcmember_column"] . " " . $_SESSION["gcmember_order"] . ", ranking asc"; 
	
	//debug_print($orderby);
	// The MAX ... etc refers to the most recent session_id
	$session_id_text = "(SELECT MAX(sessions.session_id) from sessions)";
	// If $_GET["session_id"] is defined, then the user is only interested in seeing past history
	// So change the session_id used for our query to that session_id
	// And flag the page as read only
	$readonly=false; //default
	if(isset($_GET["session_id"]))
	{
		$readonly=true;
		$session_id_text=$_GET["session_id"];
	}
	
	$sql = "
	SELECT 
		q1.session_id,
		q1.nominee_user_id,
		q1.nominated_by_user_id,
		q1.speak_test_id,
		q1.isverified,
		q1.ranking as ranking,
		q1.num_sem_as_grad,
		q1.num_sem_as_gta,
		q1.is_curr_phd,
		q1.is_new_phd,
		q1.cummulative_gpa,
		q1.fname AS fnominee_name,
		q1.lname AS lnominee_name,
		CONCAT(q1.lname, ', ', q1.fname) as nominee_name,
		q1.phonenumber AS nominee_phonenumber,
		q1.respondNomination AS respondDate,
		q1.pid AS nominee_pid,
		q1.email AS nominee_email,		
		users.fname AS fnominator_name,
		users.lname AS lnominator_name,
		CONCAT(users.lname, ', ', users.fname) as nominator_name,
		users.phonenumber AS nominator_phonenumber,
		users.pid AS nominator_pid,
		users.email AS nominator_email,
		q1.score_avg,
		q1.score_list,
		q1.this_gc_score,
		q1.gc_name_list,
		q1.this_gc_comment
	FROM 
	(
		SELECT 
			nominees.*,
			users.*,
		(select avg(scores.score) from scores where scores.nominee_user_id = nominees.nominee_user_id
		and scores.session_id = sessions.session_id) as score_avg,
		(SELECT GROUP_CONCAT(score SEPARATOR ';') FROM scores
		where scores.nominee_user_id = nominees.nominee_user_id
		AND scores.session_id = sessions.session_id
		AND scores.gc_user_id != " . $_SESSION["user_id"] . "
		ORDER BY gc_user_id asc) as score_list,
		(SELECT score FROM scores
		where scores.nominee_user_id = nominees.nominee_user_id
		AND scores.session_id = sessions.session_id
		AND scores.gc_user_id = " . $_SESSION["user_id"] . ") as this_gc_score,
		(SELECT comment FROM scores
		where scores.nominee_user_id = nominees.nominee_user_id
		AND scores.session_id = sessions.session_id
		AND scores.gc_user_id = " . $_SESSION["user_id"] . ") as this_gc_comment,
		(SELECT GROUP_CONCAT(concat(users.lname,',',users.fname) SEPARATOR ';') FROM scores
		INNER JOIN users
		ON users.user_id = gc_user_id
		where scores.nominee_user_id = nominees.nominee_user_id
		AND scores.session_id = sessions.session_id
		AND scores.gc_user_id != " . $_SESSION["user_id"] . "
		ORDER BY gc_user_id asc) as gc_name_list
		FROM sessions
		INNER JOIN nominees
		USING(session_id)
		INNER JOIN users 
		ON users.user_id = nominees.nominee_user_id
		WHERE sessions.session_id = " . $session_id_text . "
	) q1
	INNER JOIN users
	ON users.user_id = q1.nominated_by_user_id
	ORDER BY " . $orderby;
	//debug_print($sql);
	$gcqueryresults=mysqli_query($conn,$sql);
	if(!$gcqueryresults){echo "Error: " . $sql . "<br>" . $conn->error; die();}
?>
<html> 
	 <head>  
		<title>GC Members</title> 
		<link rel="stylesheet" href="styles/style.css">
	 </head>
   
	<body>  
	<?php if($updated_values){echo '<div id="notificationDiv">Notice: Updated nominee scores.</div>';} ?>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	  	<table class="gctable">        
			<?php
				$gcqueryresults=mysqli_query($conn,$sql);
				if ($gcqueryresults)
				{
					$rowNumber = 1;
					$session_id = 999;
					while ($gcqueryrow=mysqli_fetch_array($gcqueryresults))
					{
						if($rowNumber==1)
						{								
							echo '<tr class="gctable">';
							echo '<th>';
							if($_SESSION["gcmember_column"]=="nominator_name")
							{echo '<a href="' . $_SERVER['PHP_SELF'] . '?column=nominator_name&order='.getReverseOrderString($_SESSION["gcmember_order"]).'">Name of Nominator (' . $_SESSION["gcmember_order"] .')</a>';}
							else{echo '<a href="' . $_SERVER['PHP_SELF'] . '?column=nominator_name&order=asc">Name of Nominator</a>';}
							
							echo '</th>';
							echo '<th>Name of Nominee</th>';     
							echo '<th>Rank</th>';
							echo '<th>New Student?</th>';
							echo '<th>Other Provided Scores</th>';
							echo '<th>';
							if($_SESSION["gcmember_column"]=="score_avg")
								{echo '<a href="' . $_SERVER['PHP_SELF'] . '?column=score_avg&order='.getReverseOrderString($_SESSION["gcmember_order"]).'">Average Score (' . $_SESSION["gcmember_order"] .')</a>';}
							else
								{echo '<a href="' . $_SERVER['PHP_SELF'] . '?column=score_avg&order=asc">Average Score</a>';}
							echo '</th>';
							echo '<th>Your Score</th>';
							echo '<th>Your Comment</th>';
							echo '</tr>';
							$session_id = $gcqueryrow["session_id"]; // only need to store this once for later
						}

						if($gcqueryrow["is_new_phd"] == 0)
							$existing="No";							
						else
							$existing="Yes";

						if($gcqueryrow["isverified"] == 1)
						{
							echo '<tr style="text-align:center;">';
							echo '	<td>' . $gcqueryrow["nominator_name"] . '</td>';
							echo '	<td> <a href="javascript:info('. $gcqueryrow["nominee_user_id"] . ')">' . $gcqueryrow["nominee_name"] . '</a></td>';
							echo '	<td>' . $gcqueryrow["ranking"] . '</td>';
							echo '	<td>' . $existing . '</td>';
							echo '	<td>' . $gcqueryrow["gc_name_list"] . '<br>' . $gcqueryrow["score_list"]  . '</td>';
							echo '	<td>' . $gcqueryrow["score_avg"] . '</td>';
							if($readonly)
							{
								echo '<td>' . $gcqueryrow["this_gc_score"] . '</td>';
								echo '<td>' . $gcqueryrow["this_gc_comment"] . '</td>';
							}
							else
							{
								echo '	<td>
										<input type="number" min="1" max="100" name="scoreValue' . $rowNumber . '" placeholder = "0" value="' . $gcqueryrow["this_gc_score"] . '">
										<input type="hidden" name="nomineeUserID' . $rowNumber . '"
															 id="nomineeUserID' . $rowNumber .'"						value="' . $gcqueryrow["nominee_user_id"] . '">
									</td>';
									echo '<td><input type="text" rows="1" cols="50" name="commentValue' . $rowNumber . '" id="commentValue' . $rowNumber . '" value="' . $gcqueryrow["this_gc_comment"] . '"></td>';
							}
							
							echo '</tr>';
							
						}
						else
						{	echo '<li>';
							echo $gcqueryrow["nominee_name"] . ' ';
							if($gcqueryrow["respondDate"] == NULL)
							{
								echo ' is not included in the list because "nominee has not responded" to their nomination.';
							}
							else
								echo ' is not included in the list because "nominator has not verified nominee’s information".';
							echo '</li>';
						}
						$rowNumber++;
					}
					// Free result set
					mysqli_free_result($gcqueryresults);
				}
			?>
		 </table> 
		 <?php
		 if(!$readonly)
		{
			echo '<input type="hidden" name="session_id" id="session_id" value="' . $session_id . '">
					<input type="submit" class="buttons" value="Submit" />';
		}
		 ?>
          
		</form>
		<hr>
		<br>
		<br>
		Sessions:
		<?php
		$sql = "select session_id from sessions order by session_id desc";
		$session_id_results=mysqli_query($conn,$sql);
		if(!$session_id_results){echo "Error: " . $sql . "<br>" . $conn->error; die();}
		if($session_id_results)
		{
			$firstRow = true;
			echo "<ul>";
			while ($sess_id_row=mysqli_fetch_array($session_id_results))
			{
				echo '<li>';
				
				if($firstRow)
				{
					echo '<a href="' . $_SERVER['PHP_SELF'] . '">Session ' . $sess_id_row["session_id"] . ' (most recent)</a>';
					$firstRow=false;
				}
				else
				{
					echo '<a href="' . $_SERVER['PHP_SELF'] . '?session_id=' . $sess_id_row["session_id"] . '">Session ' . $sess_id_row["session_id"] . '</a>';
				}	
				
				echo '</li>';
				
			}
			echo "</ul>";
		}
		else
		{
			echo "No past sessions"; // this really shouldn't be possible
		}
		?>
		
		<a href="changepassword.php">
			<input type="button" class="logout" style="width:175px;" value="Change Password">
		</a>
		<a href="logout.php">
			<input type="button" class="logout" style="width:100px;" value="Log Out">
		</a>
	</body>
	<script type="text/javascript">
		function info(nid){
			//alert(nid);	
			var str="popupNominee.php";
			var str1="<?php getHostURL()?>";
			var url = str1.concat(str,"?nid=", nid);
			window.open(url, 'win32', 'status=no,toolbar=no,scrollbar=yes,titlebar=no, menubar=no, resizable=yes, width=1076,height=768, directories=no, location=no');		
			}
	
	</script>
</html>
<?php
	//Close Database connection
	//Since inline html uses the database, this must be closed at the end
	$conn->close(); 
?>
