		<form id="loginnav" action="login.php" method="post">
			<input name="currentPage" type="hidden" value="<?= $_SERVER['PHP_SELF'] ?>" />
			<?php if (isset($week)) { ?><input id="week" name="week" type="hidden" value="<?= $week ?>" /><?php } ?>
			<table id="header">
				<tr>
<?php if (isset($_SESSION['username']) && $_SESSION['username'] != "") { ?>
					<td id="welcome">
						Welcome, <b><?= $_SESSION['nickname'] ?></b>!&nbsp;&nbsp;<input type="submit" id="logout" name="signout" value="Sign Out" />
					</td>

					<td id="loginBox" style="visibility: hidden;">
<?php } else { ?>
					<td id="loginBox">
<?php } ?>
						<table>
							<tr>
								<td id="left">
									<input id="username" name="username" type="text" size="15" value="<?= isset($_COOKIE['lastlogin']) ? htmlspecialchars($_COOKIE['lastlogin']) : '' ?>"<?php if (isset($_SESSION['invalidLogin']) && $_SESSION['invalidLogin'] != "") echo " style=\"background-color: rgb(265, 183, 183);\""; ?> /><br />
									<input id="password" name="password" type="password" size="15"<?php if (isset($_SESSION['invalidLogin']) && $_SESSION['invalidLogin'] != "") echo " style=\"background-color: rgb(265, 183, 183);\""; ?> />
								</td>
								<td id="center">
									<input id="login" type="submit" value="Sign In" />
								</td>
							</tr>
						</table>
					</td>

					<td id="right">
						<div id="currentTime"><?php echo date("l, F j, Y - g:i:sa"); ?></div>
						<div id="links">
<?php $currentPage = $_SERVER['PHP_SELF'] ?>
							<a<?php if (strpos($currentPage, "bigboard.php") || strpos($currentPage, "index.php")) { ?> class="currentPage"<?php } ?> href="bigboard.php">Big Board</a> |
<!--
							<?php if (strpos($currentPage, "standings.php")) { ?><b>Standings</b><?php } else { ?><a href="standings.php">Standings</a><?php } ?> |
-->
							<a href="http://www.vegasinsider.com/nfl/odds/las-vegas/">Live Odds</a> | 
							<a<?php if (strpos($currentPage, "messageboard.php")) { ?> class="currentPage"<?php } ?> href="messageboard.php">Message Board</a> | 
							<!--<a href="blog.txt">Blog</a> |
							<a href="faq.txt">FAQ</a> |-->
							<a<?php if (strpos($currentPage, "preferences.php")) { ?> class="currentPage"<?php } ?> href="preferences.php">Preferences</a>
						</div>
					</td>
				</tr>
			</table>
		</form>
