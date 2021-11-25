<!DOCTYPE html>

<!--
     This is a relatively simple starting page
     that demonstrates the use of sessions to
     remember information that has already been entered.
-->

<!-- Start by making sure that a session is running -->
<?php
	if (session_status() == PHP_SESSION_NONE)
	{
		session_start();
	}
?>

<html>
<head>
	<title>Log In</title>

	<!-- The JQuery library is needed for Javascript to invoke PHP -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"
		integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
		crossorigin="anonymous">
	</script>

	<!-- Basic Javascript function that sends text to
	     the PHP login script and prints any errors that occur.-->
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
	</script>
</head>

<body>
	<!-- Be polite, we're on a public website -->
	<p>Hello World!</p>

	<!-- A simple text entry box and a button to submit the input.
	     When the button is pressed, the JS function above is called. -->
	<form onsubmit="ButtonPressed(event)" autocomplete="off">
		<input type="text" id="input" required="true">
		<input type="submit" value="Enter">	
	</form>

	<!-- This divider contains a bit of PHP code that checks
	     for a session variable and prints its value if it exists. -->
	<div>
	<?php
	if (isset($_SESSION['example']))
	{
		echo $_SESSION['example'];
	}
	?>
	</div>

	<!-- This divider will remain empty unless the JS function
	     outputs an error to it. -->
	<div id="errors">
	</div>
</body>
</html>
