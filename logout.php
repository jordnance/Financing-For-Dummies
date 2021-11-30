<?php
	// We want to use session variables, so make sure one is running
	if (session_status() == PHP_SESSION_NONE)
	{
		session_start();
	}

	if (isset($_SESSION['usrID']))
	{
        session_unset();
	}

	// And cause the page to reload to show the new value
	header("Location: index.php");
?>
