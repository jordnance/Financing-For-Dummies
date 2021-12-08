-- Edit by Marcus on 11/30:
-- Stored procedure no longer requires a usrID argument so that it can be automatically incremented.
-- Instead, it queries the database after inserting the new user to find its ID.
-- Furthermore, it now checks the length of pNumber (an optional value), and, if 0, enters NULL rather than "".
-- Also resolved error where some SELECT statements were returning multiple rows and trying to insert the result
-- into a single variable.

-- Edit by Marcus on 12/1:
-- Added adultMail argument to replace comparing last names to assign an adultID if this is a child account.

-- Edit by Marcus on 12/6:
-- Changed determination of adult or child accounts by whether an email address for a supervising parent is passed in

DROP PROCEDURE IF EXISTS addUser;
DELIMITER //
CREATE PROCEDURE addUser (mail VARCHAR(255), pNumber VARCHAR(20), code TEXT, dob TEXT, fir TEXT, mid TEXT, las TEXT, adultMail VARCHAR(255))
BEGIN
    SET @phoneNum = NULL;
    IF LENGTH(pNumber) > 0 THEN
        SET @phoneNum = pNumber;
    END IF;

    INSERT INTO User (Email, Phone_Number, Passcode, Date_Of_Birth, fName, mName, lName) VALUES (mail, @phoneNum, code, dob, fir, mid, las);
    SELECT usrID INTO @id FROM User WHERE Email = mail;
    
    IF adultMail IS NULL OR LENGTH(adultMail) = 0 THEN
        INSERT INTO Adult(usrID) VALUES (@id);
    ELSE
        SELECT usrID INTO @aID FROM Adult NATURAL JOIN User WHERE Email = adultMail AND usrID != @id;
        INSERT INTO Child(usrID, adultID) VALUES (@id, @aID);
    END IF;
END;
//
DELIMITER ;
