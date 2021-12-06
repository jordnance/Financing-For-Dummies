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
    <title>Analytics</title>

    <link rel="stylesheet" href="style.css">

    <!-- The JQuery library is needed for Javascript to invoke PHP -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"
		integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
		crossorigin="anonymous">
	</script>

    <script> 
        const times = ["7 days", "30 days", "365 days"];
    </script>

    <script> function generateReport(event, buttonName) {
        // Prevent the page from reloading and losing our data
        event.preventDefault();

        let state = document.getElementById("state");
        let output = document.getElementById("reportDiv");
        output.innerHTML = "";

        var acctID = null;
        if (buttonName.localeCompare("Checking") == 0)
        {
            // If the report is being created for a checking account, check the dropdown menu for the acctID
            acctID = document.getElementById("account").value;
        }
        else
        {
            // Otherwise, make sure the additional options displayed for the checking account
            // analytics is hidden. (It'll come back on its own when the Checking button is pressed again.)
            document.getElementById("extraChecking").style.display = "none";
        }

        // Set the type of button and the account ID (null or otherwise) as arguments
        let arg = { button: buttonName, days: times[document.getElementById("days").value], account: acctID }

        // Post arguments to PHP script and add the results to the HTML div below.
        $.post("ReportAction.php", arg)
        .done(function(result, status, xhr)
        {
            output.innerHTML += result;
            state.innerHTML = buttonName + " report";
        })
        .fail(function (xhr, status, error)
        {
            output.innerHTML += status + ", " + error;
            state.innerHTML = "Unable to generate report";
        });
    }
    </script>

    <!-- Whenever the slider is changed, update the label describing it -->
    <script> function onSlide(slider)
    {
        let label = document.getElementById("dayLabel");

        label.innerHTML = "Report Time: " + times[slider.value];
    }
    </script>

</head>

<body>
    <div id="header">
        <h1>Financing for Dummies</h1>
    </div>

    <ul id="navigation">
        <li><a class="button" href="home.php">Home</a></li>
        <li><a class="button" href="accountInterface.php">Accounts</a></li>
        <li><a class="button" href="#top">Analytics</a></li>
        <li><a class="button" href="userRoles.php">User Roles</a></li>
        <li><a class="button" href="newTransaction.php">New Transaction</a></li>
        <li><a class="button" href="settings.php">Settings</a></li>
        <li><button class="link" form="logout" name="logout">Log Out</button></li>
    </ul>
	
	<div id="main">
        <!-- The left column provides a list of buttons that can be pressed to change the content
             displayed in the center column. -->
        <div class="leftColumn">
            <p>Generate Report For:</p>
            <button name="selectChecking" class="large" form="checking" style="margin-top:0px;">Checking Account</button>
            <button name="Savings" class="large" onclick="generateReport(event, 'Savings')">Savings Accounts</button>
            <button name="Loan" class="large" onclick="generateReport(event, 'Loan')" style="margin-bottom:10px;">Loan Accounts</button>
            <div style="padding-bottom:10px; padding-top:15px;">
                <label id="dayLabel">Report Time: 30 days</label>
                <input id="days" type="range" class="slider" min="0" max="2" oninput="onSlide(this)" style="margin-top:10px;">
            </div>
        </div>

        <!-- The center column will contain the bulk of the page's content. -->
        <div class="centerColumn" style="">
            <!-- Display a short message saying that no reports have been generated
                 that will be updated by the Javascript function when it is called. -->
            <p id="state" style="text-align:center;">
                <?php
                    if (!isset($_POST['dropdown']))
                        echo "No report generated";
                    else
                        echo "Select account to generate report";
                ?>
            </p>

            <!-- When the Checking button in the left column is pressed, the page will
                 reload to contain additional options to choose the checking account to report on. -->
            <div id="extraChecking">
                <?php
                if (isset($_POST['selectChecking']))
                {
                    // Query the database to get all of the user's checking accounts
                    $db = get_connection();
                    $query = $db->prepare("SELECT acctID, acctName FROM FinancialAccount NATURAL JOIN Checking WHERE usrID=? ORDER BY acctName");
                    $query->bind_param('i', $_SESSION['usrID']);
                    if ($query->execute())
                    {
                        $query->bind_result($acctID, $acctName);

                        // Create a dropdown menu...
                        echo "<div style='width:30%; margin:auto;'>";
                        echo "<form onsubmit='generateReport(event, \"Checking\")'>";
                        echo "<select id='account' style='margin:5px;'>";
                        // ...and populate it with all of the returned account names and IDs
                        $count = 0;
                        while ($query->fetch())
                        {
                            $count += 1;

                            echo "<option value='" . $acctID . "'>" . $acctName . "</option>";
                        }
                        // If no accounts were found, put in a default value that goes nowhere
                        if ($count == 0)
                            echo "<option value=''>No checking accounts</option>";
                        // Close the dropdown menu
                        echo "</select><input type='submit' value='Submit'>";
                        echo "</form></div>";
                    }
                    else
                    {
                        $_SESSION['error'] = "Unable to execute query";
                    }
                }
                ?>
            </div>

            <!-- The actual report content that comes after will be added to this div by JS. -->
            <div id="reportDiv">
            </div>
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

<!-- These empty forms don't show any content on the page, but they do allow
     for buttons to invoke PHP without using Javascript every time. -->
<form id="logout" method="post" action="AccountAction.php"></form>
<!-- Called when the checking button in the left column is pressed so that the center column
     knows to adjust its display to accomodate the new buttons because of the hidden input
     field that includes $_POST['dropdown']. -->
<form id="checking" method="post" action="analytics.php">
    <input type="hidden" name="dropdown">
</form>

</html>