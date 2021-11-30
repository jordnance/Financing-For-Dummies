DROP PROCEDURE IF EXISTS deleteCheckingOnly;
DELIMITER //
CREATE PROCEDURE deleteCheckingOnly (IN fID INT)
BEGIN   
    DELETE FROM Checking WHERE Checking.acctID = fid;
END;
//
DELIMITER ;
