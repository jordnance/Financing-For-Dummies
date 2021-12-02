DROP PROCEDURE IF EXISTS deleteSavingsOnly;
DELIMITER //
CREATE PROCEDURE deleteSavingsOnly (IN fid INT)
BEGIN  
	DELETE FROM Savings WHERE acctID = fid;
END;
//
DELIMITER ;
