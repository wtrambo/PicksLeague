<?
	if (isset($_COOKIE['style']) && $_COOKIE['style'] == "simple") {
		$style = $_COOKIE['style'];
	}
	else {
		$style = "standard";
	}

	if (isset($_COOKIE['showdate']) && $_COOKIE['showdate'] == "yes") {
		$showdate = "yes";
	}
	else {
		$showdate = "no";
	}
?>
