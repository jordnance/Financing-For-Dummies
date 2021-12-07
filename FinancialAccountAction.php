<?php
	require_once "config.php";

    if (isset($_POST['createAcct']))
    {
        unset($_POST['createAcct']);

        $db = get_connection();
        // addFiAccount (IN usID INT, accountType TEXT, accountName TEXT)
		$query = $db->prepare("CALL addFiAccount(?,?,?)");
		$query->bind_param('iss', $_SESSION['usrID'], $_POST['type'], $_POST['name']);

        // Run the query and, if it fails, print an error message and reload the page
		if (!$query->execute())
        {
            $_SESSION['error'] = "Failed to create account.";
            header("Location: newFinancialAccount.php");
            exit;
        }
    }

    // Otherwise, if the query succeeds then redirect them to the account page
    header("Location: accountInterface.php");
?>