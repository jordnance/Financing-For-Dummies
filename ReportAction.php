<?php
    require_once "config.php";

    // Get the kind of report to generate from the button pressed
    $report = $_POST['button'];
    // And collect the number of days to report on the aggregates across
    $days = $_POST['days'];

    // Checking accounts also need a specific account number for a report
    $acctNumber = null;
    // So, check if this report is on a checking account
    if (strcmp($report, "Checking") == 0)
    {
        // And, if so, collect that information, too
        $acctNumber = $_POST['account'];
        // Then verify that it's not null be exiting if it is
        if ($acctNumber == null)
        {
            // $_SESSION['error'] = "This checking account does not exist.";
            exit;
        }
    }

    $db = get_connection();

    // The reportAggregates procedure requires the follow arguments:
    // (user integer, accountType text, timespan integer, account integer)
    $query = $db->prepare("CALL reportAggregates(?, ?, ?, ?)");
    $query->bind_param('isii', $_SESSION['usrID'], $report, $days, $acctNumber);

    echo "<p>Calling w/ usrID=" . $_SESSION['usrID'] . 
         ", account type=" . $report . ", days=" . $days . ", account number=" . $acctNumber . "</p><br/>";

    if ($query->execute())
    {
        // It returns the following values:
        // Return value has following format: (SetNum integer, ValName varchar(30), Val float)
        $query->bind_result($set, $textVal, $floatVal);

        while ($query->fetch())
        {
            echo "<p>" . $set . ": " . $textVal . ", " . $floatVal . "</p>";
        }
    }
    else
    {
        $_SESSION['error'] = "Unable to execute query";
    }
?>