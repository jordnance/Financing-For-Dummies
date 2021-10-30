CREATE TABLE IF NOT EXISTS User(
usrID integer PRIMARY KEY AUTO_INCREMENT,
Email varchar(255) UNIQUE NOT NULL,
Phone_Number varchar(20) UNIQUE,
Passcode text NOT NULL,
Date_Of_Birth text NOT NULL,
fName text NOT NULL,
mName text NOT NULL,
lName text NOT NULL
);

CREATE TABLE IF NOT EXISTS Adult(
usrID integer NOT NULL,
FOREIGN KEY (usrID) REFERENCES User(usrID)
);

CREATE TABLE IF NOT EXISTS Child(
usrID integer NOT NULL,
adultID integer NOT NULL,
FOREIGN KEY (usrID) REFERENCES User(usrID),
FOREIGN KEY (adultID) REFERENCES User(usrID)  
);

CREATE TABLE IF NOT EXISTS FinancialAccount(
usrID integer NOT NULL,
acctID integer PRIMARY KEY AUTO_INCREMENT,
acctName text NOT NULL,
balance integer NOT NULL,
FOREIGN KEY (usrID) REFERENCES User(usrID)
);

CREATE TABLE IF NOT EXISTS Checking(
acctID integer NOT NULL,
FOREIGN KEY (acctID) REFERENCES FinancialAccount(acctID)
);

CREATE TABLE IF NOT EXISTS Loan(
acctID integer NOT NULL,
APR float NOT NULL,
FOREIGN KEY (acctID) REFERENCES FinancialAccount(acctID)
);

CREATE TABLE IF NOT EXISTS Savings(
acctID integer NOT NULL,
InterestRate float NOT NULL,
FOREIGN KEY (acctID) REFERENCES FinancialAccount(acctID)
);

CREATE TABLE IF NOT EXISTS AccountCategory (
acctID integer NOT NULL,
Category varchar(30) PRIMARY KEY,
Threshold integer,
FOREIGN KEY (acctID) REFERENCES FinancialAccount(acctID)
);

CREATE TABLE IF NOT EXISTS Transacts(
usrID integer NOT NULL,
acctID integer NOT NULL,
transactionID integer PRIMARY KEY AUTO_INCREMENT,
Title text NOT NULL,
Date text NOT NULL,
Amount float NOT NULL,
Category text NOT NULL,
FOREIGN KEY (usrID) REFERENCES User(usrID),
FOREIGN KEY (acctID) REFERENCES FinancialAccount(acctID)
);
