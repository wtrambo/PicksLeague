<?php
	session_start();
	include("config.php");
	include("connect.php");
	include("style.php");
	include("misc.php");

	$success = false;
	$changePass = 0;

	$showdate = $_COOKIE['showdate'];

	if ($_POST['submit']) {
		$password1 = mysqli_real_escape_string($link, $_POST['password1']);
		$password2 = mysqli_real_escape_string($link, $_POST['password2']);
		$timezone = mysqli_real_escape_string($link, $_POST['timezone']);
		$email = mysqli_real_escape_string($link, $_POST['email']);
		$favoriteTeam = mysqli_real_escape_string($link, $_POST['favoriteTeam']);
		$phone = mysqli_real_escape_string($link, $_POST['areacode']) . mysqli_real_escape_string($link, $_POST['prefix']) . mysqli_real_escape_string($link, $_POST['suffix']);
		$profile = mysqli_real_escape_string($link, $_POST['profile']);
/*
		$profile = str_replace("<", "&lt;", $profile);
		$profile = str_replace(">", "&gt;", $profile);
		$profile = preg_replace("/\r\n(\r\n)+/", "<p />", $profile);
		$profile = str_replace("\r\n", "<br />", $profile);
		$profile = preg_replace("/(\[b\])(.*)(\[\/b\])/", "<b>\\2</b>", $profile);
		$profile = preg_replace("/(\[u\])(.*)(\[\/u\])/", "<u>\\2</u>", $profile);
		$profile = preg_replace("/(\[i\])(.*)(\[\/i\])/", "<i>\\2</i>", $profile);
		$profile = preg_replace("/(\[strike\])(.*)(\[\/strike\])/", "<strike>\\2</strike>", $profile);
		$profile = preg_replace("/(\[url\])(.*)(\[\/url\])/", "<a href=\"\\2\">\\2</a>", $profile);
		$profile = preg_replace("/(\[url )(.*)(\])(.*)(\[\/url\])/", "<a href=\"\\2\">\\4</a>", $profile);
*/

		if (($password1 != "") && ($password1 == $password2)) {
			$changePass = 1;

			$query =
				"UPDATE pl_users SET timezone = '" . $timezone . "'," .
				"                    email = '" . $email . "'," .
				"                    phone = '" . $phone . "'," .
				"                    favorite_team = '" . $favoriteTeam . "'," .
				"                    profile = '" . $profile . "'," .
				"                    password = MD5('" . $password1 . "')" .
				" WHERE user_name = '" . $_SESSION['username'] . "' AND" .
				"       season = " . $season;
		}

		else {
			if (($password1 != "") || ($password2 != "")) {
				$changePass = -1;
			}
			$query =
				"UPDATE pl_users SET timezone = '" . $timezone . "'," .
				"                    email = '" . $email . "'," .
				"                    phone = '" . $phone . "'," .
				"                    favorite_team = '" . $favoriteTeam . "'," .
				"                    profile = '" . $profile . "'" .
				" WHERE user_name = '" . $_SESSION['username'] . "'" .
				" AND season = " . $season;
		}

		$result = mysqli_query($link, $query) or die(mysqli_error($link));

		setcookie("timezone", $timezone, $cookieExpirationTime);

		setcookie("style", $_POST['style'], $cookieExpirationTime);
		$style = $_POST['style'];

		if ($_POST['showdate']) {
			setcookie("showdate", "yes", $cookieExpirationTime);
			$showdate = "yes";
		}
		else {
			setcookie("showdate", "no", $cookieExpirationTime);
			$showdate = "no";
		}

		$success = true;
	}

	include("timezone.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Preferences &laquo; The Picks League &laquo; Coinflipper</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico" />
		<link href="<?= $style ?>.css" rel="stylesheet" type="text/css" />

<?php

	$query =
		"SELECT user_name, first_name, last_name, nick_name, location, timezone, email, phone, favorite_team, profile" .
		"  FROM pl_users" .
		" WHERE user_name = '" . $_SESSION['username'] . "' AND season = " . $season;
	$result = mysqli_query($link, $query) or die(mysqli_error($link));

	if ($row = mysqli_fetch_assoc($result)) {
		$username = $row['user_name'];

		if (($row['nick_name'] != $row['first_name']) && ($row['nick_name'] != $row['last_name'])) {
			$fullname = $row['first_name'] . " (" . $row['nick_name'] . ") " . $row['last_name'];
		}
		else {
			$fullname = $row['first_name']." ".$row['last_name'];
		}

		$location = $row['location'];
		$timezone = $row['timezone'];
		$email = $row['email'];
		$areacode = substr($row['phone'],0,3);
		$prefix = substr($row['phone'],3,3);
		$suffix = substr($row['phone'],6,4);
		$favoriteteam = $row['favorite_team'];
		$profile = $row['profile'];
		$profile = str_replace("<p />","\r\n\r\n",$profile);
		$profile = str_replace("<br />","\r\n",$profile);
                $profile = preg_replace("/(\<b\>)(.*)(\<\/b\>)/", "[b]\\2[/b]", $profile);
                $profile = preg_replace("/(\<u\>)(.*)(\<\/u\>)/", "[u]\\2[/u]", $profile);
                $profile = preg_replace("/(\<i\>)(.*)(\<\/i\>)/", "[i]\\2[/i]", $profile);
                $profile = preg_replace("/(\<strike\>)(.*)(\<\/strike\>)/", "[strike]\\2[/strike]", $profile);
                $profile = preg_replace("/(\<a href=\")(.*)(\"\>)(.*)(\<\/a\>)/", "[url \\2]\\4[/url]", $profile);
	}
?>
	</head>

	<body>
<?php include("header.php"); ?>
		<h1>Preferences</h1>
		<?php if ($success) { ?><span class="saved">Settings Saved <?php if ($changePass == 1) { ?>(Password Changed)<?php } if ($changePass == -1) { ?>(Password Not Changed)<?php } ?></span><?php } ?><p />
<?php if ($_SESSION['username']) { ?>
		<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
			<table class="fancyTable" cellspacing="0">
				<tr class="top">
					<td class="field">Username</td>
					<td class="value"><?= $username ?></td>
				</tr>

				<tr>
					<td class="field">Full Name</td>
					<td class="value"><?= $fullname ?></td>
				</tr>

				<tr>
					<td class="field">Location</td>
					<td class="value"><?= $location ?></td>
				</tr>

				<tr>
					<td class="field"><label for="pw">Password</label></td>
					<td class="value">
						<i>Type a new password twice:</i><br />
						<input type="password" name="password1" size="20" id="pw" />
						<input type="password" name="password2" size="20" />
					</td>
				</tr>

				<tr>
					<td class="field"><label for="tz">Time Zone</label></td>

					<td class="value">
						<select name="timezone" id="tz">
							<option value="US/Pacific"<?php if ($timezone == "US/Pacific") echo " selected=\"selected\""; ?>>US/Pacific</option>
							<option value="US/Mountain"<?php if ($timezone == "US/Mountain") echo " selected=\"selected\""; ?>>US/Mountain</option>
							<option value="US/Central"<?php if ($timezone == "US/Central") echo " selected=\"selected\""; ?>>US/Central</option>
							<option value="US/Eastern"<?php if ($timezone == "US/Eastern") echo " selected=\"selected\""; ?>>US/Eastern</option>
							<option value="Canada/Eastern"<?php if ($timezone == "Canada/Eastern") echo " selected=\"selected\""; ?>>Canada/Eastern</option>
						</select>
					</td>
				</tr>

				<tr>
					<td class="field"><label for="em">Email</label></td>
					<td class="value"><input type="text" name="email" maxlength="100" size="40" id="em" value="<?= $email ?>" /></td>
				</tr>

				<tr>
					<td class="field"><label for="ph">Phone</label></td>

					<td class="value">
						(<input type="text" name="areacode" class="phone" maxlength="3" size="4" id="ph" value="<?= $areacode ?>" />)
						<input type="text" name="prefix" class="phone" maxlength="3" size="4" value="<?= $prefix ?>" /> - 
						<input type="text" name="suffix" class="phone" maxlength="4" size="5" value="<?= $suffix ?>" />
					</td>
				</tr>

				<tr>
					<td class="field"><label for="ft">Favorite Team</label></td>
					<td class="value">
						<select name="favoriteTeam" id="ft">
							<option value="h1836"<?php if ($favoriteteam == "h1836") echo " selected=\"selected\""; ?>>1836</option>
							<option value="aggies"<?php if ($favoriteteam == "aggies") echo " selected=\"selected\""; ?>>Aggies</option>
							<option value="ajax"<?php if ($favoriteteam == "ajax") echo " selected=\"selected\""; ?>>Ajax</option>
							<option value="arsenal"<?php if ($favoriteteam == "arsenal") echo " selected=\"selected\""; ?>>Arsenal</option>
							<option value="avfc"<?php if ($favoriteteam == "avfc") echo " selected=\"selected\""; ?>>Aston Villa</option>
							<option value="blues"<?php if ($favoriteteam == "blues") echo " selected=\"selected\""; ?>>Blues</option>
							<option value="buccaneers1976"<?php if ($favoriteteam == "buccaneers1976") echo " selected=\"selected\""; ?>>Buccaneers (1976)</option>
							<option value="buckeyes"<?php if ($favoriteteam == "buckeyes") echo " selected=\"selected\""; ?>>Buckeyes</option>
							<option value="cardiffcity"<?php if ($favoriteteam == "cardiffcity") echo " selected=\"selected\""; ?>>Cardiff City</option>
							<option value="cardinal"<?php if ($favoriteteam == "cardinal") echo " selected=\"selected\""; ?>>Cardinal</option>
							<option value="chargers2002"<?php if ($favoriteteam == "chargers2002") echo " selected=\"selected\""; ?>>Chargers (2002)</option>
							<option value="chelsea"<?php if ($favoriteteam == "chelsea") echo " selected=\"selected\""; ?>>Chelsea</option>
							<option value="ct"<?php if ($favoriteteam == "ct") echo " selected=\"selected\""; ?>>Chinese Taipei</option>
							<option value="cibaenas"<?php if ($favoriteteam == "cibaenas") echo " selected=\"selected\""; ?>>Cibaeñas</option>
							<option value="colt45s"<?php if ($favoriteteam == "colt45s") echo " selected=\"selected\""; ?>>Colt .45s</option>
							<option value="crusaders"<?php if ($favoriteteam == "crusaders") echo " selected=\"selected\""; ?>>Crusaders</option>
							<option value="diamondjaxx"<?php if ($favoriteteam == "diamondjaxx") echo " selected=\"selected\""; ?>>Diamond Jaxx</option>
							<option value="dolphins1997"<?php if ($favoriteteam == "dolphins1997") echo " selected=\"selected\""; ?>>Dolphins (1997)</option>
							<option value="ecb"<?php if ($favoriteteam == "ecb") echo " selected=\"selected\""; ?>>England</option>
							<option value="everton"<?php if ($favoriteteam == "everton") echo " selected=\"selected\""; ?>>Everton</option>
							<option value="flyingtigers"<?php if ($favoriteteam == "flyingtigers") echo " selected=\"selected\""; ?>>Flying Tigers</option>
							<option value="hokies"<?php if ($favoriteteam == "hokies") echo " selected=\"selected\""; ?>>Hokies</option>
							<option value="jaguars1995"<?php if ($favoriteteam == "jaguars1995") echo " selected=\"selected\""; ?>>Jaguars (1995)</option>
							<option value="lions2003"<?php if ($favoriteteam == "lions2003") echo " selected=\"selected\""; ?>>Lions (2003)</option>
							<option value="longhorns"<?php if ($favoriteteam == "longhorns") echo " selected=\"selected\""; ?>>Longhorns</option>
							<option value="mavericks"<?php if ($favoriteteam == "mavericks") echo " selected=\"selected\""; ?>>Mavericks</option>
							<option value="nittanylions"<?php if ($favoriteteam == "nittanylions") echo " selected=\"selected\""; ?>>Nittany Lions</option>
							<option value="panthers1995"<?php if ($favoriteteam == "panthers1995") echo " selected=\"selected\""; ?>>Panthers (1995)</option>
							<option value="penguins"<?php if ($favoriteteam == "penguins") echo " selected=\"selected\""; ?>>Penguins</option>
							<option value="pirates"<?php if ($favoriteteam == "pirates") echo " selected=\"selected\""; ?>>Pirates</option>
							<option value="realmadrid"<?php if ($favoriteteam == "realmadrid") echo " selected=\"selected\""; ?>>Real Madrid</option>
							<option value="redsox"<?php if ($favoriteteam == "redsox") echo " selected=\"selected\""; ?>>Red Sox</option>
							<option value="redstockings"<?php if ($favoriteteam == "redstockings") echo " selected=\"selected\""; ?>>Red Stockings</option>
							<option value="revolution"<?php if ($favoriteteam == "revolution") echo " selected=\"selected\""; ?>>Revolution</option>
							<option value="sabres"<?php if ($favoriteteam == "sabres") echo " selected=\"selected\""; ?>>Sabres</option>
							<option value="seahawks2002"<?php if ($favoriteteam == "seahawks2002") echo " selected=\"selected\""; ?>>Seahawks (2002)</option>
							<option value="stars"<?php if ($favoriteteam == "stars") echo " selected=\"selected\""; ?>>Stars</option>
							<option value="stallions"<?php if ($favoriteteam == "stallions") echo " selected=\"selected\""; ?>>Stallions</option>
							<option value="tigers"<?php if ($favoriteteam == "tigers") echo " selected=\"selected\""; ?>>Tigers</option>
							<option value="tottenham"<?php if ($favoriteteam == "tottenham") echo " selected=\"selected\""; ?>>Tottenham</option>
							<option value="usmnt"<?php if ($favoriteteam == "usmnt") echo " selected=\"selected\""; ?>>USMNT</option>
							<option value="vikings1966"<?php if ($favoriteteam == "vikings1966") echo " selected=\"selected\""; ?>>Vikings (1966)</option>
							<option value="wranglers"<?php if ($favoriteteam == "wranglers") echo " selected=\"selected\""; ?>>Wranglers</option>
							<option value="yankees"<?php if ($favoriteteam == "yankees") echo " selected=\"selected\""; ?>>Yankees</option>
							<option value="<?= $favoriteteam ?>">--------</option>
							<option value="niners"<?php if ($favoriteteam == "niners") echo " selected=\"selected\""; ?>>49ers</option>
							<option value="bears"<?php if ($favoriteteam == "bears") echo " selected=\"selected\""; ?>>Bears</option>
							<option value="bengals"<?php if ($favoriteteam == "bengals") echo " selected=\"selected\""; ?>>Bengals</option>
							<option value="bills"<?php if ($favoriteteam == "bills") echo " selected=\"selected\""; ?>>Bills</option>
							<option value="broncos"<?php if ($favoriteteam == "broncos") echo " selected=\"selected\""; ?>>Broncos</option>
							<option value="browns"<?php if ($favoriteteam == "browns") echo " selected=\"selected\""; ?>>Browns</option>
							<option value="buccaneers"<?php if ($favoriteteam == "buccaneers") echo " selected=\"selected\""; ?>>Buccaneers</option>
							<option value="cardinals"<?php if ($favoriteteam == "cardinals") echo " selected=\"selected\""; ?>>Cardinals</option>
							<option value="chargers"<?php if ($favoriteteam == "chargers") echo " selected=\"selected\""; ?>>Chargers</option>
							<option value="chiefs"<?php if ($favoriteteam == "chiefs") echo " selected=\"selected\""; ?>>Chiefs</option>
							<option value="colts"<?php if ($favoriteteam == "colts") echo " selected=\"selected\""; ?>>Colts</option>
							<option value="cowboys"<?php if ($favoriteteam == "cowboys") echo " selected=\"selected\""; ?>>Cowboys</option>
							<option value="dolphins"<?php if ($favoriteteam == "dolphins") echo " selected=\"selected\""; ?>>Dolphins</option>
							<option value="eagles"<?php if ($favoriteteam == "eagles") echo " selected=\"selected\""; ?>>Eagles</option>
							<option value="falcons"<?php if ($favoriteteam == "falcons") echo " selected=\"selected\""; ?>>Falcons</option>
							<option value="giants"<?php if ($favoriteteam == "giants") echo " selected=\"selected\""; ?>>Giants</option>
							<option value="jaguars"<?php if ($favoriteteam == "jaguars") echo " selected=\"selected\""; ?>>Jaguars</option>
							<option value="jets"<?php if ($favoriteteam == "jets") echo " selected=\"selected\""; ?>>Jets</option>
							<option value="lions"<?php if ($favoriteteam == "lions") echo " selected=\"selected\""; ?>>Lions</option>
							<option value="packers"<?php if ($favoriteteam == "packers") echo " selected=\"selected\""; ?>>Packers</option>
							<option value="panthers"<?php if ($favoriteteam == "panthers") echo " selected=\"selected\""; ?>>Panthers</option>
							<option value="patriots"<?php if ($favoriteteam == "patriots") echo " selected=\"selected\""; ?>>Patriots</option>
							<option value="raiders"<?php if ($favoriteteam == "raiders") echo " selected=\"selected\""; ?>>Raiders</option>
							<option value="rams"<?php if ($favoriteteam == "rams") echo " selected=\"selected\""; ?>>Rams</option>
							<option value="ravens"<?php if ($favoriteteam == "ravens") echo " selected=\"selected\""; ?>>Ravens</option>
							<option value="redskins"<?php if ($favoriteteam == "redskins") echo " selected=\"selected\""; ?>>Redskins</option>
							<option value="saints"<?php if ($favoriteteam == "saints") echo " selected=\"selected\""; ?>>Saints</option>
							<option value="seahawks"<?php if ($favoriteteam == "seahawks") echo " selected=\"selected\""; ?>>Seahawks</option>
							<option value="steelers"<?php if ($favoriteteam == "steelers") echo " selected=\"selected\""; ?>>Steelers</option>
							<option value="texans"<?php if ($favoriteteam == "texans") echo " selected=\"selected\""; ?>>Texans</option>
							<option value="titans"<?php if ($favoriteteam == "titans") echo " selected=\"selected\""; ?>>Titans</option>
							<option value="vikings"<?php if ($favoriteteam == "vikings") echo " selected=\"selected\""; ?>>Vikings</option>
						</select>
					</td>
				</tr>

				<tr>
					<td class="field" valign="top"><label for="st1">Style</label></td>
					<td class="value">
						<select name="style" id="st1">
							<option value="standard"<?php if (($style == "") || ($style == "standard")) { echo " selected=\"selected\""; } ?>>Standard</option>
							<option value="simple"<?php if ($style == "simple") { echo " selected=\"selected\""; } ?>>Simple</option>
						</select>
						<p />
						<input type="checkbox" name="showdate" value="yes" id="st2"<?php if ($showdate == "yes") { echo " checked=\"checked\""; } ?> /> <label for="st2">Show date/time under each game on the Big Board?</label>
					</td>
				</tr>

				<tr>
					<td class="field" valign="top"><label for="pr">Profile</label></td>
					<td class="value">
						<textarea rows="10" cols="60" name="profile" id="pr"><?= $profile ?></textarea>
						<p />
						<input type="submit" class="fancybutton" value="Save Settings" name="submit" />
					</td>
				</tr>
			</table>
		</form>
<?php } else { ?>
		<h3 class="error">You need to be logged in to use this part of the website.</h3>
<?php } ?>
	</body>
</html>
