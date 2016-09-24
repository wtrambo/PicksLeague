DELIMITER ;;
CREATE PROCEDURE `update_game`(p_home_team VARCHAR(3), p_away_team VARCHAR(3), p_season INTEGER, p_week INTEGER, p_start_time DATETIME, p_home_score INTEGER, p_away_score INTEGER, p_spread DOUBLE)
BEGIN
	DECLARE v_count INT;
	SELECT COUNT(*) INTO v_count FROM pl_games WHERE home_team = p_home_team AND away_team = p_away_team AND season = p_season AND week = p_week;

	IF p_home_team <> '' AND p_away_team <> '' THEN
		IF v_count > 0 THEN
			UPDATE pl_games SET start_time = IFNULL(p_start_time, start_time), home_score = IF(p_home_score IS NULL, home_score, p_home_score), away_score = IF(p_away_score IS NULL, away_score, p_away_score), spread = IF(spread IS NOT NULL, spread, IFNULL(p_spread, spread)) WHERE home_team = p_home_team AND away_team = p_away_team AND season = p_season AND week = p_week;
		ELSE
			INSERT INTO pl_games VALUES(p_home_team, p_away_team, p_season, p_week, p_start_time, p_home_score, p_away_score, p_spread);
		END IF;
	END IF;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE PROCEDURE `update_pick`(p_user_name VARCHAR(30), p_home_team VARCHAR(3), p_away_team VARCHAR(3), p_season INTEGER, p_week INTEGER, p_pick VARCHAR(3), p_push TINYINT)
BEGIN
	DECLARE v_count INT;
	SELECT COUNT(*) INTO v_count FROM pl_picks WHERE user_name = p_user_name AND home_team = p_home_team AND away_team = p_away_team AND season = p_season AND week = p_week;

	IF v_count > 0 THEN
		UPDATE pl_picks SET pick = p_pick, push = IFNULL(p_push, push) WHERE user_name = p_user_name AND home_team = p_home_team AND away_team = p_away_team AND season = p_season AND week = p_week;
	ELSE
		INSERT INTO pl_picks VALUES(p_user_name, p_home_team, p_away_team, p_season, p_week, p_pick, IFNULL(p_push, 0));
	END IF;
END ;;
DELIMITER ;
