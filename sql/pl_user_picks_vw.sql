DROP VIEW pl_user_picks_vw;
CREATE VIEW pl_user_picks_vw AS SELECT u.user_name AS user_name,
u.display_rank AS display_rank,
g.season AS season,
g.week AS week,
g.start_time AS start_time,
g.home_team AS home_team,
g.away_team AS away_team,
g.home_score AS home_score,
g.away_score AS away_score,
g.spread AS spread,
p.pick AS pick,
(CASE WHEN p.push IS NULL THEN 0 ELSE p.push END) AS push FROM pl_users AS u JOIN pl_games AS g ON u.season = g.season LEFT OUTER JOIN pl_picks AS p ON u.user_name = p.user_name AND u.season = p.season AND g.season = p.season AND g.week = p.week AND g.home_team = p.home_team AND g.away_team = p.away_team;
