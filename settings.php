<!DOCTYPE html>

<html>
<head>
    <title>Settings</title>
    <link rel="stylesheet" href="style.css">
</head>

<?php
require_once "config.php";

if (!isset($_SESSION['usrID']))
{
    header("Location: index.php");
    exit;
}
?>

<body>
    <div id="header">
		<h1>Financing for Dummies</h1>
	</div>
    <ul id="navigation">
        <li><a class="button" href="home.php">Home</a></li>
        
        <div class="dropdown">
            <li class="menu">Financial Accounts
                <div class="dropdown-content">
                    <a class="button" style="display:block;" href="accountInterface.php">My Accounts</a>
                    <a class="button" style="display:block;" href="userRoles.php">Child Accounts</a>
                    <a class="button" style="display:block;" href="analytics.php">Generate Report</a>
                </div>
            </li>
        </div>

        <div class="dropdown">
            <li class="menu">Create New
                <div class="dropdown-content" style="left: -15px;">
                    <a class="button" style="display:block;" href="">Account</a>
                    <a class="button" style="display:block;" href="newTransaction.php">Transaction</a>
                    <a class="button" style="display:block;" href="">Threshold</a>
                </div>
            </li>
        </div>

        <li><a class="button" href="settings.php">Settings</a></li>

        <li><button class="link" form="logout" name="logout">Log Out</button></li>
    </ul>

<form action="settings.php" method="POST" autocomplete="off" class="tableForm">
    <br/><br/>
    <p class="tableForm">
		<label class="tableForm" style="padding-right:5px;">Update Name:</label>
        <input type="text" name="fName" class="joinedInput">
		<input type="text" name="mName" class="joinedInput" style="width:50px;">
		<input type="text" name="lName" class="joinedInput">
    </p>
	<p class="tableForm">
		<label class="tableForm">Update Email:</label>
        <input type="text" name="email" style= width:250px></label>
	</p>
    <input class="link" type="submit" name="submit" value="SUBMIT"><br/>
</form>

<?php
$email = $_POST['email'];
$first = $_POST['fName'];
$middle = $_POST['mName'];
$last = $_POST['lName'];

if ($first != "") {
    $db = get_connection();
    $result = $db->prepare("UPDATE User SET fName=? WHERE usrID=?");
    $result->bind_param("si", $first, $_SESSION['usrID']);
    $result->execute();
    $_SESSION['fName'] = $first;
}

if ($middle != "") {
    $db = get_connection();
    $result = $db->prepare("UPDATE User SET mName=? WHERE usrID=?");
    $result->bind_param("si", $middle, $_SESSION['usrID']);
    $_SESSION['mName'] = $middle;
}

if ($last != "") {
    $db = get_connection();
    $result = $db->prepare("UPDATE User SET lName=? WHERE usrID=?");
    $result->bind_param("si", $last, $_SESSION['usrID']);
    $result->execute();
    $_SESSION['lName'] = $last;
}

if ($email != "") {
    $db = get_connection();
    $result = $db->prepare("UPDATE User SET email=? WHERE usrID=?");
    $result->bind_param("si", $email, $_SESSION['usrID']);
    $result->execute();
    $_SESSION['email'] = $email;
}

if (!empty($first) || !empty($middle) || !empty($last) || !empty($email)) {
    echo "<br>Your information has been updated!<br>";
}
?>

</body>
<form id="logout" method="post" action="AccountAction.php"></form>

<?php
exit
?>

</html>
