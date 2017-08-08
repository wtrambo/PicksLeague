<?php
	if (isset($_COOKIE['timezone'])) {
		date_default_timezone_set($_COOKIE['timezone']);
	}
	else {
		date_default_timezone_set("US/Central");
	}
?>
