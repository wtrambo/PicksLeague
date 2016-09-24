<?php
	include("config.php");
	include("connect.php");

	$users = array();
	$max = 0;

	$query = "SELECT user_name FROM pl_users WHERE season = 2016 ORDER BY user_name ASC";
	$result = mysql_query($query) or die(mysql_error());
?>
<table border="1" cellpadding="4">
	<tr>
		<td></td>
<?

	for ($i = 0; $row = mysql_fetch_assoc($result); $i++) {
		$users[$i] = $row['user_name'];
		echo "\t\t<td><b>" . $users[$i] . "</b></td>\n";
	}
?>
	</tr>
<?


	for ($i = 0; $i < 20; $i++) {
		echo "\t<tr>\n";
		echo "\t\t<td align=\"right\"><b>" . $users[$i] . "</b></td>\n";

		for ($j = 0; $j < 20; $j++) {
			if ($i != $j) {
				$query = "SELECT COUNT(*) AS agree FROM pl_picks AS a, pl_picks AS b WHERE a.home_team = b.home_team AND a.away_team = b.away_team AND a.week = b.week AND a.season = b.season AND a.user_name = '" . $users[$i] . "' AND b.user_name = '" . $users[$j] . "' AND a.pick = b.pick AND a.season = 2016";
				$result = mysql_query($query) or die(mysql_error());
				$row = mysql_fetch_assoc($result);
				$agree = $row['agree'] / 256;

				if ($agree > $max) {
					$max = $agree;
				}

				echo "\t\t<td>" . number_format($agree, 3) . "</td>\n";
			}
			else {
				echo "\t\t<td>*</td>\n";
			}
		}
	}
?>
	</tr>
</table>

<br />

<?= $max ?>
