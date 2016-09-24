SELECT
	b.max,
	c.*

FROM
	(SELECT
		MAX(ROUND(a.wins / (a.wins + a.losses), 3)) AS max

	FROM
		(SELECT
			user_name,
			season,
			SUM(wins) AS wins,
			SUM(losses) AS losses

		FROM
			dev_record

		WHERE
			season = 2006 AND
			week > 0 AND
			week <= 17

		GROUP BY
			user_name,
			season) AS a
	) AS b,

	(SELECT
		user_name,
		season,
		SUM(wins) AS wins,
		SUM(losses) AS losses

	FROM
		dev_record

	WHERE
		season = 2006 AND
		week > 0 AND
		week <= 17

	GROUP BY
		user_name,
		season) AS c

WHERE
	b.max = ROUND(c.wins / (c.wins + c.losses), 3);
