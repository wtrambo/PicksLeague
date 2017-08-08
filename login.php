<?php
	session_start();
	include("config.php");
	include("connect.php");
	include("misc.php");

	setcookie("lastlogin", htmlspecialchars($_POST['username']), $cookieExpirationTime);

	if (isset($_POST['signout'])) {
		$_SESSION['username'] = "";
		$_SESSION['password'] = "";
		$_SESSION['nickname'] = "";
		$_SESSION['timezone'] = "";
		$_SESSION['privilege'] = "";
		$_SESSION['invalidLogin'] = false;

		header("Location: /bigboard.php");
	}
	else if ($_POST['username']) {
		$_POST['username'] = trim($_POST['username'], "'");
		$query = "SELECT user_name, password, nick_name, timezone, privilege FROM pl_users WHERE user_name = '" . $_POST['username'] . "' AND password = MD5('" . $_POST['password'] . "') AND season = " . $season;
		$result = mysqli_query($link, $query) or die(mysqli_error($link));

		if ($row = mysqli_fetch_assoc($result)) {
			$_SESSION['username'] = $row['user_name'];
			$_SESSION['password'] = $row['password'];
			$_SESSION['nickname'] = $row['nick_name'];
			setcookie("timezone", $row['timezone'], $cookieExpirationTime);
			$_SESSION['privilege'] = $row['privilege'];
			$_SESSION['invalidLogin'] = false;
		}
		else {
			$_SESSION['invalidLogin'] = true;
		}

		header("Location: " . $_POST['currentPage']);
	}


?>
