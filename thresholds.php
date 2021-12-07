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
    <title>Thresholds</title>

    <link rel="stylesheet" href="style.css">

    <!-- The JQuery library is needed for Javascript to invoke PHP -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"
		integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
		crossorigin="anonymous">
	</script>

    <script> function setThreshold(e, form) {
        e.preventDefault();

        let account = form.querySelector("#account").value;
        let category = form.querySelector("#category").textContent;
        let threshold = form.querySelector("#threshold").value;

        let arg = { Update: true, acctID: account, Category: category, Threshold: threshold }

        $.post("setThreshold.php", arg);
    }
    </script>
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
        <p class="leftColumn"><a href="analytics.php">Generate a report</a> to see which thresholds are exceeded.</p>

        <!-- The center column will contain the bulk of the page's content. -->
        <div class="centerColumn" style="margin-top:0px; padding-top:0px;">
            <?php
                // Get a list of all of this user's financial accounts in the array $accounts
                $db = get_connection();
                $query = $db->prepare("SELECT acctID, acctName FROM FinancialAccount WHERE usrID=?");
                $query->bind_param('i', $_SESSION['usrID']);
                if (!$query->execute())
                {
                    echo "<p>Unable to find accounts.";
                    exit;
                }
                $accounts = array();
                $accountNames = array();
                $query->bind_result($acctID, $acctName);
                while ($query->fetch())
                {
                    $accounts = array_pad($accounts, sizeof($accounts) + 1, $acctID);
                    $accountNames = array_pad($accountNames, sizeof($accountNames) + 1, $acctName);
                }

                // For each of these accounts, output a form for each category
                $query = $db->prepare("SELECT Category, Threshold FROM AccountCategory WHERE acctID=?");
                for ($i = 0; $i < sizeof($accounts); $i++)
                {
                    $query->bind_param('i', $accounts[$i]);
                    if (!$query->execute())
                    {
                        echo "<p>Unable to find categories for this account.</p>";
                        continue;
                    }
                    $query->bind_result($cat, $thresh);

                    echo "<h3>" . $accountNames[$i] . "</h3>";
                    while ($query->fetch())
                    {
                        echo "<form onsubmit ='setThreshold(event, this)' autocomplete='off'>";
                        echo "<p class='tableForm'>";
                        echo "<label class='tableForm' style='min-width:75px;' id='category'>" . $cat . "</label>";
                        echo "<input type='text' style='width:50px;' id='threshold' value='" . $thresh . "'>";
                        echo "<input type='hidden' id='account' value='" . $accounts[$i] ."'>";
                        echo "<input type='submit' value='Set Threshold'>";
                        echo "</p><br/></form>";
                    }
                    echo "<br/>";
                }
            ?>
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