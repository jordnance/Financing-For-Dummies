DROP TRIGGER IF EXISTS deleteLoanFromFiAccount;
DELIMITER //
CREATE TRIGGER deleteLoanFromFiAccount
AFTER DELETE 
ON Loan
FOR EACH ROW
BEGIN
    DELETE FROM FinancialAccount WHERE acctID = OLD.acctID;
END//
DELIMITER ;
