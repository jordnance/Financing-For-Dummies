<!DOCTYPE html>

<?php
	require_once "config.php";

	// If the user is already logged in, redirect to their home page
    if (isset($_SESSION['usrID']))
    {
        header("Location: home.php");
        exit;
    }
?>

<html>
<head>
	<title>Log In</title>

	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div id="header">
		<h1>Financing for Dummies</h1>
	</div>
	
	<div id="main">
		<p class="leftColumn">
			Financing for Dummies is an easy-to-use and free tool to
			track your spending and view basic analytics. Log in or register here!
		</p>

		<div style="margin-bottom:1em; padding-top:5px; width:210px; margin:auto;">
			<p>Don't have an account? <a href="register.php">Register</a></p>
			<?php
				if (isset($_SESSION['error']))
				{
					echo "<p class='error'>" . $_SESSION['error'] . "</p>";
					unset($_SESSION['error']);
				}
			?>
		</div>

		<div style="width:210px; margin:auto;">
			<form action="AccountAction.php" method="post" autocomplete="off" class="tableForm">
				<p class="tableForm">
					<label class="tableForm">Email:</label>
					<input type="text" name="email" required="true" class="soloInput">
				</p>
				<p class="tableForm">
					<label class="tableForm" style="padding-right:10px;">Password:</label>
					<input type="password" name="password" required="true" class="soloInput">
				</p>
				<input class="link" type="submit" name="login" value="Log In">	
			</form>
		</div>
	</div>
</body>
</html>
