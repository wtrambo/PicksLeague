<?php
	session_start();
	include("config.php");
	include("connect.php");
	include("misc.php");
	include("timezone.php");

	if ($_POST['submit']) {
		if ($_SESSION['username'] && $_POST['message']) {
			$message = mysqli_real_escape_string($link, $_POST['message']);
			$timestamp = gmdate("Y-m-d H:i:s", strtotime('now'));
			$query =
				"INSERT INTO pl_messages VALUES ( ".
				"	DEFAULT, ".
				"	'" . $_SESSION['username'] . "', ".
				"	" . $season . ", ".
				"	'" . $timestamp . "', ".
				"	'" . $message . "' ".
				")";
			mysqli_query($link, $query) or die(mysqli_error($link));

		}
		else {
			$_SESSION['tempmessage'] = $message;
		}

		header("Location: /messageboard.php");
	}
?>
