<!DOCTYPE html>

<?php
	require_once "config.php";
?>

<html>
<head>
	<title>Log In</title>

	<link rel="stylesheet" href="style.css">

	<!-- The JQuery library is needed for Javascript to invoke PHP
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"
		integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
		crossorigin="anonymous">
	</script> -->

	<!-- Basic Javascript function that sends text to
	     the PHP login script and prints any errors that occur.
	<script> function ButtonPressed(e)
	{
		let input = document.getElementById("input");
		let output = document.getElementById("errors");
		output.innerHTML = "";

		let arg = { text: input.value }
		$.post("login.php", arg)
		/*.done(function(result, status, xhr)
		{
			output.innerHTML += result;
		})*/
		.fail(function (xhr, status, error)
		{
			output.innerHTML += status + ", " + error;
		});
	}
	</script> -->
</head>

<body>
	<div style="margin-bottom:1em;">
	<?php
		if (isset($_SESSION['usrID']))
		{
			echo "Hello, " . $_SESSION['fName'] . " " . $_SESSION['lName'];
			echo "<br/>";
			echo "<form action=\"AccountAction.php\" method=\"post\">";
			echo "<button type=\"submit\" name=\"logout\">Log out</button>";
			echo "</form>";
		}
		else
		{
			echo "<p>Don't have an account? <a href=\"register.php\">Register</a></p>";
		}

		if (isset($_SESSION['error']))
		{
			echo "<p class='error'>" . $_SESSION['error'] . "</p>";
			unset($_SESSION['error']);
		}
	?>
	</div>

	<!-- https://stackoverflow.com/questions/4309950/how-to-align-input-forms-in-html -->
	<form action="AccountAction.php" method="post" autocomplete="off" class="tableForm">
		<p class="tableForm">
			<label class="tableForm">Email:</label>
			<input type="text" name="email" required="true" class="soloInput">
		</p>
		<p class="tableForm">
			<label class="tableForm" style="padding-right:10px;">Password:</label>
			<input type="password" name="password" required="true" class="soloInput">
		</p>
		<input type="submit" name="login" value="Log In">	
	</form>
</body>
</html>
