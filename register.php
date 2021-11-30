<!DOCTYPE html>

<?php
    require_once "config.php";

    // Don't let anyone who is logged in onto this page
    if (isset($_SESSION['usrID']))
    {
        header("Location: index.php");
        exit;
    }
?>

<html>
<head>
    <title>Register Account</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="AccountAction.php" method="post" autocomplete="off" class="tableForm">
		<p class="tableForm">
			<label class="tableForm">Name:</label>
			<input type="text" name="fName" required="true" class="joinedInput">
			<input type="text" name="mName" required="false" class="joinedInput" style="width:50px;">
			<input type="text" name="lName" required="true" class="joinedInput">
		</p>

        <p class="tableForm">
			<label class="tableForm">Email:</label>
			<input type="email" name="email" required="true" class="soloInput" style="width:255px;">
		</p>
        
        <p class="tableForm">
			<label class="tableForm" style="padding-right:5px;">Phone Number (optional):</label>
			<input type="tel" name="phone" required="false" class="soloInput" style="width:255px;">
		</p>
        
        <p class="tableForm">
			<label class="tableForm">Birthday:</label>
			<input type="date" name="birthday" required="true" class="soloInput" style="width:255px;">
		</p>

		<p class="tableForm">
			<label class="tableForm">Password:</label>
			<input type="password" name="password" required="true" class="soloInput" style="width:255px;">
		</p>

		<label>Child Account:</label>
		<input type="checkbox" name="child" value="Child Account">

        <br/>

		<input type="submit" name="register" value="Register">
	</form>
</body>
</html>