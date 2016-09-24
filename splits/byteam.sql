SELECT u.user_name, ARI_W.count AS ARI_W, ARI_L.count AS ARI_L
FROM
	pl_users AS u

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE (home_team = 'ARI' OR away_team = 'ARI') AND week != 0 AND pick IS NOT NULL AND result = 'win' GROUP BY user_name) AS ARI_W
	ON u.user_name = ARI_W.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE (home_team = 'ARI' OR away_team = 'ARI') AND week != 0 AND pick IS NOT NULL AND result = 'loss' GROUP BY user_name) AS ARI_L
	ON ARI_W.user_name = ARI_L.user_name;
