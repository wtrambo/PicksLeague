<?php
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$start = $time;

ob_start();
	session_start();
//	include("login.php");
	include("config.php");
	include("connect.php");
	include("timezone.php");
	include("misc.php");
	include("getweek.php");
	include("style.php");

	$week = getweek();  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
		<title><?php if ($week != 0) { ?>Week <?= $week ?><?php } else { ?>Preseason<?php } ?> &laquo; The Picks League &laquo; Coinflipper</title>
		<link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico" />
		<link rel="stylesheet" type="text/css" href="<?= $style ?>.css" />
		<script type="text/javascript" src="misc.js"></script>
		<script type="text/javascript" src="changepick.js"></script>
	</head>

	<body onload="picksFocus()">
<?php
	include("header.php");
?>
	<div> DEBUG AREA:  Week is: '<?php echo "$week"?>'</div>
		<div id="bigboard-wrapper">
		<table id="bigboard">
			<tr>
				<td class="week" width="15%">
					<select id="weekSelect" onchange="window.location.href = '<?= $_SERVER['PHP_SELF'] ?>?week=' + this.options[selectedIndex].value;">
<?php

	echo "\t\t\t\t\t\t<option value=\"0\"";

	if ($week == -3) {
		echo " selected=\"selected\"";
	}

	echo ">Preseason Week 1</option>\n";

	echo "\t\t\t\t\t\t<option value=\"0\"";

	if ($week == -2) {
		echo " selected=\"selected\"";
	}

	echo ">Preseason Week 2</option>\n";

	echo "\t\t\t\t\t\t<option value=\"0\"";

	if ($week == -1) {
		echo " selected=\"selected\"";
	}

	echo ">Preseason Week 3</option>\n";

	echo "\t\t\t\t\t\t<option value=\"0\"";

	if ($week == 0) {
		echo " selected=\"selected\"";
	}

	echo ">Preseason Week 4</option>\n";

	for ($i = 1; $i <= 17; $i++) {
		echo "\t\t\t\t\t\t<option value=\"" . $i . "\"";
		if ($week == $i) {
			echo " selected=\"selected\"";
		}
		echo ">Week " . $i . "</option>\n";
	}
?>
					</select>
					<br />
					<a href="<?= $_SERVER['PHP_SELF'] ?>?week=<?= ($week - 1) ?>">Previous</a> | <a href="<?= $_SERVER['PHP_SELF'] ?>?week=<?= ($week + 1) ?>">Next</a>
				</td>
<?php
	// fetch the users for the current season and set up their column entries
	$users_query =
		"SELECT user_name, nick_name, favorite_team" .
		"  FROM pl_users" .
		" WHERE season = " . $season .
		" ORDER BY display_rank";

	$users_result = mysqli_query($link, $users_query) or die(mysqli_error($link));

	while ($user_row = mysqli_fetch_assoc($users_result)) {
		$self = '';

		if (isset($_SESSION['username']) && $user_row['user_name'] == $_SESSION['username']) {
			$self = 'self';
		}

		$team = $user_row['favorite_team'];
		$nickname = $user_row['nick_name'];

		//Here is where I'll tweak to remove image and set people's name through CSS
		echo "\t\t\t\t<td class=\"user " . $team . " " . $self . "\" width=\"4%\" onclick=\"viewProfile('" . $nickname . "')\"><span class=\"rotateText\">" . $nickname . "</></td>\n";
	}
	echo "\t\t\t</tr>\n";


	// create a row for each of the games for the current season for the requested week

	$games_query = "SELECT * FROM pl_games WHERE season = " . $season . " AND week = " . $week . " ORDER BY start_time ASC, away_team ASC";
	$games_result = mysqli_query($link, $games_query) or die(mysqli_error($link));

	// these are used for grouping the games time-wise
	$prev_timestamp = 0;
	$group = 1; // initially 1 due to "toggle-first" mechanic

	for ($i = 0; $game_row = mysqli_fetch_assoc($games_result); $i++) {
		// copy all of the fetched columns
		$home_team = $game_row['home_team'];
		$away_team = $game_row['away_team'];
		$home_score = $game_row['home_score'];
		$away_score = $game_row['away_score'];

		// add a "+" sign to positive spreads for nicer displaying
		//
		// a spread which hasn't been set should be displayed as "--"
		if ($game_row['spread'] != "") {
			if ($game_row['spread'] >= 0) {
				$spread = "+" . $game_row['spread'];
			}
			else {
				$spread = $game_row['spread'];
			}
		}
		else {
			$spread = "--";
		}

		// times stored in the database are in UTC
		$start_time = $game_row['start_time'] . " UTC";
		$start_timestamp = strtotime($start_time);
		$date = date("l \a\\t g:ia", $start_timestamp);
		$title = date("l, F j, Y - g:ia", $start_timestamp);

		// lock the game at kick-off
		if (gmmktime() >= $start_timestamp) {
			$locked = true;
		}
		else {
			$locked = false;
		}

		// games within 30 minutes of the first in the group should be grouped
		if (($start_timestamp - 1800) > $prev_timestamp) {
			$group = 1 - $group;
			$prev_timestamp = $start_timestamp;
		}

		// figure out who the winner is, if there is one
		if (($home_score != "") && ($away_score != "")) {
			if (($home_score + $spread) > $away_score) {
				$winner = $home_team;
			}
			else if ($home_score + $spread < $away_score) {
				$winner = $away_team;
			}
			else {
				$winner = $push;
			}
		}
		else {
			$winner = "none";
		}

		// depending on the style, the "top" may be necessary
		if ($i != 0) {
			echo "\t\t\t<tr>\n";
		}
		else {
			echo "\t\t\t<tr class=\"top\">\n";
		}

		// display different stuff in the game column depending on the user's settings and the state of the game
		if ($winner != "none") {
			$score = $away_team . " " . $away_score . ", " . $home_team . " " . $home_score;

			if ($showdate == "yes") {
				echo "\t\t\t\t<td class=\"game gamegroup" . $group . "\" title=\"" . $title . "\"><div class=\"gametext\">" . $away_team . " at " . $home_team . "</div><div class=\"gamescore\">" . $score . "</div></td>\n";
			}
			else {
				echo "\t\t\t\t<td class=\"game gamegroup" . $group . "\" title=\"" . $score . " (" . $title . ")\"><div class=\"gametext\">" . $away_team . " at " . $home_team . "</div></td>\n";
			}
		}
		else {
			if ($showdate == "yes") {
				echo "\t\t\t\t<td class=\"game gamegroup" . $group . "\" title=\"" . $title . "\"><div class=\"gametext\">" . $away_team . " at " . $home_team . "</div><div class=\"gamedate\">" . $date . "</div></td>\n";
			}
			else {
				echo "\t\t\t\t<td class=\"game gamegroup" . $group . "\" title=\"" . $title . "\"><div class=\"gametext\">" . $away_team . " at " . $home_team . "</div></td>\n";
			}
		}

		// fetch each user's picks for this game
		$picks_query = "
			SELECT	user_name, pick, push
			FROM	pl_user_picks_vw
			WHERE
				season = " . $season . " AND
				week = " . $week . " AND
				home_team = '" . $home_team . "' AND
				away_team = '" . $away_team . "'

			ORDER BY
				display_rank
		";
		$picks_result = mysqli_query($link, $picks_query) or die(mysqli_error($link));

		while ($pick_row = mysqli_fetch_assoc($picks_result)) {
			if ($pick_row['pick'] != "") {
				$pick = $pick_row['pick'];
			}
			else {
				$pick = "--";
			}

			if ($showdate == "yes") {
				$pickclass = "pickbig";
			}
			else {
				$pickclass = "picklittle";
			}
 
			if ($locked) {
				$push = $pick_row['push'];

				if ($winner != "none") {
					if (($winner == "push") || ($push == true)) {
						$pickclass .= " push";
					}
					else if ($pick == $winner) {
						$pickclass .= " win";
					}
					else {
						$pickclass .= " loss";
					}
				}
				else {
					$pickclass .= " none";
				}

				echo "\t\t\t\t<td class=\"" . $pickclass . "\">" . $pick . "</td>\n";
			}
			else {
				if (isset($_SESSION['username']) && $pick_row['user_name'] == $_SESSION['username']) {
					echo "\t\t\t\t<td class=\"" . $pickclass . " changeable self\" id=\"change" . $i . "\" onClick=\"changepick('change" . $i . "', '" . $home_team . "', '" . $away_team . "', " . $week . ", " . $season . ", 0)\">" . $pick . "</td>\n";
				}
				else {
					echo "\t\t\t\t<td class=\"" . $pickclass . " none\">&nbsp;</td>\n";
				}
			}
		}

		echo "\t\t\t</tr>\n";
	}


	// fetch how many wins each user has for this week
	$week_wins_query = "
		SELECT wins
		FROM pl_record_vw
		WHERE season = " . $season . " AND week = " . $week . "
		ORDER BY display_rank ASC
	";
	$week_wins_result = mysqli_query($link, $week_wins_query) or die(mysqli_error($link));


	// fetch everybody's win-loss record from the start of the season up through the selected week
	$total_query = "
		SELECT user_name, SUM(wins) AS wins, SUM(losses) AS losses
		FROM pl_record_vw
		WHERE season = " . $season . " AND week > 0 AND week <= " . (($week == 0) ? 1 : $week) . "
		GROUP BY user_name
		ORDER BY display_rank ASC
	";
	$total_result = mysqli_query($link, $total_query) or die(mysqli_error($link));


	// store everything into an array with a row for each user
	$win_data = array();
	$users = array();
	$max_week_wins = 0;
	$max_total_winpct = 0.0;
	$max_total_wins = 0;
	$max_total_losses = 0;

	for ($i = 0; $week_wins_row = mysqli_fetch_assoc($week_wins_result); $i++) {
		$week_wins = $week_wins_row['wins'];

		if ($week_wins > $max_week_wins) {
			$max_week_wins = $week_wins;
		}

		array_push($win_data, array());
		array_push($win_data[$i], $week_wins);
	}

	for ($i = 0; $total_row = mysqli_fetch_assoc($total_result); $i++) {
		array_push($users, $total_row['user_name']);
		$total_wins = $total_row['wins'];
		$total_losses = $total_row['losses'];

		if ($total_wins > 0 || $total_losses > 0) {
			$total_winpct = $total_wins / ($total_wins + $total_losses);
		}
		else {
			$total_winpct = 0;
		}

		if ($total_winpct > $max_total_winpct) {
			$max_total_winpct = $total_winpct;
			$max_total_wins = $total_wins;
			$max_total_losses = $total_losses;
		}

		array_push($win_data[$i], $total_wins);
		array_push($win_data[$i], $total_losses);
		array_push($win_data[$i], $total_winpct);
	}




	echo "\t\t\t<tr class=\"weekly\">\n";
	echo "\t\t\t\t<td class=\"pctlabel\">Wins This Week</td>\n";

	for ($i = 0; $i < count($win_data); $i++) {
		$week_wins = $win_data[$i][0];

		if (isset($_SESSION['username']) && $users[$i] == $_SESSION['username']) {
			$self = 'self';
		}
		else {
			$self = '';
		}

		if ($max_week_wins == 0) {
			echo "\t\t\t\t<td class=\"total " . $self . "\">--</td>\n";
		}
		else if ($week_wins == $max_week_wins) {
			echo "\t\t\t\t<td class=\"besttotal " . $self . "\">" . $week_wins . "</td>\n";
		}
		else {
			echo "\t\t\t\t<td class=\"total " . $self . "\">" . $week_wins . "</td>\n";
		}
	}

	echo "\t\t\t</tr>\n";



	echo "\t\t\t<tr class=\"cumulative\">\n";
	echo "\t\t\t\t<td class=\"pctlabel\">Cumulative Percentage</td>\n";

	for ($i = 0; $i < count($win_data); $i++) {
		$total_wins = $win_data[$i][1];
		$total_losses = $win_data[$i][2];
		$total_winpct = $win_data[$i][3];

		if (isset($_SESSION['username']) && $users[$i] == $_SESSION['username']) {
			$self = 'self';
		}
		else {
			$self = '';
		}

		if ($total_wins + $total_losses == 0) {
			echo "\t\t\t\t<td class=\"total " . $self . "\">-.---</td>\n";
		}
		else if ($total_winpct == $max_total_winpct) {
			echo "\t\t\t\t<td class=\"besttotal " . $self . "\">" . number_format($total_winpct, 3) . "</td>\n";
		}
		else {
			echo "\t\t\t\t<td class=\"total " . $self . "\">" . number_format($total_winpct, 3) . "</td>\n";
		}
	}

	echo "\t\t\t</tr>\n";



	echo "\t\t\t<tr class=\"gamesback\">\n";
	echo "\t\t\t\t<td class=\"pctlabel\">Games Back</td>\n";

	for ($i = 0; $i < count($win_data); $i++) {
		$total_wins = $win_data[$i][1];
		$total_losses = $win_data[$i][2];
		$total_winpct = $win_data[$i][3];

		if (isset($_SESSION['username']) && $users[$i] == $_SESSION['username']) {
			$self = 'self';
		}
		else {
			$self = '';
		}

		if ($max_total_wins + $max_total_losses == 0) {
			echo "\t\t\t\t<td class=\"total " . $self . "\">--</td>\n";
		}
		else if ($total_wins + $total_losses == 0) {
			echo "\t\t\t\t<td class=\"total " . $self . "\">0.5</td>\n";
		}
		else if ($total_winpct == $max_total_winpct) {
			echo "\t\t\t\t<td class=\"besttotal " . $self . "\">--</td>\n";
		}
		else {
			$w = $total_wins; $l = $total_losses;
			$x = $max_total_wins; $y = $max_total_losses;

			$wy = $w * $y;
			$xl = $x * $l;

			$games_back = round(((-1 * ($w + $y)) + sqrt(pow($w + $y, 2) - (4 * ($wy - $xl))))) / 2;

			echo "\t\t\t\t<td class=\"total " . $self . "\">" . max($games_back, 0.5) . "</td>\n";
		}
	}

	echo "\t\t\t</tr>\n";
?>
		</table>
		</div>
	</body>
<?php
if (isset($_SESSION['privilege']) && $_SESSION['privilege'] == "A") {
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$finish = $time;
$totaltime = ($finish - $start);
printf ("This page took %f seconds to load.", $totaltime);
}
?>
</html>
