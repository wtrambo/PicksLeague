DROP VIEW IF EXISTS pl_home_picks_vw;
CREATE VIEW pl_home_picks_vw AS
	SELECT season, week, home_team, away_team, COUNT(*) AS picks FROM pl_picks WHERE pick = home_team GROUP BY week, season, home_team, away_team;

DROP VIEW IF EXISTS pl_away_picks_vw;
CREATE VIEW pl_away_picks_vw AS
	SELECT season, week, home_team, away_team, COUNT(*) AS picks FROM pl_picks WHERE pick = away_team GROUP BY week, season, home_team, away_team;


DROP VIEW IF EXISTS pl_majority_vw;
CREATE VIEW pl_majority_vw AS

	SELECT
		g.season AS season,
		g.week AS week,
		g.home_team AS home_team,
		g.away_team AS away_team,
		(CASE WHEN h.picks > a.picks THEN g.home_team ELSE (CASE WHEN a.picks > h.picks THEN g.away_team ELSE NULL END) END) AS majority,
		(CASE WHEN h.picks > a.picks THEN h.picks ELSE (CASE WHEN a.picks > h.picks THEN a.picks ELSE NULL END) END) AS maj_picks,
		(CASE WHEN h.picks > a.picks THEN a.picks ELSE (CASE WHEN a.picks > h.picks THEN h.picks ELSE NULL END) END) AS min_picks,
		(CASE WHEN g.home_score IS NULL OR g.away_score IS NULL THEN NULL ELSE (CASE WHEN g.home_score + g.spread > g.away_score THEN g.home_team ELSE (CASE WHEN g.home_score + g.spread < g.away_score THEN g.away_team ELSE 'push' END) END) END) AS winner

	FROM
		pl_games AS g,
		pl_home_picks_vw AS h,
		pl_away_picks_vw AS a

	WHERE
		g.season = h.season AND
		g.season = a.season AND
		g.week = h.week AND
		g.week = a.week AND
		g.home_team = h.home_team AND
		g.home_team = a.home_team AND
		g.away_team = h.away_team AND
		g.away_team = a.away_team;
