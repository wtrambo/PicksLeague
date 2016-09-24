SELECT
	u.user_name,
	nsevenw.count AS nsevenW,
	nsevenl.count AS nsevenL,
	nsixw.count AS nsixW,
	nsixl.count AS nsixL,
	nfivew.count AS nfiveW,
	nfivel.count AS nfiveL,
	nfourw.count AS nfourW,
	nfourl.count AS nfourL,
	nthreew.count AS nthreeW,
	nthreel.count AS nthreeL,
	ntwow.count AS ntwoW,
	ntwol.count AS ntwoL,
	nonew.count AS noneW,
	nonel.count AS noneL,
	nzerow.count AS nzeroW,
	nzerol.count AS nzeroL,
	pzerow.count AS pzeroW,
	pzerol.count AS pzeroL,
	ponew.count AS poneW,
	ponel.count AS poneL,
	ptwow.count AS ptwoW,
	ptwol.count AS ptwoL,
	pthreew.count AS pthreeW,
	pthreel.count AS pthreeL,
	pfourw.count AS pfourW,
	pfourl.count AS pfourL,
	pfivew.count AS pfiveW,
	pfivel.count AS pfiveL,
	psixw.count AS psixW,
	psixl.count AS psixL,
	psevenw.count AS psevenW,
	psevenl.count AS psevenL

FROM
	pl_users AS u

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread <= -7.5 AND result = 'win' AND week != 0 AND season = 2007 GROUP BY user_name) AS nsevenw
	ON u.user_name = nsevenw.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread <= -7.5 AND result = 'loss' AND pick IS NOT NULL AND week != 0 AND season = 2007 GROUP BY user_name) AS nsevenl
	ON nsevenw.user_name = nsevenl.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = -6.5 AND result = 'win' AND week != 0 AND season = 2007 GROUP BY user_name) AS nsixw
	ON u.user_name = nsixw.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = -6.5 AND result = 'loss' AND pick IS NOT NULL AND week != 0 AND season = 2007 GROUP BY user_name) AS nsixl
	ON nsixw.user_name = nsixl.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = -5.5 AND result = 'win' AND week != 0 AND season = 2007 GROUP BY user_name) AS nfivew
	ON u.user_name = nfivew.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = -5.5 AND result = 'loss' AND pick IS NOT NULL AND week != 0 AND season = 2007 GROUP BY user_name) AS nfivel
	ON nfivew.user_name = nfivel.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = -4.5 AND result = 'win' AND week != 0 AND season = 2007 GROUP BY user_name) AS nfourw
	ON u.user_name = nfourw.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = -4.5 AND result = 'loss' AND pick IS NOT NULL AND week != 0 AND season = 2007 GROUP BY user_name) AS nfourl
	ON nfourw.user_name = nfourl.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = -3.5 AND result = 'win' AND week != 0 AND season = 2007 GROUP BY user_name) AS nthreew
	ON u.user_name = nthreew.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = -3.5 AND result = 'loss' AND pick IS NOT NULL AND week != 0 AND season = 2007 GROUP BY user_name) AS nthreel
	ON nthreew.user_name = nthreel.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = -2.5 AND result = 'win' AND week != 0 AND season = 2007 GROUP BY user_name) AS ntwow
	ON u.user_name = ntwow.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = -2.5 AND result = 'loss' AND pick IS NOT NULL AND week != 0 AND season = 2007 GROUP BY user_name) AS ntwol
	ON ntwow.user_name = ntwol.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = -1.5 AND result = 'win' AND week != 0 AND season = 2007 GROUP BY user_name) AS nonew
	ON u.user_name = nonew.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = -1.5 AND result = 'loss' AND pick IS NOT NULL AND week != 0 AND season = 2007 GROUP BY user_name) AS nonel
	ON nonew.user_name = nonel.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = -0.5 AND result = 'win' AND week != 0 AND season = 2007 GROUP BY user_name) AS nzerow
	ON ntwol.user_name = nzerow.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = -0.5 AND result = 'loss' AND pick IS NOT NULL AND week != 0 AND season = 2007 GROUP BY user_name) AS nzerol
	ON nzerow.user_name = nzerol.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = 0.5 AND result = 'win' AND week != 0 AND season = 2007 GROUP BY user_name) AS pzerow
	ON nzerol.user_name = pzerow.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = 0.5 AND result = 'loss' AND pick IS NOT NULL AND week != 0 AND season = 2007 GROUP BY user_name) AS pzerol
	ON pzerow.user_name = pzerol.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = 1.5 AND result = 'win' AND week != 0 AND season = 2007 GROUP BY user_name) AS ponew
	ON pzerol.user_name = ponew.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = 1.5 AND result = 'loss' AND pick IS NOT NULL AND week != 0 AND season = 2007 GROUP BY user_name) AS ponel
	ON ponew.user_name = ponel.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = 2.5 AND result = 'win' AND week != 0 AND season = 2007 GROUP BY user_name) AS ptwow
	ON pzerol.user_name = ptwow.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = 2.5 AND result = 'loss' AND pick IS NOT NULL AND week != 0 AND season = 2007 GROUP BY user_name) AS ptwol
	ON ptwow.user_name = ptwol.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = 3.5 AND result = 'win' AND week != 0 AND season = 2007 GROUP BY user_name) AS pthreew
	ON pzerol.user_name = pthreew.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = 3.5 AND result = 'loss' AND pick IS NOT NULL AND week != 0 AND season = 2007 GROUP BY user_name) AS pthreel
	ON pthreew.user_name = pthreel.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = 4.5 AND result = 'win' AND week != 0 AND season = 2007 GROUP BY user_name) AS pfourw
	ON pzerol.user_name = pfourw.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = 4.5 AND result = 'loss' AND pick IS NOT NULL AND week != 0 AND season = 2007 GROUP BY user_name) AS pfourl
	ON pfourw.user_name = pfourl.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = 5.5 AND result = 'win' AND week != 0 AND season = 2007 GROUP BY user_name) AS pfivew
	ON pzerol.user_name = pfivew.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = 5.5 AND result = 'loss' AND pick IS NOT NULL AND week != 0 AND season = 2007 GROUP BY user_name) AS pfivel
	ON pfivew.user_name = pfivel.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = 6.5 AND result = 'win' AND week != 0 AND season = 2007 GROUP BY user_name) AS psixw
	ON pzerol.user_name = psixw.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread = 6.5 AND result = 'loss' AND pick IS NOT NULL AND week != 0 AND season = 2007 GROUP BY user_name) AS psixl
	ON psixw.user_name = psixl.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread >= 7.5 AND result = 'win' AND week != 0 AND season = 2007 GROUP BY user_name) AS psevenw
	ON pzerol.user_name = psevenw.user_name

	LEFT OUTER JOIN
	(SELECT user_name, COUNT(*) AS count FROM pl_user_picks_vw WHERE spread >= 7.5 AND result = 'loss' AND pick IS NOT NULL AND week != 0 AND season = 2007 GROUP BY user_name) AS psevenl
	ON psevenw.user_name = psevenl.user_name

WHERE u.user_name NOT IN ('dnims', 'dwaldo', 'psoung');
