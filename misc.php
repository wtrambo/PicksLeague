<?php
	$season = 2016;
	$cookieExpirationTime = strtotime("January 31, 2017");

	$teamsarray = Array(
		'Arizona'	=> 'ARI',	'ARI'	=> 'Arizona',
		'Atlanta'	=> 'ATL',	'ATL'	=> 'Atlanta',
		'Baltimore'	=> 'BAL',	'BAL'	=> 'Baltimore',
		'Buffalo'	=> 'BUF',	'BUF'	=> 'Buffalo',
		'Carolina'	=> 'CAR',	'CAR'	=> 'Carolina',
		'Chicago'	=> 'CHI',	'CHI'	=> 'Chicago',
		'Cincinnati'	=> 'CIN',	'CIN'	=> 'Cincinnati',
		'Cleveland'	=> 'CLE',	'CLE'	=> 'Cleveland',
		'Dallas'	=> 'DAL',	'DAL'	=> 'Dallas',
		'Denver'	=> 'DEN',	'DEN'	=> 'Denver',
		'Detroit'	=> 'DET',	'DET'	=> 'Detroit',
		'Green Bay'	=> 'GB',	'GB'	=> 'Green Bay' ,
		'Houston'	=> 'HOU',	'HOU'	=> 'Houston',
		'Indianapolis'	=> 'IND',	'IND'	=> 'Indianapolis',
		'Jacksonville'	=> 'JAX',	'JAX'	=> 'Jacksonville',
		'Kansas City'	=> 'KC',	'KC'	=> 'Kansas City' ,
		'Los Angeles'	=> 'LA',	'LA'	=> 'Los Angeles' ,
		'Miami'		=> 'MIA',	'MIA'	=> 'Miami',
		'Minnesota'	=> 'MIN',	'MIN'	=> 'Minnesota',
		'New England'	=> 'NE',	'NE'	=> 'New England',
		'New Orleans'	=> 'NO',	'NO'	=> 'New Orleans',
		'N.Y. Giants'	=> 'NYG',
		'NY Giants'	=> 'NYG',	'NYG'	=> 'NY Giants',
		'N.Y. Jets'	=> 'NYJ',
		'NY Jets'	=> 'NYJ',	'NYJ'	=> 'NY Jets',
		'Oakland'	=> 'OAK',	'OAK'	=> 'Oakland',
		'Philadelphia'	=> 'PHI',	'PHI'	=> 'Philadelphia',
		'Pittsburgh'	=> 'PIT',	'PIT'	=> 'Pittsburgh',
		'San Diego'	=> 'SD',	'SD'	=> 'San Diego',
		'San Francisco'	=> 'SF',	'SF'	=> 'San Francisco',
		'Seattle'	=> 'SEA',	'SEA'	=> 'Seattle',
		'St. Louis'	=> 'STL',	'STL'	=> 'St. Louis',
		'Tampa Bay'	=> 'TB',	'TB'	=> 'Tampa Bay' ,
		'Tennessee'	=> 'TEN',	'TEN'	=> 'Tennessee',
		'Washington'	=> 'WAS',	'WAS'	=> 'Washington',	'WSH' => 'Washington'
	);

	$teamsarray2 = Array(
		'h1836'			=> 'Houston 1836',
		'aggies'		=> 'Cal-Davis Aggies',
		'ajax'			=> 'Ajax Football Club',
		'arsenal'		=> 'Arsenal Football Club',
		'avfc'			=> 'Aston Villa Football Club',
		'blues'			=> 'St. Louis Blues',
		'buccaneers1976'	=> 'Tampa Bay Buccaneers (1976)',
		'buckeyes'		=> 'Ohio State Buckeyes',
		'cardiffcity'		=> 'Cardiff City Football Club',
		'cardinal'		=> 'Stanford Cardinal',
		'chargers2002'		=> 'San Diego Chargers (2002)',
		'chelsea'		=> 'Chelsea Football Club',
		'cibaenas'		=> 'Águilas Cibaeñas Baseball Club',
		'colt45s'		=> 'Houston Colt .45s',
		'crusaders'		=> 'Crusaders',
		'ct'			=> 'Chinese Taipei Baseball',
		'diamondjaxx'		=> 'Pierce County Diamond Jaxx',
		'dolphins1997'		=> 'Miami Dolphins (1997)',
		'ecb'			=> 'England Cricket',
		'everton'		=> 'Everton Football Club',
		'flyingtigers'		=> 'Lakeland Flying Tigers',
		'hokies'		=> 'Virginia Tech Hokies',
		'jaguars1995'		=> 'Jacksonville Jaguars (1995)',
		'lions2003'		=> 'Detroit Lions (2003)',
		'longhorns'		=> 'Texas Longhorns',
		'mavericks'		=> 'Dallas Mavericks',
		'nittanylions'		=> 'Penn State Nittany Lions',
		'panthers'		=> 'Carolina Panthers (1995)',
		'penguins'		=> 'Pittsburgh Penguins',
		'pirates'		=> 'Pittsburgh Pirates',
		'realmadrid'		=> 'Real Madrid Club de Fútbol',
		'redsox'		=> 'Boston Red Sox',
		'redstockings'		=> 'Cincinnati Red Stockings',
		'revolution'		=> 'New England Revolution',
		'sabres'		=> 'Buffalo Sabres',
		'seahawks2002'		=> 'Seattle Seahawks (2002)',
		'stars'			=> 'Dallas Stars',
		'stallions'		=> 'Buffalo Stallions',
		'tigers'		=> 'LSU Tigers',
		'tottenham'		=> 'Tottenham Hotspur Football Club',
		'usmnt'			=> 'U.S. Soccer',
		'vikings1966'		=> 'Minnesota Vikings (1966)',
		'wranglers'		=> 'Austin Wranglers',
		'yankees'		=> 'New York Yankees',

		'niners'		=> 'San Francisco 49ers',
		'bears'			=> 'Chicago Bears',
		'bengals'		=> 'Cincinnati Bengals',
		'bills'			=> 'Buffalo Bills',
		'broncos'		=> 'Denver Broncos',
		'browns'		=> 'Cleveland Browns',
		'buccaneers'		=> 'Tampa Bay Buccaneers',
		'cardinals'		=> 'Arizona Cardinals',
		'chargers'		=> 'San Diego Chargers',
		'chiefs'		=> 'Kansas City Chiefs',
		'colts'			=> 'Indianapolis Colts',
		'cowboys'		=> 'Dallas Cowboys',
		'dolphins'		=> 'Miami Dolphins',
		'eagles'		=> 'Philadelphia Eagles',
		'falcons'		=> 'Atlanta Falcons',
		'giants'		=> 'New York Giants',
		'jaguars'		=> 'Jacksonville Jaguars',
		'jets'			=> 'New York Jets',
		'lions'			=> 'Detroit Lions',
		'packers'		=> 'Green Bay Packers',
		'panthers'		=> 'Carolina Panthers',
		'patriots'		=> 'New England Patriots',
		'raiders'		=> 'Oakland Raiders',
		'rams'			=> 'Los Angeles Rams',
		'ravens'		=> 'Baltimore Ravens',
		'redskins'		=> 'Washington Redskins',	
		'saints'		=> 'New Orleans Saints',
		'seahawks'		=> 'Seattle Seahawks',
		'steelers'		=> 'Pittsburgh Steelers',
		'texans'		=> 'Houston Texans',
		'titans'		=> 'Tennessee Titans',
		'vikings'		=> 'Minnesota Vikings',
	);
  
	function spaceify($name) {
		$str = "";
		for ($i = 0; $i < strlen($name) - 1; $i++) {
			$str .= $name[$i] . "<br>";
		}
	$str .= $name[strlen($name) - 1];

		return $str;
	}

	function cleanText($text) {
		$text = str_replace("<", "&lt;", $text);
		$text = str_replace(">", "&gt;", $text);
		$text = preg_replace("/\r\n(\r\n)+/", "<p />", $text);
		$text = str_replace("\r\n", "<br />", $text);
		$text = preg_replace("/(\[b\])(.*?)(\[\/b\])/i", "<b>\\2</b>", $text);
		$text = preg_replace("/(\[u\])(.*?)(\[\/u\])/i", "<u>\\2</u>", $text);
		$text = preg_replace("/(\[i\])(.*?)(\[\/i\])/i", "<i>\\2</i>", $text);
		$text = preg_replace("/(\[strike\])(.*?)(\[\/strike\])/i", "<strike>\\2</strike>", $text);
		$text = preg_replace("/(\[url\])(.*?)(\[\/url\])/i", "<a href=\"\\2\">\\2</a>", $text);
		$text = preg_replace("/(\[url )(.*?)(\])(.*?)(\[\/url\])/i", "<a href=\"\\2\">\\4</a>", $text);
		$text = preg_replace("/(\[url=)(.*?)(\])(.*?)(\[\/url\])/i", "<a href=\"\\2\">\\4</a>", $text);
		return $text;
	}

	function restoreText($text) {
		$text = str_replace("<p />","\r\n\r\n",$text);
		$text = str_replace("<br />","\r\n",$text);
		$text = preg_replace("/(\<b\>)(.*)(\<\/b\>)/", "[b]\\2[/b]", $text);
		$text = preg_replace("/(\<u\>)(.*)(\<\/u\>)/", "[u]\\2[/u]", $text);
		$text = preg_replace("/(\<i\>)(.*)(\<\/i\>)/", "[i]\\2[/i]", $text);
		$text = preg_replace("/(\<strike\>)(.*)(\<\/strike\>)/", "[strike]\\2[/strike]", $text);
		$text = preg_replace("/(\<a href=\")(.*)(\"\>)(.*)(\<\/a\>)/", "[url \\2]\\4[/url]", $text);
		return $text;
	}
?>
