<!DOCTYPE html>

<!-- Start by making sure that a session is running -->
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
	<div>
	<?php
		if (isset($_SESSION['usrID']))
		{
			echo "Hello, " . $_SESSION['fName'] . " " . $_SESSION['lName'];
			echo "<br/><a href=\"logout.php\">Log out</a>";
		}
		else
		{
			echo "<p>Don't have an account? <a>Register</a></p>";
		}
	?>
	</div>

	<!-- https://stackoverflow.com/questions/4309950/how-to-align-input-forms-in-html -->
	<form action="login.php" method="post" autocomplete="off" class="tableForm">
		<p class="tableForm">
			<label class="tableForm">Name:</label>
			<input type="text" name="fName" required="true" class="joinedInput">
			<input type="text" name="lName" required="true" class="joinedInput">
		</p>
		<p class="tableForm">
			<label class="tableForm" style="padding-right:10px;">Password:</label>
			<input type="password" name="password" required="true" class="soloInput">
		</p>
		<input type="submit" name="login" value="Log In">	
	</form>

	<!-- This divider will remain empty unless the JS function
	     outputs an error to it. -->
	<div id="errors">
	</div>
</body>
</html>
