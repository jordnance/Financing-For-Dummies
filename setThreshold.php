<?php
	require_once "config.php";

    if (isset($_POST['Update']))
    {
        unset($_POST['Update']);

        $db = get_connection();
		$query = $db->prepare("UPDATE AccountCategory SET Threshold=? WHERE acctID=? AND Category=?");
		$query->bind_param('iis', $_POST['Threshold'], $_POST['acctID'], $_POST['Category']);

        // Run the query and, if it fails, print an error message
		if (!$query->execute())
            $_SESSION['error'] = "Failed to change the threshold.<br/>";
            header("Location: home.php");
    }
?>