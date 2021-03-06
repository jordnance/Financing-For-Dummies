<!DOCTYPE html>

<?php
    require_once "config.php";

    // Don't let anyone who is logged in onto this page
    if (isset($_SESSION['usrID']))
    {
        header("Location: home.php");
        exit;
    }
?>

<html>
<head>
    <title>Register Account</title>

    <link rel="stylesheet" href="style.css">

	<script> function childToggled()
	{
		let checkbox = document.getElementById("childCheckbox");
		let additionalDiv = document.getElementById("adultInfo");
		let additionalField = document.getElementById("adultEmail");

		if (checkbox.checked)
		{
			additionalDiv.style.display = "table-row";
			additionalField.required = true;
		}
		else
		{
			additionalDiv.style.display = "none";
			additionalField.required = false;
		}
	}
	</script>

</head>

<body>
	<div id="header">
		<h1>Financing for Dummies</h1>
	</div>

	<!-- "width:37%; margin:auto; padding-top:5px;" -->
	<div id="main" style="width:425px; margin:auto; padding-top:5px;">
		<div style="margin-bottom:1em;">
			<p>Already have an account? <a href="index.php">Log In</a></p>
			<?php
				if (isset($_SESSION['error']))
				{
					echo "<p class='error'>" . $_SESSION['error'] . "</p>";
					unset($_SESSION['error']);
				}
			?>
		</div>

		<form action="AccountAction.php" method="post" autocomplete="off" class="tableForm">
			<p class="tableForm">
				<label class="tableForm">Name:</label>
				<input type="text" name="fName" required="true" class="joinedInput">
				<input type="text" name="mName" class="joinedInput" style="width:50px;">
				<input type="text" name="lName" required="true" class="joinedInput">
			</p>

			<p class="tableForm">
				<label class="tableForm">Email:</label>
				<input type="email" name="email" required="true" class="soloInput">
			</p>
			
			<p class="tableForm">
				<label class="tableForm" style="padding-right:5px;">Phone Number (optional):</label>
				<input type="tel" name="phone" class="soloInput">
			</p>
			
			<p class="tableForm">
				<label class="tableForm">Birthday:</label>
				<input type="date" name="birthday" required="true" class="soloInput">
			</p>

			<p class="tableForm">
				<label class="tableForm">Password:</label>
				<input type="password" name="password" required="true" class="soloInput">
			</p>

			<label>Child Account:</label>
			<input type="checkbox" name="child" id="childCheckbox" onchange="childToggled()">

			<p class="tableForm" id="adultInfo" style="display:none;">
				<label class="tableForm">Parent's Email:</label>
				<input type="email" name="adultEmail" id="adultEmail" class="soloInput">
			</p>

			<br/>

			<input class="link" type="submit" name="register" value="Register">
		</form>
	</div>
</body>
</html>