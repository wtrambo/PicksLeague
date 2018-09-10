<?php
    session_start();
    include("config.php");
    include("connect.php");
    include("misc.php");
    include("style.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
        <head>
                <link href="<?= $style ?>.css" rel="stylesheet" type="text/css" />
                <title>View Profile</title>
        </head>

        <body>
<?php if ($_SESSION['username']) { 
        // include('header.php');
    $_GET['nick_name'] = trim($_GET['nick_name'], "'");

        $query = "SELECT first_name, last_name, nick_name, favorite_team, email, phone, location, profile " .
                 "FROM   pl_users " .
                 "WHERE  nick_name = '" . $_GET['nick_name'] . "' " .
         "AND season = " . $season;
        $results = mysqli_query($link, $query) or die(mysqli_error($link));

        if ($row = mysqli_fetch_assoc($results)) {
                echo "\t\t<h1>" . $row['first_name'] . " " . $row['last_name'] . "</h1>\n";
                echo "\t\t<table class=\"fancyTable\" cellspacing=\"0\">\n";

        if ($row['location']) {
            echo "\t\t\t<tr class=\"top\">\n";
            echo "\t\t\t\t<td class=\"field\">Location</td>\n";
                   echo "\t\t\t\t<td class=\"value\">" . $row['location'] . "</td>\n";
            echo "\t\t\t</tr>\n";
        }

        if ($row['favorite_team']) {
            $team = $row['favorite_team'];
            echo "\t\t\t<tr>\n";
            echo "\t\t\t\t<td class=\"field\">Favorite Team</td>\n";
            echo "\t\t\t\t<td class=\"value\">" . $teamsarray2[$team] . "</td>\n";
                    echo "\t\t\t</tr>\n";
        }
        
        if ($row['email']) {
                    echo "\t\t\t<tr>\n";
                    echo "\t\t\t\t<td class=\"field\">Email</td>\n";
                    echo "\t\t\t\t<td class=\"value\"><a href=\"mailto:" . cleanText($row['email']) . "\">" . cleanText($row['email']) . "</a></td>\n";
                    echo "\t\t\t</tr>\n";
        }
        
        if ($row['phone']) {
            $areacode = substr($row['phone'],0,3);
            $prefix = substr($row['phone'],3,3);
            $suffix = substr($row['phone'],6,4);
            $phone = "(" . $areacode . ") " . $prefix . "-" . $suffix;
            echo "\t\t\t<tr>\n";
            echo "\t\t\t\t<td class=\"field\">Phone</td>\n";
            echo "\t\t\t\t<td class=\"value\">" . $phone . "</td>\n";
                    echo "\t\t\t</tr>\n";
        }

        if ($row['profile']) {
                    echo "\t\t\t<tr>\n";
                    echo "\t\t\t\t<td class=\"field\">Profile</td>\n";
                    echo "\t\t\t\t<td class=\"value\">" . cleanText($row['profile']) . "</td>\n";
                    echo "\t\t\t</tr>\n";
        };
    echo "</table>";
     }
    } else { ?>
        <h3 class="error">You need to be logged in to use this part of the website.</h3>
<?php } ?>
        
    </body>
</html>

