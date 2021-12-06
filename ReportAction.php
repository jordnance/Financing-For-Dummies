<?php
    require_once "config.php";
    require_once "fpdf/PieChart.php";

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
    $query->execute();
    $result = $query->get_result();

    if ($result == NULL)
    {
        echo "No data to create report on.<br/>";
        exit;
    }

    // Prepare a basic PDF to put results into (based on: http://www.fpdf.org/en/script/script28.php)
    $pdf = new PDF_Diag();
    $pdf->AddPage();
    // Set the initial page coordinates and store the value
    $pdf->SetXY(20, 20);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();

    /*
    $pdf->SetFont('Arial', 'BIU', 12);
    $pdf->Cell(0, 5, 'Summary');
    $pdf->Ln(8);
    */

    // Change font for contents
    $pdf->SetFont('Arial', '', 10);

    // Prepare for having three arrays of labels and their corresponding data
    $size = array(0, 0, 0);
    $labels = array(array(), array(), array());
    $data = array(array(), array(), array());
    while ($row = mysqli_fetch_assoc($result))
    {
        // Our result has the following format: (SetNum integer, ValName varchar(30), Val float)
        // So store the name of the value in the $labels array of arrays
        $size[$row['SetNum']] += 1;
        $labels[$row['SetNum']] = array_pad($labels[$row['SetNum']], $size[$row['SetNum']], $row['ValName']);
        $data[$row['SetNum']] = array_pad($data[$row['SetNum']], $size[$row['SetNum']], $row['Val']);
    }

    // The first set of results is the dollar amount spent in each category.
    // The second set of results is the names of all the categories that have exceeded their thresholds.
    // OR, if this is a savings account, it's the dollar amount *withdrawn* from each category, and the
    // *third* set is the name of categories exceeding thresholds.

    // Unfortunately, resizing an array with array_pad doesn't let us set the associative keys, only the value.
    // So, $data is only half-complete. Traverse the array now to manually combine the labels with the data.
    for ($array = 0; $array < 3; $array++)
    {
        for ($i = 0; $i <= $size[$array] - 1; $i++)
        {
            $data[$array][$labels[$array][$i]] = $data[$array][$i];
            unset($data[$array][$i]);
        }
    }

    // Set the colors to be used in each section of the pie charts
    $colors = array(array(100, 100, 255), array(255, 100, 100), array(255, 255, 100),
                    array(0, 255, 0), array(190, 135, 0), array(45, 105, 105),
                    array(255, 0, 0), array(0, 0, 255));

    // Finally, we can actually create the pie chart.
    $pdf->SetXY($valX + 30, $valY + 20);
    $pdf->PieChart(150, 75, $data[0], '%l (%p)', $colors);
    $valY = $pdf->GetY();

    // From here, handle things differently for Savings accounts (which have an extra set of results).
    // First, establish that the next set is 1 (the 2nd)
    $set = 1;
    if (strcmp($report, "Savings") == 0)
    {
        // Just like the first set, create another pie chart, this one for withdrawals.
        $pdf->SetXY($valX + 30, $valY + 50);
        $pdf->PieChart(150, 75, $data[1], '%l (%p)', $colors);

        // Finally, increment the set (so savings accounts will see 2 and get the 3rd set,
        // but the others will see 1 and get the 2nd set)
        $set += 1;
        // And update the Y location
        $valY = $pdf->GetY();
    }

    // The last thing to add to the report is the list of all categories that have exceeded their threshold
    $pdf->SetXY($valX, $valY + 50);
    $pdf->SetFont('Arial', 'BIU', 12);
    $pdf->Cell(0, 5, 'Categories Exceeding Threshold:');
    $pdf->Ln(8);
    $pdf->SetFont('Arial', '', 10);
    for ($i = 0; $i < $size[$set]; $i++)
    {
        $pdf->Cell(30, 5, $data[$i]['ValName']);
        $pdf->Ln();
    }

    /* Requires directory permissions to be set to 777, so it's limited to a directory *only* for PDF files rather than all source code
       Output('D', 'name') should force download on the client side, but I'm not sure where to put it to load it back.
       I'm hoping that this current method works even with multiple users b/c it creates it and immediately displays, which
       shouldn't change until the page is reloaded, so... good enough? */
    $pdf->Output('F', 'output/report.pdf');
    echo "<iframe src='output/report.pdf' style='width:100%; height:400px;'></iframe>";
?>