<?php
	include("config.php");
	include("connect.php");
	include("misc.php");

	date_default_timezone_set("US/Eastern");

	// prevent caching
	header('Cache-Control: no-cache');

	$debug = array();

	foreach (range(1, 17) as $week) {
		$page = file_get_contents("http://www.espn.com/nfl/schedule/_/seasontype/2/week/" . $week);

		$tablepattern = '/<table.*?class="schedule.*?>.*?<\/table>/';
		$byepattern = '/<th>BYE<\/th>/';
		$tbodypattern = '/<tbody>.*?<tr.*?><td.*?>.*?<a.*?team-name.*?>.*?<a.*?team-name.*?>.*?<\/tr><\/tbody>/';
		$trpattern = '/<tr.*?>.*?<\/tr>/';
		$teamspattern = '/<abbr.*?>(.*?)<\/abbr>/';
		$timepattern = '/data-date="(.*?)"/';

		if (sizeof($page) != 0) {
			preg_match_all($tablepattern, $page, $tablematch);

			foreach($tablematch[0] as $table) {
				if (preg_match($byepattern, $table)) {
					continue;
				}

				preg_match($tbodypattern, $table, $tbodymatch);
				preg_match_all($trpattern, $tbodymatch[0], $trmatch);

				foreach ($trmatch[0] as $tr) {
					if (preg_match_all($teamspattern, $tr, $teamsmatch)) {
						$awayteam = $teamsarray[$teamsarray[$teamsmatch[1][0]]];
						$hometeam = $teamsarray[$teamsarray[$teamsmatch[1][1]]];
					}
					//echo $awayteam . ' at ' . $hometeam;

					if (preg_match($timepattern, $tr, $timematch)) {
						$starttime = gmdate('Y-m-d H:i:s', strtotime($timematch[1]));
						/*
						if ($timematch[1] != '') {
							$time = $timematch[1];
						}
						else if ($timematch[3] == 'TBD') {
							$time = '4:30 PM';
						}
						*/

						$query = "CALL update_game('" . $hometeam . "', '" . $awayteam . "', " . $season . ", " . $week . ", '" . $starttime . "', NULL, NULL, NULL)";
						echo $query . "\n";

						if (!isset($debug[$hometeam])) {
							$debug[$hometeam] = 0;
						}
						if (!isset($debug[$awayteam])) {
							$debug[$awayteam] = 0;
						}

						$debug[$hometeam]++;
						$debug[$awayteam]++;

						if (($argc > 1) && ($argv[1] == "update")) {
						//	mysql_query($query) or die("Something's wrong.");
						}
					}
				}
			}
		}
	}

	if ($argc <= 1 || $argv[1] != "update") {
		//echo print_r($debug, true);
	}

?>
