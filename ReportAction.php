<?php
    require_once "config.php";

    // Throws an error:
    // require_once "PieChart.php";

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
            echo "A valid checking account must be selected.";
            exit;
        }
    }

    $db = get_connection();

    // Verify that this user has at least one account of the type to generate a report on.
    $query = $db->prepare("SELECT acctID FROM FinancialAccount NATURAL JOIN $report WHERE usrID=?");
    $query->bind_param('i', $_SESSION['usrID']);
    if ($query->execute())
    {
        $query->bind_result($res);
        $count = 0;
        while ($query->fetch())
        {
            $count += 1;
        }

        if ($count == 0)
        {
            echo "Sorry, " . $_SESSION['fName'] . ", you don't have any accounts of this type.";
            exit;
        }
    }
    else
    {
        echo "Unable to find accounts.";
        exit;
    }

    // The reportAggregates procedure requires the follow arguments:
    // (user integer, accountType text, timespan integer, account integer)
    $query = $db->prepare("CALL reportAggregates(?, ?, ?, ?)");
    $query->bind_param('isii', $_SESSION['usrID'], $report, $days, $acctNumber);

    echo "<p>Calling w/ usrID=" . $_SESSION['usrID'] . 
         ", account type=" . $report . ", days=" . $days . ", account number=" . $acctNumber . "</p><br/>";    

    /*
    //$query->execute();
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);
    echo print_r($row, true);
    if ($row == NULL)
        echo "It's null<br/>";
    */

    /*
    foreach ($query as $row)
    {
        echo var_dump($row);
        echo "<br/>";
    }*/

         /*
    // Our result has the follow values: (SetNum integer, ValName varchar(30), Val float)
    $result = mysqli_query($db, $query);
    if ($result)
    {
        $data_chart = array();
        echo "Howdy!";
        while ($row = mysqli_fetch_assoc($result))
        {
            //echo print_r($row, false);
            echo "I";
            // The first set is all of the spending data that will be added to the pie chart
            /*
            if ($row['0'] == 0)
            {

            }
            else
                echo "<p>" . $set . ": " . $textVal . ", " . $floatVal . "</p>";
                */

            /*
            $dbc = mysqli_connect('localhost', 'root', 'password', 'newbie');
            $query = "SELECT fname, eng_end FROM members_records";
            $result = mysqli_query($dbc, $query);
            $data_array = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $data_array[$row['fname']] = $row['eng_end'];
            }
        }
    }
    else
    {
        echo "Query failed.";
    }
    */
?>