<?php
	// We want to use session variables, so make sure one is running
	if (session_status() == PHP_SESSION_NONE)
	{
		session_start();
	}

	/* A variable 'text' should be posted if this script is
	   executed, but check for it anyway. */
	if (isset($_POST['text']))
	{
		// If it does exist, copy its value to the session variable
		$_SESSION['example'] = $_POST['text'];
		unset($_POST['text']);
	}

	// And cause the page to reload to show the new value
	header("Location: index.php");
?>
