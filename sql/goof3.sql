SELECT
	COUNT(*) AS wins

FROM
	pl_user_picks_vw

WHERE
	pick IS NOT NULL AND
	((pick = home_team AND home_score + spread > away_score) OR
		(pick = away_team AND home_score + spread < away_score)) AND 
	season = 2007 AND
	week > 0;
SELECT
	COUNT(*) AS losses

FROM
	pl_user_picks_vw

WHERE
	pick IS NOT NULL AND
	((pick = home_team AND home_score + spread < away_score) OR
		(pick = away_team AND home_score + spread > away_score)) AND 
	season = 2007 AND
	week > 0;
