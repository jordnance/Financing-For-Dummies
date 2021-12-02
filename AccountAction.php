<!-- Problem: Children can still register accounts w/ invalid adult email -->

<?php
	require_once "config.php";

	// $initialPost = print_r($_POST, true);

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
		exit;
	}
	// If a logout request has been posted, unset all session variables
	else if (isset($_POST['logout']))
	{
		session_unset();

		header("Location: index.php");
		exit;
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
				// Otherwise, this user doesn't exist yet.
				// If the user is a child...
				if (isset($_POST['child']))
				{
					// ...then verify that the provided adult email exists in the database (the query should return 1 row)
					$query = $db->prepare("SELECT usrID FROM Adult NATURAL JOIN User WHERE Email = ?");
					$query->bind_param('s', $_POST['adultEmail']);
					if ($query->execute())
					{
						$count = 0;
						$query->bind_result($res);
						while ($query->fetch())
						{
							$count += 1;
						}

						// If there is not exactly one row that is returned, this is an invalid email
						if ($count != 1)
						{
							$_SESSION['error'] = "Invalid data";

							// Reload the page so that the error message will display
							header("Location: register.php");
							// And quit the script here
							exit;
						}
					}
					else
					{
						$_SESSION['error'] = "Unable to confirm email";
						header("Location: register.php");
						exit;
					}
				}

				/* If everything checks out, call the stored procedure to create the user.
				 * The value of $_POST['adultEmail'] can be freely passed because it either doesn't
				 * matter (the user is an adult) or else it has already been verified. */
				$query = $db->prepare("CALL addUser(?, ?, ?, ?, ?, ?, ?, ?)");
				$query->bind_param('ssssssss', $_POST['email'], $_POST['phone'], $_POST['password'], $_POST['birthday'], $_POST['fName'], $_POST['mName'], $_POST['lName'], $_POST['adultEmail']);
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

						// Then redirect to the home page
						header("Location: home.php");
					}
					else
					{
						// If they were unable to be logged in, redirect to the log-in page
						$_SESSION['error'] = "Registered, but log-in failed";
						header("Location: index.php");
					}

					// Regardless, exit the script early so that there is no more unwanted behavior
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
			$_SESSION['error'] = "Unable to find users";
		}

		header("Location: register.php");
		exit;
	}

	// The script should always have exited by this point, so, if it doesn't,
	// print the $_POST variables that led to this state. This is... generally a very bad idea,
	// but I'm debugging, dangit!
	/*
	$_SESSION['error'] .= "<br/>Post that failed: " . $initialPost;
	$_SESSION['error'] .= "<br/>Post now: " . $_POST;
	*/
	// At the very least, always reroute the page to the index if it hasn't already gone somewhere
	header("Location: index.php");
?>
