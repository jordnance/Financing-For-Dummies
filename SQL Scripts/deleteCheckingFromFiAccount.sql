
DROP TRIGGER IF EXISTS deleteCheckingFromFiAccount;
DELIMITER //
CREATE TRIGGER deleteCheckingFromFinancialAccount
AFTER DELETE

ON Checking
FOR EACH ROW
BEGIN
    DELETE FROM FinancialAccount WHERE acctID = OLD.acctID;

END//
DELIMITER ;
