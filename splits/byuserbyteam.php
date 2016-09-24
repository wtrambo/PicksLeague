<?php

	include("../config.php");
	include("../connect.php");
	include("../misc.php");

	$teams = array_values($teamsArray);

	$wins = "SELECT u.user_name";
	$losses = "SELECT u.user_name";

	$prev_team = "";
	foreach ($teams as $team) {
		if ($prev_team != $team) {
			//echo ", " . $team . "_W.count AS " . $team . "_W, " . $team . "_L.count AS " . $team . "_L";
			$wins .= ", " . $team . "_W.count AS " . $team . "_W";
			$losses .= ", " . $team . "_L.count AS " . $team . "_L";
		}
		$prev_team = $team;
	}

	$wins .= " FROM pl_users AS u";
	$losses .= " FROM pl_users AS u";

	$prev_team;
	foreach ($teams as $team) {
		if ($prev_team != $team) {
			//echo " LEFT OUTER JOIN (SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE (home_team = '" . $team . "' OR away_team = '" . $team . "') AND week != 0 AND pick IS NOT NULL AND result = 'win' GROUP BY user_name) AS " . $team . "_W ON u.user_name = " . $team . "_W.user_name LEFT OUTER JOIN (SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE (home_team = '" . $team . "' OR away_team = '" . $team . "') AND week != 0 AND pick IS NOT NULL AND result = 'loss' GROUP BY user_name) AS " . $team . "_L ON " . $team . "_W.user_name = " . $team . "_L.user_name";
			$wins .= " LEFT OUTER JOIN (SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE (home_team = '" . $team . "' OR away_team = '" . $team . "') AND week != 0 AND pick IS NOT NULL AND result = 'win' GROUP BY user_name) AS " . $team . "_W ON u.user_name = " . $team . "_W.user_name";
			$losses .= " LEFT OUTER JOIN (SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE (home_team = '" . $team . "' OR away_team = '" . $team . "') AND week != 0 AND pick IS NOT NULL AND result = 'loss' GROUP BY user_name) AS " . $team . "_L ON u.user_name = " . $team . "_L.user_name";
		}
		$prev_team = $team;
	}

	$wins .= " ORDER BY u.user_name;";
	$losses .= " ORDER BY u.user_name;";
?>
<html>
	<head>
		<title>Splits by user by team.</title>
		<style type="text/css">
			table {
				white-space: nowrap;
				border-collapse: collapse;
				table-layout: fixed;
			}
		</style>
	</head>
	<body>
		<table cellspacing="0" cellpadding="5" border="1">
<?

	$wins_result = mysql_query($wins);
	$losses_result = mysql_query($losses);

	echo "\t\t\t<tr>\n";
	echo "\t\t\t\t<th align=\"right\"></th>\n";
	$prev_team = "";
	foreach ($teams as $team) {
		if ($prev_team != $team) {
			echo "\t\t\t\t<th align=\"right\">" . $team . "</th>\n";
		}
		$prev_team = $team;
	}
	echo "\t\t\t</tr>\n";

	while (($wins_row = mysql_fetch_assoc($wins_result)) && ($losses_row = mysql_fetch_assoc($losses_result))) {
		echo "\t\t\t<tr>\n";
		echo "\t\t\t\t<th align=\"right\">" . $wins_row['user_name'] . "</th>\n";

		$prev_team = "";
		foreach ($teams as $team) {
			if ($prev_team != $team) {
				if ($wins_row[$team . '_W'] == "") {
					$w = 0;
				}
				else {
					$w = $wins_row[$team . '_W'];
				}

				if ($losses_row[$team . '_L'] == "") {
					$l = 0;
				}
				else {
					$l = $losses_row[$team . '_L'];
				}

				echo "\t\t\t\t<td align=\"right\">" . $w . "-" . $l . "</td>\n";
			}
			$prev_team = $team;
		}

		echo "\t\t\t</tr>\n";
	}

?>
		</table>
	</body>
</html>
