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

	//Return the current date
	function getCurrentDate() {
		return date("Y-m-d");
	}
?>
