DROP PROCEDURE IF EXISTS deleteUser;
DELIMITER //
CREATE PROCEDURE deleteUser (IN usID INT, dob TEXT)
BEGIN
    SELECT usrID INTO @deleteID FROM User WHERE usrID = usID;
    SELECT DATEDIFF(NOW(),Date_Of_Birth) INTO @ageInDays FROM User WHERE Date_Of_Birth = dob;
    IF @ageInDays >= 6570 THEN
        DELETE FROM Adult WHERE usrID = @deleteID;
    ELSE
        DELETE FROM Child WHERE usrID = @deleteID;
    END IF;
    DELETE FROM FinancialAccount WHERE usrID = @deleteID;
    DELETE FROM User WHERE usrID = @deleteID;
END;
//
DELIMITER ;