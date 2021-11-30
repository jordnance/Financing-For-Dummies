<?php
	require_once "config.php";

	// 'login' should be set, indicating that this action has been posted by a valid login attempt
	if (isset($_POST['login']))
	{
		unset($_POST['login']);
		
		// Store the remaining post variables
		$fName = $_POST['fName'];
		$lName = $_POST['lName'];
		$passcode = $_POST['password'];

		// Then unset the originals for security
		unset($_POST['fName']);
		unset($_POST['lName']);
		unset($_POST['password']);

		// Establish a connection to the database and select account info based on the user's input
		$db = get_connection();
		$query = $db->prepare("SELECT usrID, fName, lName, Passcode FROM User WHERE fName=? AND lName=?");
		$query->bind_param('ss', $fName, $lName);
		if ($query->execute())
		{
			$query->bind_result($res_usrID, $res_fName, $res_lName, $res_passcode);

			// Iterate over each row that is returned, because multiple users can have the same name
			while ($query->fetch())
			{
				// Check if any one of them have the correct password
				// (This is a problem, because neither of these things are primary keys. Hmm...)
				if (strcmp($passcode, $res_passcode) == 0)
				{
					// If the passcode matches (not hashed yet, but whatever), then set session variables to log the user in
					$_SESSION['usrID'] = $res_usrID;
					$_SESSION['fName'] = $fName;
					$_SESSION['lName'] = $lName;

					// Then redirect to the main page (subject to change) and exit the script here
					header("Location: index.php");
					exit;
				}
			}

			// If the script has made it this far, no valid name and password combinations were found
			$_SESSION['error'] = "Name and/or password is incorrect";
		}
		else
		{
			$_SESSION['error'] = "Unable to execute query";
		}
	}

	header("Location: index.php");
?>
