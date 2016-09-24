			<div class="messageHistory">
<?
	if ($page != $maxpage) {
		echo "\t\t\t\t<a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . $maxpage . "\">&laquo;</a>\n";
		echo "\t\t\t\t<a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . ($page + 1) . "\">&lsaquo;</a>\n";
	}

	for ($i = min($page + $pagerange, $maxpage); $i >= max($page - $pagerange, 1); $i--) {
		if ($i == $page) {
			echo "\t\t\t\t<a class=\"currentPage\" href=\"" . $_SERVER['PHP_SELF'] . "?page=" . $i . "\">" . $i . "</a>\n";
		}
		else {
			echo "\t\t\t\t<a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . $i . "\">" . $i . "</a>\n";
		}
	}

	if ($page != 1) {
		echo "\t\t\t\t<a href=\"" . $_SERVER['PHP_SELF'] . "?page=" . ($page - 1) . "\">&rsaquo;</a>\n";
		echo "\t\t\t\t<a href=\"" . $_SERVER['PHP_SELF'] . "?page=1\">&raquo;</a>\n";
	}
?>
			</div>
