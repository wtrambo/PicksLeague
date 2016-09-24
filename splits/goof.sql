SELECT
	t.short_name,
	COUNT(*) AS covers

	FROM
		pl_teams AS t,
		pl_games AS g

	WHERE
		g.home_score IS NOT NULL
		AND g.away_score IS NOT NULL
		AND ((t.short_name = g.home_team AND g.home_score + g.spread > g.away_score)
			OR (t.short_name = g.away_team AND g.home_score + g.spread < g.away_score))
		AND week != 0

	GROUP BY t.short_name;
