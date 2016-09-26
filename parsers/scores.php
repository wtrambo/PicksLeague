<?php

	include(realpath(__DIR__ . '/../') . '/config.php');
	include(realpath(__DIR__ . '/../') . '/connect.php');
	include(realpath(__DIR__ . '/../') . '/misc.php');
	include(realpath(__DIR__ . '/../') . '/getweek.php');

	date_default_timezone_set("US/Eastern");

	// prevent caching
	header('Cache-Control: no-cache');

	$scores = file_get_contents('http://www.nfl.com/liveupdate/scorestrip/ss.xml');

	$weekSeasonPattern = '/<gms .*?w="(\d\d?)".*?y="(\d\d\d\d)".*?>/';
	preg_match($weekSeasonPattern, $scores, $weekSeasonMatches);
	$week = intval($weekSeasonMatches[1]);
	$season = intval($weekSeasonMatches[2]);

	$gamePattern = '/<g .*?q="FO?".*?h="(.*?)".*?hs="(\d\d?)".*?v="(.*?)".*?vs="(\d\d?)".*?\/>/';
	preg_match_all($gamePattern, $scores, $gameMatches);

	foreach ($gameMatches[0] as $i => $gameMatch) {
		$awayTeam = $gameMatches[3][$i];
		$awayScore = doubleval($gameMatches[4][$i]);
		$homeTeam = $gameMatches[1][$i];
		$homeScore = doubleval($gameMatches[2][$i]);

		$awayTeam = ($awayTeam == 'JAC') ? 'JAX' : $awayTeam;
		$homeTeam = ($homeTeam == 'JAC') ? 'JAX' : $homeTeam;

		$query = "CALL update_game('" . $homeTeam . "', '" . $awayTeam . "', " . $season . ", " . $week . ", NULL, " . $homeScore . ", " . $awayScore . ", NULL);";

		if ($argc > 1 && $argv[1] == 'update') {
			mysql_query($query);
		}
		else {
			echo $query . "\n"; 
		}
	}

?>
