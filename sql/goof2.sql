SELECT
	a.short_name,
	COUNT(*) AS covers
FROM
	pl_teams AS a,
	(SELECT (CASE WHEN home_score + spread > away_score THEN home_team ELSE away_team END) AS winner FROM pl_games WHERE season = 2006 AND week > 0 AND week <= 3) AS b

WHERE
	a.short_name = b.winner

GROUP BY
	a.short_name

ORDER BY
	covers;
