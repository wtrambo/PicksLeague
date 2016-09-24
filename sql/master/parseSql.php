<?php

	$file = isset($argv[1]) ? $argv[1] : false;
	$season = isset($argv[2]) ? $argv[2] : false;

	if ($file === false || !file_exists($file)) {
		echo "Invalid file.\n";
		echo "Usage: php " . basename(__FILE__) . " <file> <season>\n";
		exit(1);
	}

	if ($season === false || intval($season) < 2003) {
		echo "Invalid season.\n";
		echo "Usage: php " . basename(__FILE__) . " <file> <season>\n";
		exit(1);
	}

	$sqlLines = file($file);

	$users = array();
	$games = array();
	$picks = array();

	$basicObjectPattern = "/\(.*?\)[,;]/";

	foreach ($sqlLines as $lineNum => $line) {
		if (strpos($line, "INSERT INTO `pl_users` VALUES") !== false) {
			//echo "Parsing out users..\n";

			$basicUsers = array();
			preg_match_all($basicObjectPattern, $line, $basicUsers);

			$userPattern = "/\('(.*?)',(" . $season . "),'(.)',(\d\d?),'(.*?)','(.*?)','(.*?)','.*?','(.*?)','.*?','.*?','.*?','.*?','.*?'\)[,;]/";

			foreach ($basicUsers[0] as $userString) {
				$tempUser = array();

				if (preg_match($userPattern, $userString, $tempUser) == 1) {
					array_push($users, $tempUser);
				}
			}

			//print_r($users);
		}
		else if (strpos($line, "INSERT INTO `pl_games` VALUES") !== false) {
			//echo "Parsing out games..\n";

			$basicGames = array();
			preg_match_all($basicObjectPattern, $line, $basicGames);

			$gamePattern = "/\('(.*?)','(.*?)',(" . $season . "),(\d\d?),'(.*?)',(\d\d?|NULL),(\d\d?|NULL),(.*?)\)[,;]/";

			foreach ($basicGames[0] as $gameString) {
				$tempGame = array();

				if (preg_match($gamePattern, $gameString, $tempGame) == 1) {
					array_push($tempGame, md5($tempGame[1] . $tempGame[2] . $tempGame[3] . $tempGame[4]));
					array_push($games, $tempGame);
				}
			}

			//print_r($games);
		}
		else if (strpos($line, "INSERT INTO `pl_picks` VALUES") !== false) {
			//echo "Parsing out picks..\n";

			$basicPicks = array();
			preg_match_all($basicObjectPattern, $line, $basicPicks);

			$pickPattern = "/\('(.*?)','(.*?)','(.*?)',(" . $season . "),(\d\d?),'(.*?)',(\d)\)[,;]/";

			foreach ($basicPicks[0] as $pickString) {
				$tempPick = array();

				if (preg_match($pickPattern, $pickString, $tempPick) == 1) {
					$pickHash = md5($tempPick[2] . $tempPick[3] . $tempPick[4] . $tempPick[5]);

					if (!isset($picks[$pickHash])) {
						$picks[$pickHash] = array();
					}

					array_push($picks[$pickHash], $tempPick);
				}
			}

			//print_r($picks);
		}
	}
?>
DELETE FROM pl_users WHERE season = <?= $season ?>;
DELETE FROM pl_games WHERE season = <?= $season ?>;
DELETE FROM pl_picks WHERE season = <?= $season ?>;
<?php foreach ($users as $user): ?>
INSERT INTO pl_users VALUES('<?= $user[1] ?>', <?= $user[2] ?>, '<?= $user[3] ?>', <?= $user[4] ?>, '<?= $user[5] ?>', '<?= $user[6] ?>', '<?= $user[7] ?>', MD5('aoeu'), '<?= $user[8] ?>', '', '', '', '', '');
<?php endforeach ?>
<?php foreach ($games as $game): ?>
INSERT INTO pl_games VALUES('<?= $game[1] ?>', '<?= $game[2] ?>', <?= $game[3] ?>, <?= $game[4] ?>, '<?= $game[5] ?>', <?= $game[6] ?>, <?= $game[7] ?>, <?= $game[8] ?>);
<?php if (isset($picks[$game[9]])): ?>
<?php foreach ($picks[$game[9]] as $pick): ?>
INSERT INTO pl_picks VALUES('<?= $pick[1] ?>', '<?= $pick[2] ?>', '<?= $pick[3] ?>', <?= $pick[4] ?>, <?= $pick[5] ?>, '<?= $pick[6] ?>', <?= $pick[7] ?>);
<?php endforeach ?>
<?php endif ?>
<?php endforeach ?>
