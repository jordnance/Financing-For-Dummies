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

$email = $_POST['email'];
$first = $_POST['fName'];
$middle = $_POST['mName'];
$last = $_POST['lName'];

$db = get_connection();
$query = $db->prepare("SELECT Email, fName, mName, lName FROM User WHERE Email=? AND fName=? AND mName=? AND lName=?");
$query->bind_param("ssss", $email, $first, $middle, $last);
$query->execute();

//$query->bind_result($res_email, $res_first, $res_middle, $res_last);
//$query->fetch();
//printf("%s %s %s %s\n", $res_email, $res_first, $res_middle, $res_last);

//if ($result)
//{
//	$result->bind_result($res_email, $res_first, $res_middle, $res_last);
//}
//else
//{
//    $_SESSION['error'] = "Unable to execute query";
//}

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo "Email: " . $row["Email"]. " - First Name: " . $row["fName"]. " " . $row["mName"].  " " . $row["lName"]. "<br>";
    }
} else {
  echo "0 results";
}
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
if (isset($_POST["fName"], $_POST["lName"]) && $_POST["fName"] != "" && $_POST["lName"] != "") {
    echo "Name updated to: " . $_POST['fName'] . " " . $_POST['mName'] . " " . $_POST['lName'] ." <br>";
}
if (isset($_POST["email"]) && $_POST["email"] != "") {
    echo "Email updated to: " . $_POST['email'] . " <br>";
}
unset($_POST['email']);
unset($_POST['fName']);
unset($_POST['mName']);
unset($_POST['lName']);
?>

<br/>
<button class="link" form="home" name="home">RETURN HOME</button>
<form id="home" method="post" action="home.php"> </form>

</body>
</html>