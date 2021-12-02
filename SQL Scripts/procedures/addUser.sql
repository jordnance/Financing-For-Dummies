-- Edit by Marcus on 11/30:
-- Stored procedure no longer requires a usrID argument so that it can be automatically incremented.
-- Instead, it queries the database after inserting the new user to find its ID.
-- Furthermore, it now checks the length of pNumber (an optional value), and, if 0, enters NULL rather than "".
-- Also resolved error where some SELECT statements were returning multiple rows and trying to insert the result
-- into a single variable. Added "LIMIT 1" to line 23 and used argument "dob" instead of query on line 19.

DROP PROCEDURE IF EXISTS addUser;
DELIMITER //
CREATE PROCEDURE addUser (mail VARCHAR(255), pNumber VARCHAR(20), code TEXT, dob TEXT, fir TEXT, mid TEXT, las TEXT)
BEGIN
    SET @phoneNum = NULL;
    IF LENGTH(pNumber) > 0 THEN
        SET @phoneNum = pNumber;
    END IF;

    INSERT INTO User (Email, Phone_Number, Passcode, Date_Of_Birth, fName, mName, lName) VALUES (mail, @phoneNum, code, dob, fir, mid, las);
    SELECT usrID INTO @id FROM User WHERE Email = mail;
    SELECT DATEDIFF(NOW(), dob) INTO @ageInDays;
    IF @ageInDays >= 6570 THEN
        INSERT INTO Adult(usrID) VALUES (@id);
    ELSE
        SELECT usrID INTO @aID FROM User WHERE lName = las AND usrID != @id LIMIT 1;
        INSERT INTO Child(usrID, adultID) VALUES (@id, @aID);
    END IF;
END;
//
DELIMITER ;
