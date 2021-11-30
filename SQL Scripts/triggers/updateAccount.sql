DROP TRIGGER IF EXISTS updateAccount;

DELIMITER //
CREATE TRIGGER updateAccount
AFTER INSERT
ON Transacts
FOR EACH ROW
BEGIN
	-- SELECT Amount, MAX(Date) AS MostRecentTransaction, usrID, acctID INTO @updateAcc 
	-- FROM Transacts INNER JOIN FinancialAccount 
	-- WHERE Transacts.acctID = FinancialAccount.acctID;
	UPDATE FinancialAccount
	SET Balance = Balance + NEW.Amount 
	WHERE acctID = NEW.acctID;
END//

DELIMITER ;
