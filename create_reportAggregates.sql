-- Example calls:
-- CALL reportAggregates(5, "Checking", -1, 5);
-- CALL reportAggregates(10, "Savings", -1, NULL);
-- CALL reportAggregates(6, "Loan", -1, NULL);

DROP PROCEDURE IF EXISTS reportAggregates;

DELIMITER //

CREATE PROCEDURE reportAggregates (user integer, accountType text, timespan integer, account integer)
BEGIN
    -- Calculate the date that was `timespan` days ago. If it's -1, make it within the user's lifetime
    SET @date = "";
    IF timespan = -1 THEN
        SELECT Date_Of_Birth INTO @date
        FROM User WHERE usrID = user;
    ELSE
        SELECT DATE_SUB(CURDATE(), INTERVAL timespan DAY) INTO @date;
    END IF;

    CASE
        WHEN STRCMP(accountType, "Checking") = 0 THEN
            SELECT COUNT(*) INTO @count
            FROM User NATURAL JOIN FinancialAccount
            WHERE usrID = user AND acctID = account;

            IF @count != 1 THEN
                SELECT "Invalid user or account ID" AS Results;
            ELSE
                DROP TABLE IF EXISTS Cats;
                CREATE TEMPORARY TABLE Cats AS
                (SELECT usrID, acctID, Category, Threshold FROM
                    FinancialAccount NATURAL JOIN AccountCategory
                    WHERE acctID = account);

                DROP TABLE IF EXISTS Spending;
                CREATE TEMPORARY TABLE Spending AS
                    (SELECT Cats.Category AS Category, ABS(ROUND(SUM(Amount), 2)) AS SumSpent, Threshold
                    FROM Cats INNER JOIN Transacts
                    ON Cats.usrID = Transacts.usrID AND Cats.acctID = Transacts.acctID
                    AND Cats.Category = Transacts.Category
                    WHERE Transacts.Date >= @date
                    GROUP BY Cats.Category);

                DROP TABLE IF EXISTS returnTable;
                CREATE TEMPORARY TABLE returnTable (SetNum integer, ValName varchar(30), Val float);
                -- Add the total amount spent in each category to the results
                INSERT INTO returnTable (SetNum, ValName, Val)
                    SELECT 0, Category, SumSpent FROM Spending;
                -- Add the threshold for each category that has been exceeded to the results
                INSERT INTO returnTable (SetNum, ValName, Val)
                    SELECT 1, Category, Threshold FROM Spending
                    WHERE Threshold IS NOT NULL
                    AND SumSpent > Threshold;

                DROP TABLE Spending;
                DROP TABLE Cats;

                SELECT * FROM returnTable;

                DROP TABLE returnTable;
            END IF;

        WHEN STRCMP(accountType, "Savings") = 0 THEN
            SELECT COUNT(*) INTO @count
            FROM FinancialAccount NATURAL JOIN Savings
            WHERE usrID = user;

            IF @count = 0 THEN
                SELECT "No savings accounts found" AS Results;
            ELSE
                DROP TABLE IF EXISTS Cats;
                CREATE TEMPORARY TABLE Cats AS
                (SELECT acctID, Category, Threshold FROM
                    FinancialAccount NATURAL JOIN Savings NATURAL JOIN AccountCategory
                    WHERE usrID = user);

                DROP TABLE IF EXISTS Deposited;
                CREATE TEMPORARY TABLE Deposited AS
                    (SELECT Cats.Category AS Category, ROUND(SUM(Amount), 2) AS SumDeposited, Threshold
                    FROM Cats INNER JOIN Transacts
                    ON Cats.acctID = Transacts.acctID
                    AND Cats.Category = Transacts.Category
                    WHERE Transacts.Date >= @date
                    AND Amount > 0
                    GROUP BY Cats.Category);

                DROP TABLE IF EXISTS Withdrawn;
                CREATE TEMPORARY TABLE Withdrawn AS
                    (SELECT Cats.Category AS Category, ROUND(SUM(Amount), 2) AS SumWithdrawn, Threshold
                    FROM Cats INNER JOIN Transacts
                    ON Cats.acctID = Transacts.acctID
                    AND Cats.Category = Transacts.Category
                    WHERE Transacts.Date >= @date
                    AND Amount < 0
                    GROUP BY Cats.Category);

                DROP TABLE IF EXISTS returnTable;
                CREATE TEMPORARY TABLE returnTable (SetNum integer, ValName varchar(30), Val float);
                -- Add the total amount deposited to each category to the results
                INSERT INTO returnTable 
                    SELECT 0, Category, SumDeposited FROM Deposited;
                -- Add the total amount withdrawn from each category to the results
                INSERT INTO returnTable 
                    SELECT 1, Category, SumWithdrawn FROM Withdrawn;
                -- Add the categories where the amount withdrawn exceeded its threshold
                INSERT INTO returnTable
                    SELECT 2, Category, Threshold FROM Withdrawn
                    WHERE Threshold IS NOT NULL
                    AND ABS(SumWithdrawn) > Threshold;

                SELECT * FROM returnTable;
            END IF;

        WHEN STRCMP(accountType, "Loan") = 0 THEN
            SELECT COUNT(*) INTO @count
            FROM FinancialAccount NATURAL JOIN Loan
            WHERE usrID = user;

            IF @count = 0 THEN
                SELECT "No loan accounts found" AS Results;
            ELSE
                DROP TABLE IF EXISTS Cats;
                CREATE TEMPORARY TABLE Cats AS
                (SELECT acctID, Category, Threshold FROM
                    FinancialAccount NATURAL JOIN Loan NATURAL JOIN AccountCategory
                    WHERE usrID = user);

                DROP TABLE IF EXISTS Paid;
                CREATE TEMPORARY TABLE Paid AS
                    (SELECT Cats.Category AS Category, ROUND(SUM(Amount), 2) AS SumPaid, Threshold
                    FROM Cats INNER JOIN Transacts
                    ON Cats.acctID = Transacts.acctID
                    AND Cats.Category = Transacts.Category
                    WHERE Transacts.Date >= @date
                    AND Amount > 0
                    GROUP BY Cats.Category);

                DROP TABLE IF EXISTS returnTable;
                CREATE TEMPORARY TABLE returnTable (SetNum integer, ValName varchar(30), Val float);
                -- Add the total amount payed to each category of loan to the results
                INSERT INTO returnTable 
                    SELECT 0, Category, SumPaid FROM Paid;
                -- Add the categories where the amount withdrawn exceeded its threshold
                INSERT INTO returnTable
                    SELECT 1, Category, Threshold FROM Paid
                    WHERE Threshold IS NOT NULL
                    AND ABS(SumPaid) > Threshold;

                SELECT * FROM returnTable;
            END IF;

        ELSE
            BEGIN SELECT "Invalid reportAggregates arguments" AS Results; END;
    END CASE;
END;

//

DELIMITER ;