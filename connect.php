<?php
	$link = mysql_connect("$mysql_host", "$mysql_login", "$mysql_password") or die('Could not connect: ' . mysql_error());
	mysql_select_db("$mysql_database") or die('Could not select database: ' . mysql_error());
?>
