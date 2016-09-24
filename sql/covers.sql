SELECT
	a.short_name,
	COUNT(*) AS covers
FROM
	pl_teams AS a,
	(SELECT season, (CASE WHEN home_score + spread > away_score THEN home_team ELSE away_team END) AS winner FROM pl_games WHERE week > 0 AND week <= 17 AND home_score IS NOT NULL AND away_score IS NOT NULL) AS b

WHERE
	a.short_name = b.winner

GROUP BY
	a.short_name

ORDER BY
	a.short_name;
