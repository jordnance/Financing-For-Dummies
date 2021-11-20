DROP PROCEDURE IF EXISTS addUser;
DELIMITER //
CREATE PROCEDURE addUser (IN usID INT, mail VARCHAR(255), pNumber VARCHAR(20), code TEXT, dob TEXT, fir TEXT, mid TEXT, las TEXT)
BEGIN    
    INSERT INTO User (usrID, Email, Phone_Number, Passcode, Date_Of_Birth, fName, mName, lName) VALUES (usID, mail, pNumber, code, dob, fir, mid, las);
    SELECT DATEDIFF(NOW(),Date_Of_Birth) INTO @ageInDays FROM User WHERE Date_Of_Birth = dob;
    IF @ageInDays >= 6570 THEN
        INSERT INTO Adult(usrID) VALUES (usID);
    ELSE
        SELECT usrID INTO @aID FROM User WHERE lName = las AND usrID != usID;
        INSERT INTO Child(usrID, adultID) VALUES (usID, @aID);
    END IF;
END;
//
DELIMITER ;