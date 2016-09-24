SELECT
	spread,
	COUNT(*) AS games,
	AVG(away_score - home_score) AS avg_diff,
	(CASE WHEN ((spread < 0 AND AVG(away_score - home_score) < spread) OR (spread > 0 AND AVG(away_score - home_score) > spread)) THEN 'yes' ELSE 'no' END) AS cover_on_avg

FROM
	pl_games

WHERE
	week > 0 AND
	home_score IS NOT NULL AND
	away_score IS NOT NULL AND
	ROUND(spread) != spread

GROUP BY
	spread;
