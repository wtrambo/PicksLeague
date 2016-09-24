SELECT
	u.user_name,
	wins.count AS W,
	losses.count AS L,
	homeW.count AS hW,
	homeL.count AS hL,
	awayW.count AS aW,
	awayL.count AS aL,
	favoriteW.count AS favW,
	favoriteL.count AS favL,
	underdogW.count AS dogW,
	underdogL.count AS dogL,
	homefavoriteW.count AS hfavW,
	homefavoriteL.count AS hfavL,
	awayfavoriteW.count AS afavW,
	awayfavoriteL.count AS afavL,
	homeunderdogW.count AS hdogW,
	homeunderdogL.count AS hdogL,
	awayunderdogW.count AS adogW,
	awayunderdogL.count AS adogL

	FROM
		pl_users AS u

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'win' AND pick IS NOT NULL GROUP BY user_name) AS wins
			ON u.user_name = wins.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'loss' AND pick IS NOT NULL GROUP BY user_name) AS losses
			ON u.user_name = losses.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'win' AND pick = home_team AND pick IS NOT NULL GROUP BY user_name) AS homeW
			ON u.user_name = homeW.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'loss' AND pick = home_team AND pick IS NOT NULL GROUP BY user_name) AS homeL
			ON u.user_name = homeL.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'win' AND pick = away_team AND pick IS NOT NULL GROUP BY user_name) AS awayW
			ON u.user_name = awayW.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'loss' AND pick = away_team AND pick IS NOT NULL GROUP BY user_name) AS awayL
			ON u.user_name = awayL.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'win' AND ((pick = home_team AND spread < 0) OR (pick = away_team AND spread > 0)) AND pick IS NOT NULL GROUP BY user_name) AS favoriteW
			ON u.user_name = favoriteW.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'loss' AND ((pick = home_team AND spread < 0) OR (pick = away_team AND spread > 0)) AND pick IS NOT NULL GROUP BY user_name) AS favoriteL
			ON u.user_name = favoriteL.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'win' AND ((pick = home_team AND spread > 0) OR (pick = away_team AND spread < 0)) AND pick IS NOT NULL GROUP BY user_name) AS underdogW
			ON u.user_name = underdogW.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'loss' AND ((pick = home_team AND spread > 0) OR (pick = away_team AND spread < 0)) AND pick IS NOT NULL GROUP BY user_name) underdogL
			ON u.user_name = underdogL.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'win' AND pick = home_team AND spread < 0 AND pick IS NOT NULL GROUP BY user_name) homefavoriteW
			ON u.user_name = homefavoriteW.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'loss' AND pick = home_team AND spread < 0 AND pick IS NOT NULL GROUP BY user_name) homefavoriteL
			ON u.user_name = homefavoriteL.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'win' AND pick = away_team AND spread > 0 AND pick IS NOT NULL GROUP BY user_name) awayfavoriteW
			ON u.user_name = awayfavoriteW.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'loss' AND pick = away_team AND spread > 0 AND pick IS NOT NULL GROUP BY user_name) awayfavoriteL
			ON u.user_name = awayfavoriteL.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'win' AND pick = home_team AND spread > 0 AND pick IS NOT NULL GROUP BY user_name) homeunderdogW
			ON u.user_name = homeunderdogW.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'loss' AND pick = home_team AND spread > 0 AND pick IS NOT NULL GROUP BY user_name) homeunderdogL
			ON u.user_name = homeunderdogL.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'win' AND pick = away_team AND spread < 0 AND pick IS NOT NULL GROUP BY user_name) awayunderdogW
			ON u.user_name = awayunderdogW.user_name

		LEFT OUTER JOIN
		(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE week != 0 AND season = 2006 AND result = 'loss' AND pick = away_team AND spread < 0 AND pick IS NOT NULL GROUP BY user_name) awayunderdogL
			ON u.user_name = awayunderdogL.user_name

		WHERE u.user_name NOT IN ('dnims', 'dwaldo', 'psoung');
