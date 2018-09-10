<?php

    include(realpath(__DIR__ . '/../') . '/config.php');
    include(realpath(__DIR__ . '/../') . '/connect.php');
    include(realpath(__DIR__ . '/../') . '/misc.php');
    include(realpath(__DIR__ . '/../') . '/getweek.php');

    date_default_timezone_set("US/Eastern");

    // prevent caching
    header('Cache-Control: no-cache');

    $scores = json_decode(file_get_contents('http://www.nfl.com/liveupdate/scores/scores.json'));
    $dates = array_keys((array) $scores);

    foreach ($dates as $date) {
        $game = $scores->{$date};
        $week = getweek(strtotime(substr($date, 0, 8)));

        if ($game->qtr != 'Final') {
            continue;
        }

        $awayTeam = normalizeAbbreviation($game->away->abbr);
        $awayScore = $game->away->score->T;
        $homeTeam = normalizeAbbreviation($game->home->abbr);
        $homeScore = $game->home->score->T;

        $query = "CALL update_game('" . $homeTeam . "', '" . $awayTeam . "', " . $season . ", " . $week . ", NULL, " . $homeScore . ", " . $awayScore . ", NULL);";

        if ($argc > 1 && $argv[1] == 'update') {
            mysqli_query($link, $query);
        }
        else {
            echo $query . "\n"; 
        }
    }
?>
