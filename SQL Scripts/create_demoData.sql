-- Add the user
CALL addUser("john_doe@gmail.com", NULL, "test", "1983-01-01", "John", "Reginald", "Doe", NULL);
SELECT usrID INTO @id FROM User WHERE Email = "john_doe@gmail.com";

-- Populate a checking account
CALL addFiAccount(@id, "Checking", "Personal Spending");
SELECT acctID INTO @checkingID FROM FinancialAccount WHERE usrID = @id AND acctName = "Personal Spending";
INSERT INTO Transacts (usrID, acctID, Title, Date, Amount, Category) VALUES
            (@id, @checkingID, "Initial Deposit", "2021-11-15", 500, "Deposit"),
            (@id, @checkingID, "Starbucks dark roast", "2021-11-16", -5, "Coffee"),
            (@id, @checkingID, "Starbucks dark roast and muffin", "2021-11-21", -7, "Coffee"),
            (@id, @checkingID, "Starbucks", "2021-11-24", -5, "Coffee"),
            (@id, @checkingID, "COFFEE", "2021-11-26", -5, "Coffee"),
            (@id, @checkingID, "i need SLEEP", "2021-11-27", -5, "Coffee");

INSERT INTO Transacts (usrID, acctID, Date, Amount, Category) VALUES
            (@id, @checkingID, "2021-11-28", -5, "Coffee"),
            (@id, @checkingID, "2021-11-29", -5, "Coffee");

-- I have too much fun entering sample data, lol

INSERT INTO Transacts (usrID, acctID, Title, Date, Amount, Category) VALUES
            (@id, @checkingID, "Coffee beans", "2021-11-30", -12, "Coffee"),
            (@id, @checkingID, "Coffee beans", "2021-12-08", -12, "Coffee"),
            (@id, @checkingID, "Allowance", "2021-12-01", 200, "Deposit"),
            (@id, @checkingID, "Elden Ring preorder", "2021-12-01", -60, "Video Games");

-- Populate another checking account
CALL addFiAccount(@id, "Checking", "General Checking");
SELECT acctID INTO @checkingID2 FROM FinancialAccount WHERE usrID = @id AND acctName = "General Checking";
INSERT INTO Transacts (usrID, acctID, Title, Date, Amount, Category) VALUES
            (@id, @checkingID2, "Initial Deposit", "2021-11-01", 1000, "Deposit"),
            (@id, @checkingID2, "Dinner", "2021-11-03", -40, "Food"),
            (@id, @checkingID2, "Dinner", "2021-11-15", -50, "Food"),
            (@id, @checkingID2, "Grocery Shopping", "2021-11-06", -100, "Groceries"),
            (@id, @checkingID2, "Grocery Shopping", "2021-11-13", -100, "Groceries"),
            (@id, @checkingID2, "Grocery Shopping", "2021-11-20", -100, "Groceries"),
            (@id, @checkingID2, "Grocery Shopping", "2021-11-27", -100, "Groceries"),
            (@id, @checkingID2, "Grocery Shopping", "2021-12-04", -100, "Groceries"),
            (@id, @checkingID2, "Paycheck", "2021-11-15", 2000, "Deposit"),
            (@id, @checkingID2, "Savings", "2021-11-15", -500, "Savings"),
            (@id, @checkingID2, "Paycheck", "2021-12-01", 2000, "Deposit"),
            (@id, @checkingID2, "Savings", "2021-12-01", -500, "Savings"),
            (@id, @checkingID2, "Rent", "2021-12-01", -900, "Rent"),
            (@id, @checkingID2, "My Allowance", "2021-11-15", -500, "Personal"),
            (@id, @checkingID2, "My Allowance", "2021-12-01", -200, "Personal"),
            (@id, @checkingID2, "Jr's Allowance", "2021-12-06", -50, "Personal");

-- Populate a savings account
CALL addFiAccount(@id, "Savings", "My Savings");
SELECT acctID INTO @savingsID FROM FinancialAccount WHERE usrID = @id AND acctName = "My Savings";
INSERT INTO Transacts (usrID, acctID, Title, Date, Amount, Category) VALUES
            (@id, @savingsID, "Initial Deposit", "2021-11-15", 500, "Deposit"),
            (@id, @savingsID, "Deposit", "2021-12-01", 500, "Deposit");

-- Add the child user
CALL addUser("jr_doe@gmail.com", NULL, "test", "2005-12-31", "John", "Jr", "Doe", "john_doe@gmail.com");
SELECT usrID INTO @childID FROM User WHERE Email = "jr_doe@gmail.com";

-- Populate a (very irresponsible) checking account that may or may not be destined for deletion in the demo. ^_^
CALL addFiAccount(@childID, "Checking", "FREEDOM");
SELECT acctID INTO @childCheckingID FROM FinancialAccount WHERE usrID = @childID AND acctName = "FREEDOM";
INSERT INTO Transacts (usrID, acctID, Date, Amount, Category) VALUES
            (@childID, @childCheckingID, "2021-12-06", 50, "monee"),
            (@childID, @childCheckingID, "2021-12-06", -10, "monee"),
            (@childID, @childCheckingID, "2021-12-07", -25, "monee"),
            (@childID, @childCheckingID, "2021-12-07", -10, "monee");