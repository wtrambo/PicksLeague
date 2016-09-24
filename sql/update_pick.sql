DROP PROCEDURE IF EXISTS update_pick;

delimiter $

CREATE PROCEDURE update_pick (p_user_name VARCHAR(30), p_home_team VARCHAR(3), p_away_team VARCHAR(3), p_season INTEGER, p_week INTEGER, p_pick VARCHAR(3), p_push TINYINT)
BEGIN
	DECLARE v_count INT;
	SELECT COUNT(*) INTO v_count FROM pl_picks WHERE user_name = p_user_name AND home_team = p_home_team AND away_team = p_away_team AND season = p_season AND week = p_week;

	IF v_count > 0 THEN
		UPDATE pl_picks SET pick = p_pick, push = IFNULL(p_push, push) WHERE user_name = p_user_name AND home_team = p_home_team AND away_team = p_away_team AND season = p_season AND week = p_week;
	ELSE
		INSERT INTO pl_picks VALUES(p_user_name, p_home_team, p_away_team, p_season, p_week, p_pick, IFNULL(p_push, 0));
	END IF;
END$

delimiter ;
