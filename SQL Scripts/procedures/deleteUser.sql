-- 12/1, Marcus reworked procedure to not need date of birth as a second argument

DROP PROCEDURE IF EXISTS deleteUser;
DELIMITER //
CREATE PROCEDURE deleteUser (IN usID INT)
BEGIN
    SELECT usrID INTO @deleteID FROM User WHERE usrID = usID;
    
    IF EXISTS (SELECT * FROM Adult WHERE usrID = usID) THEN
        DELETE FROM Adult WHERE usrID = @deleteID;
    ELSE
        DELETE FROM Child WHERE usrID = @deleteID;
    END IF;
    DELETE FROM FinancialAccount WHERE usrID = @deleteID;
    DELETE FROM User WHERE usrID = @deleteID;
END;
//
DELIMITER ;
