SELECT
	season,
	COUNT(*) AS wins,
	(CASE WHEN season = 2003 THEN 245 ELSE (CASE WHEN season = 2004 THEN 256 ELSE (CASE WHEN season = 2006 THEN 256 ELSE (CASE WHEN season = 2007 THEN 48 ELSE 0 END) END) END) END) AS games

FROM
	pl_games

WHERE
	((home_score > away_score AND home_score + spread > away_score) OR
		(home_score < away_score AND home_score + spread < away_score)) AND
	week > 0

GROUP BY
	season;
