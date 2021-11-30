DROP TRIGGER IF EXISTS deleteSavingsFromFiAccount;
DELIMITER //
CREATE TRIGGER deleteSavingsFromFiAccount
AFTER DELETE 
ON Savings
FOR EACH ROW
BEGIN
	DELETE FROM FinancialAccount WHERE acctID = OLD.acctID;
END//
DELIMITER ;
