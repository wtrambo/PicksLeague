		<form id="loginnav" action="login.php" method="post">
			<input name="currentPage" type="hidden" value="<?= $_SERVER['PHP_SELF'] ?>" />
			<? if (isset($week)) { ?><input id="week" name="week" type="hidden" value="<?= $week ?>" /><? } ?>
			<table id="header">
				<tr>
<? if (isset($_SESSION['username']) && $_SESSION['username'] != "") { ?>
					<td id="welcome">
						Welcome, <b><?= $_SESSION['nickname'] ?></b>!&nbsp;&nbsp;<input type="submit" id="logout" name="signout" value="Sign Out" />
					</td>

					<td id="loginBox" style="visibility: hidden;">
<? } else { ?>
					<td id="loginBox">
<? } ?>
						<table>
							<tr>
								<td id="left">
									<input id="username" name="username" type="text" size="15" value="<?= isset($_COOKIE['lastlogin']) ? htmlspecialchars($_COOKIE['lastlogin']) : '' ?>"<? if (isset($_SESSION['invalidLogin']) && $_SESSION['invalidLogin'] != "") echo " style=\"background-color: rgb(265, 183, 183);\""; ?> /><br />
									<input id="password" name="password" type="password" size="15"<? if (isset($_SESSION['invalidLogin']) && $_SESSION['invalidLogin'] != "") echo " style=\"background-color: rgb(265, 183, 183);\""; ?> />
								</td>
								<td id="center">
									<input id="login" type="submit" value="Sign In" />
								</td>
							</tr>
						</table>
					</td>

					<td id="right">
						<div id="currentTime"><? echo date("l, F j, Y - g:i:sa"); ?></div>
						<div id="links">
<? $currentPage = $_SERVER['PHP_SELF'] ?>
							<a<? if (strpos($currentPage, "bigboard.php") || strpos($currentPage, "index.php")) { ?> class="currentPage"<? } ?> href="bigboard.php">Big Board</a> |
<!--
							<? if (strpos($currentPage, "standings.php")) { ?><b>Standings</b><? } else { ?><a href="standings.php">Standings</a><? } ?> |
-->
							<a href="http://www.vegasinsider.com/nfl/odds/las-vegas/">Live Odds</a> | 
							<a<? if (strpos($currentPage, "messageboard.php")) { ?> class="currentPage"<? } ?> href="messageboard.php">Message Board</a> | 
							<a href="blog.txt">Blog</a> |
							<a href="faq.txt">FAQ</a> |
							<a<? if (strpos($currentPage, "preferences.php")) { ?> class="currentPage"<? } ?> href="preferences.php">Preferences</a>
						</div>
					</td>
				</tr>
			</table>
		</form>
