<?php
	require_once "config.php";

	// If a 'login' request has been posted, check for valid log-in credentials
	if (isset($_POST['login']))
	{
		unset($_POST['login']);
		
		// Store the remaining post variables
		$email = $_POST['email'];
		$passcode = $_POST['password'];

		// Then unset the originals for security
		unset($_POST['email']);
		unset($_POST['password']);

		// Establish a connection to the database and select account info based on the user's input
		$db = get_connection();
		$query = $db->prepare("SELECT usrID, fName, Passcode FROM User WHERE Email=?");
		$query->bind_param('s', $email);
		if ($query->execute())
		{
			$query->bind_result($res_usrID, $res_fName, $res_passcode);

			// Iterate over each row that is returned, which should only ever be one because emails are unique
			while ($query->fetch())
			{
				// Check for a matching password (not hashed yet, but whatever)
				if (strcmp($passcode, $res_passcode) == 0)
				{
					// If there's a match, set session variables to log the user in
					$_SESSION['usrID'] = $res_usrID;
					$_SESSION['fName'] = $res_fName;

					// Then redirect to the main page (subject to change) and exit the script here
					header("Location: index.php");
					exit;
				}
			}

			// If the script has made it this far, no valid name and password combinations were found
			$_SESSION['error'] = "Email and/or password is incorrect";
		}
		else
		{
			$_SESSION['error'] = "Unable to execute query";
		}
	}
	// If a logout request has been posted, unset all session variables
	else if (isset($_POST['logout']))
	{
		session_unset();
	}
	else if (isset($_POST['register']))
	{

	}

	header("Location: index.php");
?>
