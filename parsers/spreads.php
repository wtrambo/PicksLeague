<?php
	include(realpath(__DIR__ . '/../') . '/config.php');
	include(realpath(__DIR__ . '/../') . '/connect.php');
	include(realpath(__DIR__ . '/../') . '/misc.php');
	include(realpath(__DIR__ . '/../') . '/getweek.php');

	date_default_timezone_set("US/Eastern");

	// prevent caching
	header('Cache-Control: no-cache');

	$page = file("http://www.covers.com/Sports/NFL/Odds/Matchups/1/SPREAD/competition/Vegas/ML");

	if ($page === false) {
		exit(-1);
	}

	$gamePattern = '/<tr class=".*?conferenceRow">(.*?)<\/tr>/';
	$teamsPattern = '/<span class="cover-CoversOdds-tableTeamLink"><a.*?>\s+(.*?)\s+<\/a><\/span>/';
	$dateTimePattern = '/<span class="cover-CoversOdds-tableTime">(.*?)\s+ET.*?<\/span>/';
	$spreadPattern = '/<div class="cover-CoversOdds-odds-middle"><span title=".*?" class="covers-CoversOdds-topOddsHome">(.*?)<\/span><span>.*?<\/span><\/div>/';

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
			
			preg_match_all($teamsPattern, $game, $teamsMatch);
			$awayTeam = normalizeAbbreviation(trim($teamsMatch[1][0]));
			$homeTeam = normalizeAbbreviation(trim($teamsMatch[1][1]));

			preg_match($spreadPattern, $game, $spreadMatch);

			if (count($spreadMatch) > 0) {
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
			}
			else {
				$spread = 'NULL';
			}

			preg_match($dateTimePattern, $game, $dateTimeMatch);
			$dateTime = trim($dateTimeMatch[1]);
			$startTime = date('Y-m-d H:i:s', strtotime($dateTime));
			$startTimeUtc = gmdate('Y-m-d H:i:s', strtotime($dateTime));

			if (($argc > 1) && ($argv[1] == "preview")) {
			}
			else if (strtotime($startTime) - time() > 48 * 60 * 60) {
				continue;
			}

			$week = getweek(strtotime($dateTime . " " . ($season + (preg_match('/Jan/', $dateTime) ? 1 : 0))));
			$query = "CALL update_game('{$homeTeam}', '{$awayTeam}', {$season}, {$week}, '{$startTimeUtc}', NULL, NULL, {$spread});";

			if ($query != "NULL") {
				echo $query . "\n";

				if (($argc > 1) && ($argv[1] == "update")) {
					mysqli_query($link, $query);
				}
			}
		}
	}
?>
