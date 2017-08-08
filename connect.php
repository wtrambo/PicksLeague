<?php
	$link = mysqli_connect($mysql_host, $mysql_login, $mysql_password) or die('Could not connect: ' . mysqli_error($link));
	mysqli_select_db($link, $mysql_database) or die('Could not select database: ' . mysqli_error($link));
?>
