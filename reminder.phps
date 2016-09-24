<?php
	include("config.php");
	include("connect.php");
	include("misc.php");
	include("getweek.php");

	$week = getweek();

	$emails = array(
/*		"alok.vasudev@gmail.com",
		"blair.shiff@gmail.com",
		"chriskoci@gmail.com",
		"dgrysen@gmail.com",
		"david@townlake.com",
		"devincurry@mail.utexas.edu",
		"erica.joyce.wang@gmail.com",
		"vtmsciguy@gmail.com",
		"sneden@gmail.com",
		"bewildered@gmail.com",
		"ksomandar@yahoo.com",
		"oreoflow@gmail.com",
		"lukezim@gmail.com",
		"matt.jancaitis@gmail.com",*/
		"jpnance@gmail.com",
/*		"qtmartindale@gmail.com",
		"rob@cryptic.org",
		"stephenkent@mail.utexas.edu",
		"trevor.highland@gmail.com",
		"schankster@gmail.com",*/
	);
	//$timestamp = mktime(9, 0, 0, 9, 5, 2007) + 86400;
	$timestamp = mktime() + 86400;
	$tomorrow = gmdate("'Y-m-d H:i:s'", $timestamp);
	$thenextday = gmdate("'Y-m-d H:i:s'", $timestamp + 86400);

	$query = "
		SELECT
			home_team,
			away_team,
			start_time,
			spread

		FROM
			pl_games

		WHERE
			season = " . $season . " AND
			week = " . $week . " AND
			start_time >= " . $tomorrow . " AND
			start_time < " . $thenextday . "

		ORDER BY
			start_time ASC
	";

	$message_full = "http://www.coinflipper.org/\n\n";
	$message_full .= "The following game(s) are scheduled for tomorrow. You're responsible for keeping an eye on any spreads not yet posted.\n\n";
	$message_mobile = "";

	$result = mysql_query($query);

	if (mysql_num_rows($result) > 0) {
		$send = true;
	}
	else {
		$send = false;
	}

	while ($row = mysql_fetch_assoc($result)) {
		$away_team_full = $teamsarray[$row['away_team']];
		$home_team_full = $teamsarray[$row['home_team']];
		$away_team_mobile = $row['away_team'];
		$home_team_mobile = $row['home_team'];

		if ($row['spread'] == "") {
			$spread = "--";
		}
		else if ($row['spread'] > 0) {
			$spread = "+" . $row['spread'];
		}
		else {
			$spread = $row['spread'];
		}

		$start_time = $row['start_time'];

		$message_full .= $away_team_full . " at " . $home_team_full . " (" . $spread . ")\n";
		//$message_full .= date("l, F j \a\\t g:ia", strtotime($start_time . " UTC")) . "\n\n";

		$message_mobile .= $away_team_mobile . "/" . $home_team_mobile . " " . $spread . "\n";
	}

	$message_full .= "\nGood luck,\nPatrick\n";

	if ($send) {
/*
		$query = "SELECT email FROM pl_users WHERE season = " . $season . " AND email IS NOT NULL AND email != ''";
		$result = mysql_query($query);

		while ($row = mysql_fetch_row($result)) {
			mail($row[0], "NFL Picks Reminder - Week " . $week, $message_full, 'From: Patrick Nance <jpnance@gmail.com>' . "\r\n");
		}
*/
		echo $message_full;
	}
?>
