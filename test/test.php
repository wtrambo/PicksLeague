<?
	if (isset($_REQUEST['submit'])) {
		$type = $_FILES['image']['type'];

		if ($type == "image/gif") {
			$ext = ".gif";
		}
		else if ($type == "image/jpeg") {
			$ext = ".jpg";
		}
		else if ($type == "image/png") {
			$ext = ".png";
		}

		echo $_FILES['image']['tmp_name'] . "<br />\n";
		echo "/usr/home/jpnance/public_html/picks/test/aoeu" . $ext . "<p />\n";
		copy($_FILES['image']['tmp_name'], "/home/jpnance/public_html/picks/test/aoeu" . $ext);
		echo "<img src=\"aoeu" . $ext . "\" />\n";
	}
	else {
?>
<html>
	<head>
	</head>
	<body>
		<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
			<input type="file" name="image" />
			<p />
			<input type="submit" name="submit" value="Upload" />
		</form>
<?
	}
?>
	</body>
</html>
