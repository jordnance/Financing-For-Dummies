<!-- 
	To Do:
	If the account is a child, need to be able to enter adult's email
	to link accounts. Also need to modify addUser to incorporate this.
-->

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
	<div style="margin-bottom:1em;">
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
			<input type="email" name="email" required="true" class="soloInput" style="width:255px;">
		</p>
        
        <p class="tableForm">
			<label class="tableForm" style="padding-right:5px;">Phone Number (optional):</label>
			<input type="tel" name="phone" class="soloInput" style="width:255px;">
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