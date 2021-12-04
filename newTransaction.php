<!DOCTYPE html>

<html>
<head>
    <title>New Transaction</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="header">
		<h1>Financing for Dummies</h1>
	</div>
    <ul id="navigation">
        <li><a class="button" href="home.php">Home</a></li>
        <li><a class="button" href="accountInterface.php">Accounts</a></li>
        <li><a class="button" href="analytics.php">Analytics</a></li>
        <li><a class="button" href="userRoles.php">User Roles</a></li>
        <li><a class="button" href="#top">New Transaction</a></li>
        <li><a class="button" href="settings.php">Settings</a></li>
        <li><button class="link" form="logout" name="logout">Log Out</button></li>
    </ul>

<?php
require_once "config.php";
?>

<form action="newTransaction.php" method="POST" autocomplete="off" class="tableForm">
    <p class="tableForm">
        <input class="link" type="submit" name="submit" value="CHECKING">
        <input class="link" type="submit" name="submit" value="LOAN">
        <input class="link" type="submit" name="submit" value="SAVINGS">
	</p>
    <p class="tableForm">
		<label class="tableForm">Transaction Title:</label>
        <input type="text" name="email"></label>
        <input class="link" type="submit" name="submit" value="SUBMIT">
	</p>
    <p class="tableForm">
		<label class="tableForm">Transaction Date:</label>
        <input type="text" name="email"></label>
        <input class="link" type="submit" name="submit" value="SUBMIT">
	</p>
	<p class="tableForm">
		<label class="tableForm">Transaction Amount:</label>
        <input type="text" name="email"></label>
        <input class="link" type="submit" name="submit" value="SUBMIT">
	</p>
	<p class="tableForm">
		<label class="tableForm">Transaction Category:</label>
        <input type="text" name="email"></label>
        <input class="link" type="submit" name="submit" value="SUBMIT">
	</p>
    <br/>
</form>

</body>
</html>