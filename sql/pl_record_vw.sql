DROP VIEW pl_record_vw;
CREATE VIEW pl_record_vw AS

	SELECT
		user_name,
		display_rank,
		season,
		week,
		SUM(CASE WHEN (push = 0 AND home_score IS NOT NULL AND away_score IS NOT NULL AND ((pick = home_team AND home_score + spread > away_score) OR (pick = away_team AND home_score + spread < away_score))) THEN 1 ELSE 0 END) AS wins,
		SUM(CASE WHEN (push = 0 AND home_score IS NOT NULL AND away_score IS NOT NULL AND ((pick = home_team AND home_score + spread < away_score) OR (pick = away_team AND home_score + spread > away_score) OR (pick IS NULL))) THEN 1 ELSE 0 END) AS losses

	FROM
		pl_user_picks_vw

	GROUP BY
		user_name, week, season;
