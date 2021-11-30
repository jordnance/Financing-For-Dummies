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

					// Then redirect to the home page and exit the script here
					header("Location: home.php");
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

		header("Location: index.php");
	}
	// If a logout request has been posted, unset all session variables
	else if (isset($_POST['logout']))
	{
		session_unset();

		header("Location: index.php");
	}
	else if (isset($_POST['register']))
	{
		unset($_POST['register']);

		// First, check that the unique fields are not already taken by a user (so, email and phone number)
		$db = get_connection();
		$query = $db->prepare("SELECT usrID, Phone_Number FROM User WHERE Email=? OR Phone_Number=?");
		$query->bind_param('ss', $_POST['email'], $_POST['phone']);
		if ($query->execute())
		{
			$query->bind_result($res_usrID, $res_phone);
			$count = 0;

			// Count the number of rows returned by the query where the phone number is *not* empty
			while ($query->fetch())
			{
				if (strlen($res_phone) > 0)
					$count += 1;
			}

			if ($count != 0)
			{
				// If a row was returned (this user already exists), print an error
				$_SESSION['error'] = "An account already exists with this email and/or phone number";
			}
			else
			{
				// Otherwise (this user doesn't exist yet), call the store procedure to create it create it
				$query = $db->prepare("CALL addUser(?, ?, ?, ?, ?, ?, ?)");
				$query->bind_param('sssssss', $_POST['email'], $_POST['phone'], $_POST['password'], $_POST['birthday'], $_POST['fName'], $_POST['mName'], $_POST['lName']);
				if ($query->execute())
				{
					// If the user was successfully added to the database, query it to get their usrID
					$query = $db->prepare("SELECT usrID FROM User WHERE Email=?");
					$query->bind_param('s', $_POST['email']);
					if ($query->execute())
					{
						// If the usrID was successfully queried, log the user in
						$query->bind_result($res_usrID);
						$query->fetch();

						$_SESSION['usrID'] = $res_usrID;
						$_SESSION['fName'] = $_POST['fName'];
					}
					else
					{
						$_SESSION['error'] = "Registered, but log-in failed";
					}

					// Then redirect to the home page and exit the script here
					header("Location: home.php");
					exit;
				}
				else
				{
					$_SESSION['error'] = "Unable to register user in the database";
				}
			}
		}
		else
		{
			$_SESSION['error'] = "Unable to execute query";
		}

		header("Location: register.php");
	}
?>
