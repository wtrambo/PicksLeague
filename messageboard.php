<?
	session_start();
	include("config.php");
	include("connect.php");
	include("misc.php");
	include("timezone.php");
	include("style.php");

	$result = mysql_query("SELECT COUNT(*) FROM pl_messages WHERE season = " . $season);
	$row = mysql_fetch_row($result);
	$maxpage = ceil($row[0] / 20);
	$pagerange = 4;

	if (!isset($_GET['page']) || !is_numeric($_GET['page']) || ($_GET['page'] < 1) || ($_GET['page'] > $maxpage)) {
		$page = $maxpage;
	}
	else {
		$page = $_GET['page'];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Message Board &laquo; The Picks League &laquo; Coinflipper</title>
		<link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico" />
		<link href="<?= $style ?>.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="misc.js"></script>
	</head>

	<body>
<?  include("header.php"); ?>
		<h1>Message Board</h1>
<? if ($_SESSION['username']) { ?>
		<p />

		<input id="submit" type="button" onclick="toggleVisibility(document.getElementById('postmessage')); toggleVisibility(document.getElementById('submit')); document.getElementById('message').focus();" value="Post Message" />
		<p />

		<form action="postmessage.php" method="post">
			<table id="postmessage" class="fancyTable" cellspacing="0" style="display: none">
				<tr class="top">
					<td class="field">Message</td>
					<td class="value">
						<textarea name="message" id="message" rows="6" cols="40"></textarea><br />
						<br />
						<input type="submit" class="fancybutton" name="submit" value="Post Message"> <input type="reset" class="fancybutton" name="cancel" value="Cancel" onClick="toggleVisibility(document.getElementById('postmessage')); toggleVisibility(document.getElementById('submit'))" /><br />
					</td>
				</tr>
			</table>
		</form>

<?
	include("history.php");
?>

<?
	$query =
		"SELECT nick_name, time, message ".
		"FROM   pl_users u ".
		"INNER  JOIN pl_messages m ".
		"ON     u.user_name = m.user_name ".
		"WHERE  u.season = m.season ".
		"AND m.season = " . $season . " " .
		"ORDER  BY message_id DESC ".
		"LIMIT  " . (($maxpage - $page) * 20) . ", 20";
	
	$result = mysql_query($query) or die(mysql_error());
?>
		<div class="messageContainer">
			<table cellspacing="0" cellpadding="4" width="100%">
<?
	$top = true;
	while ($row = mysql_fetch_assoc($result)) {
		$row['message'] = cleanText($row['message']);

?>
				<tr class="messageHeader<? if ($top) { echo " top"; $top = false; } ?>">
					<td class="messageLeft" width="20%">
						<div class="messageUser" onclick="viewProfile('<?= $row['nick_name'] ?>')"><?= $row['nick_name'] ?></div>
						<div class="messageDate"><?= date("F j, Y", strtotime($row['time'] . " UTC")) ?><br /><?= date("g:ia", strtotime($row['time'] . " UTC")) ?></div>
					</td>
					<td class="messageRight" width="80%">
						<div class="messageText"><?= $row['message'] ?></div>
					</td>
				</tr>
<?
	}
?>
			</table>
		</div>
<?
	include("history.php");
?>
<? } else { ?>
		<h3 class="error">You need to be logged in to use this part of the website.</h3>
<? } ?>
	</body>
</html>
