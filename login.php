<?php
	require_once "config.php";

	if (isset($_POST['login']))
	{
		unset($_POST['login']);
		
		/*
		$fName = $_POST['fName'];
		$lName = $_POST['lName'];
		$password = $_POST['password'];

		$db = get_connection();
		$query = $db->prepare("SELECT usrID, fName, lName, Passcode FROM User WHERE fName=? AND lName=?")
		$query->bind_param('ss', $fName, $lName);
		if ($query->execute())
		{
			if (mysqli_stmt_bind_result($query, $))
		}
		*/

		// Then log them in
		$_SESSION['usrID'] = 1;
		$_SESSION['fName'] = $_POST['fName'];
		$_SESSION['lName'] = $_POST['lName'];
		unset($_POST['fName']);
		unset($_POST['lName']);
	}

	// And cause the page to reload to show the new value
	header("Location: index.php");
?>
