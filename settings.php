<!DOCTYPE html>

<html>
<head>
    <title>Settings</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="header">
		<h1>Financing for Dummies</h1>
	</div>

<?php
require_once "config.php";
?>

<form action="settings.php" method="POST" autocomplete="off" class="tableForm">
    <p class="tableForm">
		<label class="tableForm" style="padding-right:5px;">Update Name:</label>
        <input type="text" name="fName" class="joinedInput">
		<input type="text" name="mName" class="joinedInput" style="width:50px;">
		<input type="text" name="lName" class="joinedInput">
        <input class="link" type="submit" name="submit" value="SUBMIT">
    </p>
	<p class="tableForm">
		<label class="tableForm">Update Email:</label>
        <input type="text" name="email"></label>
        <input class="link" type="submit" name="submit" value="SUBMIT">
	</p>
    <br/>
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

// Need to implement a email validation to make sure it contains "@" and ".something"
if ($email != "") {
    $db = get_connection();
    $result = $db->prepare("UPDATE User SET email=? WHERE usrID=?");
    $result->bind_param("si", $email, $_SESSION['usrID']);
    $result->execute();
    $_SESSION['email'] = $email;
}

if (!empty($first) || !empty($middle) || !empty($last) || !empty($email)) {
    echo "Your information has been updated!<br>";
}
?>

<br/><button class="link" form="home" name="home">RETURN HOME</button>
<form id="home" method="post" action="home.php"> </form>

<?php
exit;
?>

</body>
</html>