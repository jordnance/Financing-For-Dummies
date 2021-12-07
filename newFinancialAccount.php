<!DOCTYPE html>

<?php
    require_once "config.php";

    // Don't let anyone who isn't logged in onto this page
    if (!isset($_SESSION['usrID']))
    {
        header("Location: index.php");
        exit;
    }
?>

<html>
<head>
    <title>New Account</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="header">
        <h1>Financing for Dummies</h1>
    </div>

    <ul id="navigation">
        <li><a class="button" href="home.php">Home</a></li>
        
        <div class="dropdown">
            <li class="menu">Financial Accounts
                <div class="dropdown-content">
                    <a class="button" style="display:block;" href="accountInterface.php">My Accounts</a>
                    <a class="button" style="display:block;" href="userRoles.php">Child Accounts</a>
                    <a class="button" style="display:block;" href="analytics.php">Generate Report</a>
                </div>
            </li>
        </div>

        <div class="dropdown">
            <li class="menu">Create New
                <div class="dropdown-content" style="left: -15px;">
                    <a class="button" style="display:block;" href="newFinancialAccount.php">Account</a>
                    <a class="button" style="display:block;" href="newTransaction.php">Transaction</a>
                    <a class="button" style="display:block;" href="thresholds.php">Threshold</a>
                </div>
            </li>
        </div>

        <li><a class="button" href="settings.php">Settings</a></li>

        <li><button class="link" form="logout" name="logout">Log Out</button></li>
    </ul>
	
	<div id="main">
        <!-- The center column will contain the bulk of the page's content. -->
        <div class="centerColumn">
            <!-- addFiAccount (IN usID INT, accountType TEXT, accountName TEXT) -->
            <form action="FinancialAccountAction.php" method="post" autocomplete="off" class="tableForm">
                <p class="tableForm">
                    <label class="tableForm">Account Name:</label>
                    <input type="text" name="name" required="true" class="soloInput">
                </p>

                <label class="tableForm" style="width:125px;">Account Type:</label>
                <label class="tableForm">
                    <input type="radio" name="type" value="Checking">Checking
                    <input type="radio" name="type" value="Loan">Loan
                    <input type="radio" name="type" value="Savings">Savings
                </label>

                <br/>

                <input class="link" type="submit" name="createAcct" value="Create">
		    </form>
        </div>
    </div>

    <!-- As ever, print any session errors at the bottom of the page if they exist -->
    <?php
        if (isset($_SESSION['error']))
        {
            echo "<p class='error'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
    ?>
</body>

<form id="logout" method="post" action="AccountAction.php"></form>

</html>