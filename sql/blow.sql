DROP PROCEDURE blow;

delimiter //

CREATE PROCEDURE blow ()
BEGIN
	SELECT COUNT(*) FROM pl_picks;
END;
//

delimiter ;
