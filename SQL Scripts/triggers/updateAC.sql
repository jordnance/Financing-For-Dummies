DROP TRIGGER IF EXISTS updateAC;

DELIMITER //
CREATE TRIGGER updateAC
AFTER INSERT
ON Transacts
FOR EACH ROW
BEGIN
	INSERT IGNORE INTO AccountCategory
	SET
	acctID = NEW.acctID,
	Category = NEW.Category,
	Threshold = NULL;
END//

DELIMITER  ;