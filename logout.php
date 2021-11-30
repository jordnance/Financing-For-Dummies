<?php
	// Start the current session
	if (session_status() == PHP_SESSION_NONE)
	{
		session_start();
	}

	// If the user is currently logged in, log out by unsetting all sessions variables
	if (isset($_SESSION['usrID']))
	{
        session_unset();
	}

	// Go back to the original log-in page
	header("Location: index.php");
?>
