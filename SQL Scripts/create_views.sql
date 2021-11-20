CREATE OR REPLACE
VIEW Users_Public (usrID, fName, lName) AS
SELECT usrID, fName, lName FROM User;

CREATE OR REPLACE
VIEW Users_Child AS
SELECT U1.*, adultID
FROM User AS U1 NATURAL JOIN Child
INNER JOIN User AS U2 ON Child.adultID = U2.usrID;

CREATE OR REPLACE
VIEW Users_AllAccounts AS
SELECT User.* FROM User
NATURAL JOIN (SELECT * FROM FinancialAccount NATURAL JOIN Checking) AS C
INNER JOIN (SELECT * FROM FinancialAccount NATURAL JOIN Savings) AS S
ON C.usrID = S.usrID
INNER JOIN (SELECT * FROM FinancialAccount NATURAL JOIN Loan) AS L
ON S.usrID = L.usrID;