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

date_default_timezone_set('America/Los_Angeles');
error_reporting(E_ALL);
ini_set("log_errors", 1);
ini_set("display_errors", 1);

function get_connection() {
    static $connection;
    if (!isset($connection)) {
        $connection = mysqli_connect('localhost', 'financingfordummies', 'seimmudrofgnicnanif3420', 'financingfordummies') 
            or die(mysqli_connect_error());
    }
    if ($connection === false) {
        echo "Unable to connect to database<br/>";
        echo mysqli_connect_error();
    }
    return $connection;
}

//Get a connection, prepare a query, and execute it
$db = get_connection();
$query = $db->prepare("SELECT Email, fName, mName, lName FROM User"); // How to get the user's info for the query?
$query->execute();
$result = $query->get_result();
?>

<form action="settings.php" method="POST" autocomplete="off" class="tableForm">
    <p class="tableForm">
		<label class="tableForm" style="padding-right:5px;">Update Name:</label>
        <input type="text" name="fName" required="true" class="joinedInput">
		<input type="text" name="mName" class="joinedInput" style="width:50px;">
		<input type="text" name="lName" required="true" class="joinedInput">
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
if (isset($_POST["name"]) && $_POST["name"] != "") {
    echo "Name updated to: " . $_POST['name'] . " <br>";
}

if (isset($_POST["email"]) && $_POST["email"] != "") {
    echo "Email updated to: " . $_POST['email'] . " <br>";
}
?>

<button class="link" form="home" name="home">RETURN HOME</button>
<form id="home" method="post" action="home.php"> </form>

</body>
</html>