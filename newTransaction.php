<!DOCTYPE html>

<?php
require_once "config.php";

if (!isset($_SESSION['usrID']))
{
    header("Location: index.php");
    exit;
}

unset($acct);
unset($resID);
unset($title);
unset($date);
unset($amount);
unset($category);

$acctErr = $dateErr = $amountErr = $categoryErr = "";
$acct = $title = $date = $amount = $category = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  if (empty($_POST['account'])) {
    $acctErr = "Account is required";
  }
  else {
    $acct = $_POST['account'];
  }

  $title = $_POST['title'];
  $date = test_input($_POST['date']);
  //$new_date = date('Y-m-d', $date);

  if (empty($_POST['amount'])) {
    $amountErr = "Amount is required";
  } 
  else {
    $amount = test_input($_POST['amount']);
  }
  if (empty($_POST['category'])) {
    $categoryErr = "Category is required";
  } 
  else {
    $category = test_input($_POST['category']);
  }
}
?>

<html>
<head>
  <title>New Transaction</title>
  <link rel="stylesheet" href="style.css">

  <?php
  function test_input($data) 
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  ?>

</head>
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

<p><span class="error"> * required field</span></p>
<form action="newTransaction.php" method="POST" autocomplete="off" class="tableForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
  <p class="tableForm" style="width:300px;">
    <label class="tableForm">Account type:</label>
    <label class="tableForm">
      <input type="radio" name="account" id="checking">Checking
      <input type="radio" name="account" id="loan">Loan
      <input type="radio" name="account" id="savings">Savings
      <span class="error"> * <?php echo $acctErr;?></span>
    </label>
  </p>
  <br/>
  <p class="tableForm">
	  <label class="tableForm" style="padding-right:5px;">Transaction Title:</label>
    <input type="text" name="title" style="width:165px;"></label>
	</p>
  <p class="tableForm">
	  <label class="tableForm" style="padding-right:5px;">Transaction Date:</label>
    <input type="text" name="date" style="width:165px;"></label>
	</p>
	<p class="tableForm">
		<label class="tableForm" style="padding-right:5px;">Transaction Amount:</label>
    <input type="text" name="amount" style="width:165px;"></label>
    <span class="error"> * <?php echo $amountErr;?></span>
	</p>
	<p class="tableForm">
		<label class="tableForm" style="padding-right:5px;">Transaction Category:</label>
    <input type="text" name="category" style="width:165px;"></label>
    <span class="error"> * <?php echo $categoryErr;?></span>
	</p>
  <input class="link" type="submit" name="submit" value="SUBMIT"><br/><br/>
</form>

<?php
$found = false;
$db = get_connection();
while (!$found)
{
  $query = $db->prepare("SELECT acctID FROM Checking NATURAL JOIN FinancialAccount WHERE usrID=?");
  $query->bind_param('i', $_SESSION['usrID']);
  $query->execute();
  $query->bind_result($acct);
  if ($query->fetch()) {
    $found = true;
    $query->close();
    break;
  }

  $query = $db->prepare("SELECT acctID FROM Loan NATURAL JOIN FinancialAccount WHERE usrID=?");
  $query->bind_param('i', $_SESSION['usrID']);
  $query->execute();
  $query->bind_result($acct);
  if ($query->fetch()) {
    $found = true;
    $query->close();
    break;
  }
  
  $query = $db->prepare("SELECT acctID FROM Savings NATURAL JOIN FinancialAccount WHERE usrID=?");
  $query->bind_param('i', $_SESSION['usrID']);
  $query->execute();
  $query->bind_result($acct);
  if ($query->fetch()) {
    $found = true;
    $query->close();
    break;
  }
  break;
}

if (isset($acct) && isset($amount) && isset($category) && !empty($acct) && !empty($amount) && !empty($category))
{
  $result = $db->prepare("INSERT INTO Transacts (usrID, acctID, Title, Date, Amount, Category) VALUES (?, ?, ?, ?, ?, ?)");
  $result->bind_param('iissds', $_SESSION['usrID'], $acct, $title, $date, $amount, $category);
  $result->execute();
  echo "Your transaction has been added!<br>";
}
?>

</body>
<form id="logout" method="post" action="AccountAction.php"> </form>

<?php
exit
?>

</html>