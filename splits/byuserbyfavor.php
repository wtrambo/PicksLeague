<?php

	include("../config.php");
	include("../connect.php");
	include("../misc.php");

	$teams = array_values($teamsarray);

	$query1 = trim(file_get_contents("byuserbyfavor2004.sql"));
	$query2 = "SELECT COUNT(*) AS count FROM pl_games WHERE week != 0 AND season = 2004 AND home_score + spread > away_score";
	$query3 = "SELECT COUNT(*) AS count FROM pl_games WHERE week != 0 AND season = 2004 AND home_score + spread < away_score";
	$query4 = "SELECT COUNT(*) AS count FROM pl_games WHERE week != 0 AND season = 2004 AND ((home_score + spread > away_score AND spread < 0) OR (home_score + spread < away_score AND spread > 0))";
	$query5 = "SELECT COUNT(*) AS count FROM pl_games WHERE week != 0 AND season = 2004 AND ((home_score + spread < away_score AND spread < 0) OR (home_score + spread > away_score AND spread > 0))";
	$query6 = "SELECT COUNT(*) AS count FROM pl_games WHERE week != 0 AND season = 2004 AND home_score + spread > away_score AND spread < 0";
	$query7 = "SELECT COUNT(*) AS count FROM pl_games WHERE week != 0 AND season = 2004 AND home_score + spread < away_score AND spread < 0";
	$query8 = "SELECT COUNT(*) AS count FROM pl_games WHERE week != 0 AND season = 2004 AND home_score + spread > away_score AND spread > 0";
	$query9 = "SELECT COUNT(*) AS count FROM pl_games WHERE week != 0 AND season = 2004 AND home_score + spread < away_score AND spread > 0";

?>
<html>
	<head>
		<title>Splits by user by favor.</title>
		<style type="text/css">
			table {
				white-space: nowrap;
				border-collapse: collapse;
				table-layout: fixed;
			}

			td {
				width: 10%;
			}

			.record {
			}

			.winpct {
				font-size: 75%;
			}
		</style>
	</head>
	<body>
		<table cellspacing="0" cellpadding="5" border="1">
<?

	$result1 = mysql_query($query1);
	$result2 = mysql_query($query2);
	$result3 = mysql_query($query3);
	$result4 = mysql_query($query4);
	$result5 = mysql_query($query5);
	$result6 = mysql_query($query6);
	$result7 = mysql_query($query7);
	$result8 = mysql_query($query8);
	$result9 = mysql_query($query9);

	$row = mysql_fetch_assoc($result2);
	$totalHomeW = $row['count'];
	$row = mysql_fetch_assoc($result3);
	$totalHomeL = $row['count'];
	$row = mysql_fetch_assoc($result4);
	$totalFavW = $row['count'];
	$row = mysql_fetch_assoc($result5);
	$totalFavL = $row['count'];
	$row = mysql_fetch_assoc($result6);
	$totalHomeFavW = $row['count'];
	$row = mysql_fetch_assoc($result7);
	$totalHomeFavL = $row['count'];
	$row = mysql_fetch_assoc($result8);
	$totalHomeDogW = $row['count'];
	$row = mysql_fetch_assoc($result9);
	$totalHomeDogL = $row['count'];

	echo "\t\t\t<tr>\n";
	echo "\t\t\t\t<th align=\"right\"></th>\n";
	echo "\t\t\t\t<th align=\"right\">Overall</th>\n";
	echo "\t\t\t\t<th align=\"right\">Home<br /><span class=\"record\">" . $totalHomeW . "-" . $totalHomeL . "</span>, <span class=\"winpct\">" . number_format($totalHomeW / ($totalHomeW + $totalHomeL), 3) . "</span></th>\n";
	echo "\t\t\t\t<th align=\"right\">Away<br /><span class=\"record\">" . $totalHomeL . "-" . $totalHomeW . "</span>, <span class=\"winpct\">" . number_format($totalHomeL / ($totalHomeW + $totalHomeL), 3) . "</span></th>\n";
	echo "\t\t\t\t<th align=\"right\">Favorites<br /><span class=\"record\">" . $totalFavW . "-" . $totalFavL . "</span>, <span class=\"winpct\">" . number_format($totalFavW / ($totalFavW + $totalFavL), 3) . "</span></th>\n";
	echo "\t\t\t\t<th align=\"right\">Underdogs<br /><span class=\"record\">" . $totalFavL . "-" . $totalFavW . "</span>, <span class=\"winpct\">" . number_format($totalFavL / ($totalFavW + $totalFavL), 3) . "</span></th>\n";
	echo "\t\t\t\t<th align=\"right\">Home Favorites<br /><span class=\"record\">" . $totalHomeFavW . "-" . $totalHomeFavL . "</span>, <span class=\"winpct\">" . number_format($totalHomeFavW / ($totalHomeFavW + $totalHomeFavL), 3) . "</span></th>\n";
	echo "\t\t\t\t<th align=\"right\">Away Favorites<br /><span class=\"record\">" . $totalHomeDogL . "-" . $totalHomeDogW . "</span>, <span class=\"winpct\">" . number_format($totalHomeDogL / ($totalHomeDogW + $totalHomeDogL), 3) . "</span></th>\n";
	echo "\t\t\t\t<th align=\"right\">Home Underdogs<br /><span class=\"record\">" . $totalHomeDogW . "-" . $totalHomeDogL . "</span>, <span class=\"winpct\">" . number_format($totalHomeDogW / ($totalHomeDogW + $totalHomeDogL), 3) . "</span></th>\n";
	echo "\t\t\t\t<th align=\"right\">Away Underdogs<br /><span class=\"record\">" . $totalHomeFavL . "-" . $totalHomeFavW . "</span>, <span class=\"winpct\">" . number_format($totalHomeFavL / ($totalHomeFavW + $totalHomeFavL), 3) . "</span></th>\n";
	echo "\t\t\t</tr>\n";

	while ($row = mysql_fetch_assoc($result1)) {
		$w = ($row['W'] ? $row['W'] : 0);
		$l = ($row['L'] ? $row['L'] : 0);
		$hW = ($row['hW'] ? $row['hW'] : 0);
		$hL = ($row['hL'] ? $row['hL'] : 0);
		$aW = ($row['aW'] ? $row['aW'] : 0);
		$aL = ($row['aL'] ? $row['aL'] : 0);
		$favW = ($row['favW'] ? $row['favW'] : 0);
		$favL = ($row['favL'] ? $row['favL'] : 0);
		$dogW = ($row['dogW'] ? $row['dogW'] : 0);
		$dogL = ($row['dogL'] ? $row['dogL'] : 0);
		$hfavW = ($row['hfavW'] ? $row['hfavW'] : 0);
		$hfavL = ($row['hfavL'] ? $row['hfavL'] : 0);
		$afavW = ($row['afavW'] ? $row['afavW'] : 0);
		$afavL = ($row['afavL'] ? $row['afavL'] : 0);
		$hdogW = ($row['hdogW'] ? $row['hdogW'] : 0);
		$hdogL = ($row['hdogL'] ? $row['hdogL'] : 0);
		$adogW = ($row['adogW'] ? $row['adogW'] : 0);
		$adogL = ($row['adogL'] ? $row['adogL'] : 0);

		echo "\t\t\t<tr>\n";
		echo "\t\t\t\t<th align=\"right\">" . $row['user_name'] . "</th>\n";
		echo "\t\t\t\t<td align=\"right\"><span class=\"record\">" . $w . "-" . $l . "</span>, <span class=\"winpct\">" . number_format($w / ($w + $l), 3) . "</span></td>\n";
		echo "\t\t\t\t<td align=\"right\"><span class=\"record\">" . $hW . "-" . $hL . "</span>, <span class=\"winpct\">" . number_format($hW / ($hW + $hL), 3) . "</span></td>\n";
		echo "\t\t\t\t<td align=\"right\"><span class=\"record\">" . $aW . "-" . $aL . "</span>, <span class=\"winpct\">" . number_format($aW / ($aW + $aL), 3) . "</span></td>\n";
		echo "\t\t\t\t<td align=\"right\"><span class=\"record\">" . $favW . "-" . $favL . "</span>, <span class=\"winpct\">" . number_format($favW / ($favW + $favL), 3) . "</span></td>\n";
		echo "\t\t\t\t<td align=\"right\"><span class=\"record\">" . $dogW . "-" . $dogL . "</span>, <span class=\"winpct\">" . number_format($dogW / ($dogW + $dogL), 3) . "</span></td>\n";
		echo "\t\t\t\t<td align=\"right\"><span class=\"record\">" . $hfavW . "-" . $hfavL . "</span>, <span class=\"winpct\">" . number_format($hfavW / ($hfavW + $hfavL), 3) . "</span></td>\n";
		echo "\t\t\t\t<td align=\"right\"><span class=\"record\">" . $afavW . "-" . $afavL . "</span>, <span class=\"winpct\">" . number_format($afavW / ($afavW + $afavL), 3) . "</span></td>\n";
		echo "\t\t\t\t<td align=\"right\"><span class=\"record\">" . $hdogW . "-" . $hdogL . "</span>, <span class=\"winpct\">" . number_format($hdogW / ($hdogW + $hdogL), 3) . "</span></td>\n";
		echo "\t\t\t\t<td align=\"right\"><span class=\"record\">" . $adogW . "-" . $adogL . "</span>, <span class=\"winpct\">" . number_format($adogW / ($adogW + $adogL), 3) . "</span></td>\n";
		echo "\t\t\t</tr>\n";
	}

?>
		</table>
	</body>
</html>
