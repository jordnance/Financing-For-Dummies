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

    // Prepare a basic PDF to put results into (modified from: http://www.fpdf.org/en/script/script28.php)
    $pdf = new PDF_Diag();
    $pdf->AddPage();
    // Set a title for the page at coordinates (20, 20)
    $pdf->SetXY(20, 20);
    $pdf->SetFont('Arial', 'BIU', 12);
    $pdf->Cell(0, 5, 'Summary');
    $pdf->Ln(8);

    // Change font for contents
    $pdf->SetFont('Arial', '', 10);

    //$valX = $pdf->GetX();
    $valY = $pdf->GetY();

    $size = 0;
    $label = array();
    $data = array();
    while ($row = mysqli_fetch_assoc($result))
    {
        // Our result has the follow values: (SetNum integer, ValName varchar(30), Val float)
        // The first set of results is the dollar amount in each category that we're interested in generating a pie chart from
        if ($row['SetNum'] == 0)
        {
            // Add this value to our list of results (both the value and name of category)
            $size += 1;
            $label = array_pad($label, $size, $row['ValName']);
            $data = array_pad($data, $size, $row['Val']);
            // And then add it to the legend beside the chart
            $pdf->Cell(30, 5, $row['ValName']);
            $pdf->Cell(15, 5, $row['Val'], 0, 0, 'R');
            $pdf->Ln();
        }
    }

    // Unfortunately, resizing an array with array_pad doesn't let us set the associative keys, only the value.
    // So, $data is only half-complete. Traverse the array now to manually combine the labels with the data.
    for ($i = 0; $i <= $size - 1; $i++)
    {
        $data[$label[$i]] = $data[$i];
        unset($data[$i]);
    }

    // Finally, we can actually create the pie chart.
    $pdf->SetXY(90, $valY);
    $colors = array(array(100, 100, 255), array(255, 100, 100), array(255, 255, 100),
                    array(0, 255, 0), array(190, 135, 0), array(45, 105, 105),
                    array(255, 0, 0), array(0, 0, 255));
    $pdf->PieChart(100, 35, $data, '%l (%p)', $colors);

    // Only needed if there's going to be more contents in the PDF (soon...)
    //$pdf->SetXY($valX, $valY + 40);

    /* Requires directory permissions to be set to 777, so it's limited to a directory *only* for PDF files rather than all source code
       Output('D', 'name') should force download on the client side, but I'm not sure where to put it to load it back.
       I'm hoping that this current method works even with multiple users b/c it creates it and immediately displays, which
       shouldn't change until the page is reloaded, so... good enough? */
    $pdf->Output('F', 'output/example_name.pdf');
    echo "<iframe src='output/example_name.pdf' style='width:100%; height:400px;'></iframe>";
?>