<?php
	session_start();

	$season = $_GET['season'];
	$week = $_GET['week'];
	$homeTeam = $_GET['homeTeam'];
	$awayTeam = $_GET['awayTeam'];
	$pick = $_GET['pick'];
	//$insert = $_GET['insert'];

	$userName = $_SESSION['username'];

	include('config.php');
	include('connect.php');

	$query;

	$query = "SELECT start_time FROM pl_games WHERE home_team = '" . $homeTeam . "' AND away_team = '" . $awayTeam . "' AND season = " . $season . " AND week = " . $week;
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_assoc($result);

	//$currentTime = strtotime($row['start_time']);

	if (mktime() >= (strtotime($row['start_time'] . " UTC"))) {
		die("Pick submitted after game has been locked:\n Current GMT: " . gmdate("Y-m-d H:i:s") . "\n Game Time GMT: " . date("Y-m-d H:i:s", strtotime($row['start_time'])));
	}
	else if (!$_SESSION['username']) {
		die("There's a problem with your session. Try signing out and signing in again.");
	}

	$query = "CALL update_pick('" . $userName . "', '" . $homeTeam . "', '" . $awayTeam . "', " . $season . ", " . $week . ", '" . $pick . "', NULL)";

	mysqli_query($link, $query) or die(mysqli_error($link));
	mysqli_close();
	echo "success";
?>
