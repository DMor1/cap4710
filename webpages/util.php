<?php
	//Compare $date1 to $date2
	//Return -1 if $date1 is before $date2
	//Return 0 if the dates are the same
	//Return 1 if $date1 is after $date2
	function compareDates($date1, $date2) {
		//Convert to time
		$date1 = strtotime($date1);
		$date2 = strtotime($date2);

		if($date1 < $date2)
			return -1;
		else if($date1 === $date2)
			return 0;
		else 
			return 1;
	}

	//Return the difference in days between two dates
	//Positive number for $date1 before $date2.
	//Negative number for days $date1 is after $date2
	function dayDifference($date1, $date2) {
		//Convert both dates into time	
		$date1 = strtotime($date1);
		$date2 = strtotime($date2);

		//Subtract the dates - convert into diff of days
		$diff = ceil(($date2 - $date1) / 86400);

		//Convert time from seconds diff to days diff
		return $diff;	
	}

	//Return the current date
	function getCurrentDate() {
		return date("Y-m-d");
	}
?>
