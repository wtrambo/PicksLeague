<?php

	function getweek($time = "NOW") {
		if (isset($_GET['week'])) {
			$week = $_GET['week'];
		}

		if ($time == "NOW") {
			$time = mktime();
		}

		if (!isset($week)) {
			// Current time "minus" the Wednesday before the season
			//$diff = $time - mktime(0,0,0,9,5,2007);
			//$diff = $time - mktime(0,0,0,9,4,2008);
			//$diff = $time - mktime(0,0,0,9,9,2009);
			//$diff = $time - mktime(0,0,0,9,8,2010);
			//$diff = $time - mktime(0,0,0,9,7,2011);
			//$diff = $time - mktime(0,0,0,9,5,2012);
			//$diff = $time - mktime(0,0,0,9,4,2013);
			//$diff = $time - mktime(0,0,0,9,3,2014);
			//$diff = $time - mktime(0,0,0,9,9,2015);
			//$diff = $time - mktime(0,0,0,9,7,2016);
			//$diff = $time - mktime(0,0,0,9,6,2017);
			$diff = $time - mktime(0,0,0,9,6,2018);

			// How many days we've gone since the start
			$days = intval($diff / 86400);
		}
		if (isset($days) && (($days < 0) || (isset($week) && ($week <= 0)))) {
			// Let's just ignore the preseason for the immediate future.
			$week = 1;
		}
		else {
			if (isset($days)) {
				$week = intval((($days / 7) + 1));
			}
			if ($week > 17) {
				$week = 17;
			}
		}
		return $week;
	}

?>
