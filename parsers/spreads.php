<?php
	include(realpath(__DIR__ . '/../') . '/config.php');
	include(realpath(__DIR__ . '/../') . '/connect.php');
	include(realpath(__DIR__ . '/../') . '/misc.php');
	include(realpath(__DIR__ . '/../') . '/getweek.php');

	date_default_timezone_set("US/Eastern");

	// prevent caching
	header('Cache-Control: no-cache');

	$page = file("http://www.covers.com/odds/football/nfl-spreads.aspx");

	if ($page === false) {
		exit(-1);
	}

	$gamePattern = '/<tr id="\/sport\/football\/competition.*?>(.*?)<\/tr>/';
	$teamsPattern = '/<div id="odds_teams">.*?<div class="team_away">.*?<strong>(.*?)<\/strong>.*?<\/div>.*?<div class="team_home">.*?<strong>@?(.*?)<\/strong>.*?<\/div>/';
	$dateTimePattern = '/<td.*?class="odds_table_row"><div><div class="team_away">(.*?)<\/div><div class="team_home">(.*?)ET.*?<\/div><\/div><\/td>/';
	$spreadPattern = '/<td class="covers_top".*?>.*?<div class="covers_bottom">(.*?)<\/div>.*?<\/td>/';

	if (sizeof($page) != 0) {
		$pageLine = "";
		foreach ($page as $line) {
			$line = rtrim($line, "\r\n");
			$pageLine .= $line;
		}
		$pageLine = preg_replace('/>\s*</', '><', $pageLine);

		preg_match_all($gamePattern, $pageLine, $gameMatch);

		foreach ($gameMatch[0] as $game) {
			$query = "NULL";
			
			preg_match($teamsPattern, $game, $teamsMatch);
			$awayTeam = $teamsarray[trim($teamsMatch[1])];
			$homeTeam = $teamsarray[trim($teamsMatch[2])];

			preg_match($spreadPattern, $game, $spreadMatch);
			$spread = trim($spreadMatch[1]);
			if ($spread == 'pk') {
				$spread = 0.5;
			}
			else if (preg_match('/\.5/', $spread)) {
				$spread = floatval($spread);
			}
			else {
				$spread = floatval($spread) + 0.5;
			}

			preg_match($dateTimePattern, $game, $dateTimeMatch);
			$date = trim($dateTimeMatch[1]);
			$time = trim($dateTimeMatch[2]);
			$startTime = date('Y-m-d H:i:s', strtotime($date . ' ' . $time));
			$startTimeUtc = gmdate('Y-m-d H:i:s', strtotime($date . ' ' . $time));

			if (($argc > 1) && ($argv[1] == "preview")) {
			}
			else if (strtotime($startTime) - time() > 48 * 60 * 60) {
				continue;
			}

			$week = getweek(strtotime($date . " " . ($season + (preg_match('/Jan/', $date) ? 1 : 0))));
			$query = "CALL update_game('" . $homeTeam . "', '" . $awayTeam . "', " . $season . ", " . $week . ", NULL, NULL, NULL, " . $spread .");";

			if ($query != "NULL") {
				echo $query . "\n";

				if (($argc > 1) && ($argv[1] == "update")) {
					mysql_query($query);
				}
			}
		}
	}
?>
