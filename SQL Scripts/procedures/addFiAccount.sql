DROP PROCEDURE IF EXISTS addFiAccount;

DELIMITER //

CREATE PROCEDURE addFiAccount (IN usID INT, accountType TEXT, accountName TEXT)

BEGIN
    INSERT INTO FinancialAccount (usrID, Balance, acctName) VALUES (usID, 0, accountName);

    CASE 
        WHEN STRCMP(accountType, "Checking") = 0 THEN
            -- LAST_INSERT_ID() is the newly inserted acctID no matter what acctName is        	
            INSERT INTO Checking (acctID) VALUES (LAST_INSERT_ID());
        
        WHEN STRCMP(accountType, "Loan") = 0 THEN
            INSERT INTO Loan (acctID, APR) VALUES (LAST_INSERT_ID(), 0);

        WHEN STRCMP(accountType, "Savings") = 0 THEN
            INSERT INTO Savings (acctID, InterestRate) VALUES (LAST_INSERT_ID(), 0);
            






    END CASE;


END;
//
DELIMITER ;

