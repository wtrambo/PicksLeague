SELECT
	w.season,
	w.week,
	w.count AS wins,
	l.count AS losses

FROM
	(SELECT season, week, COUNT(*) AS count FROM pl_majority_vw WHERE majority IS NOT NULL AND majority = winner GROUP BY week, season) AS w,
	(SELECT season, week, COUNT(*)  AS count FROM pl_majority_vw WHERE majority IS NOT NULL AND majority != winner GROUP BY week, season) AS l

	WHERE
		w.season = l.season AND
		w.week = l.week AND
		w.season = 2006 AND
		w.week > 0;
