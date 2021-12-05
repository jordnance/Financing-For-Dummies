<!DOCTYPE html>

<?php
require_once "config.php";
?>

<html>
<head>
  <title>New Transaction</title>
  <link rel="stylesheet" href="style.css">
  <script> function checkingToggled()
	{
		let checkingbox = document.getElementById("checkingCheck");
		if (checkingbox.checked)
		{
      <?php
      $db = get_connection();
      $query = $db->prepare("SELECT acctID FROM FinancialAccount WHERE usrID=?");
      $query->bind_param('i', $SESSION['usrID']);
      if ($query->execute())
      {
        $query->bind_result($res_acctID);
        if (isset($res_acctID))
        {
          $query = $db->prepare("SELECT acctID FROM Checking WHERE acctID=?");
          $query->bind_param('i', $res_acctID);
          if ($query->execute())
          {
            $query->bind_result($res_checkingID);
          }
        }
      }
      ?>
		}
	}
	</script>
  <script> function loanToggled()
	{
		let loanbox = document.getElementById("loanCheck");
		if (loanbox.checked)
		{
      <?php 
      $query->bind_param('i', $SESSION['usrID']);
      if ($query->execute())
      {
        $query->bind_result($res_acctID);
        if (isset($res_acctID))
        {
          $query = $db->prepare("SELECT acctID FROM Loan WHERE acctID=?");
          $query->bind_param('i', $res_acctID);
          if ($query->execute())
          {
            $query->bind_result($res_loanID);
          }
        }
      }
      ?>
		}
	}
	</script>
  <script> function savingsToggled()
	{
		let savingsbox = document.getElementById("savingsCheck");
		if (savingsbox.checked)
		{
      <?php
      $query->bind_param('i', $SESSION['usrID']);
      if ($query->execute())
      {
        $query->bind_result($res_acctID);
        if (isset($res_acctID))
        {
          $query = $db->prepare("SELECT acctID FROM Savings WHERE acctID=?");
          $query->bind_param('i', $res_acctID);
          if ($query->execute())
          {
            $query->bind_result($res_savingsID);
          }
        }
      }
      ?>
		}
	}
	</script>
</head>

<body>
<?php
$acctErr = $dateErr = $amountErr = $categoryErr = "";
$acct = $date = $amount = $category = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  if (!isset($_POST['account'])) 
  {
    $acctErr = "Account is required";
  }
  else {
    $acct = $_POST['account'];
  }

  $date = test_input($_POST["date"]);

  if (empty($_POST['amount'])) 
  {
    $amountErr = "Amount is required";
  } else {
    $amount = test_input($_POST['amount']);
  }

  if (empty($_POST['category'])) 
  {
    $categoryErr = "Category is required";
  } else {
    $category = test_input($_POST['category']);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<div id="header">
	<h1>Financing for Dummies</h1>
</div>
  <ul id="navigation">
    <li><a class="button" href="home.php">Home</a></li>
    <li><a class="button" href="accountInterface.php">Accounts</a></li>
    <li><a class="button" href="analytics.php">Analytics</a></li>
    <li><a class="button" href="">User Roles</a></li>
    <li><a class="button" href="#top">New Transaction</a></li>
    <li><a class="button" href="settings.php">Settings</a></li>
    <li><button class="link" form="logout" name="logout">Log Out</button></li>
  </ul>

<p><span class="error">* required field</span></p>
<form action="newTransaction.php" method="POST" autocomplete="off" class="tableForm">
  Account type:
	<input type="radio" name="account" value="checkingCheck" onchange="checkingToggled()">Checking
  <input type="radio" name="account" value="loanCheck" onchange="loanToggled()">Loan
	<input type="radio" name="account" value="savingsCheck" onchange="savingsToggled()">Savings
  <span class="error"> * <?php echo $acctErr;?></span>
</form>

<form action="newTransaction.php" method="POST" autocomplete="off" class="tableForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
  <br>
  <p class="tableForm">
	  <label class="tableForm" style="padding-right:5px;">Transaction Title:</label>
    <input type="text" name="title"></label>
	</p>
  <p class="tableForm">
	  <label class="tableForm" style="padding-right:5px;">Transaction Date:</label>
    <input type="text" name="date"></label>
	</p>
	<p class="tableForm">
		<label class="tableForm" style="padding-right:5px;">Transaction Amount:</label>
    <input type="text" name="amount"></label>
    <span class="error">* <?php echo $amountErr;?></span>
	</p>
	<p class="tableForm">
		<label class="tableForm" style="padding-right:5px;">Transaction Category:</label>
    <input type="text" name="category"></label>
    <span class="error">* <?php echo $categoryErr;?></span>
	</p>
    <input class="link" type="submit" name="submit" value="SUBMIT"><br/>
    <br/>
</form>

<?php
if (!empty($date) && !empty($amount))
{
  $db = get_connection();
  $result = $db->prepare("INSERT INTO Transacts(usrID, acctID, Title, Date, Amount, Category) VALUES (?, ?, ?, ?, ?, ?)");
  $result->bind_param("iissds", $_SESSION['usrID']);
  $result->execute();
}
?>

</body>
<form id="logout" method="post" action="AccountAction.php"> </form>

<?php
exit
?>

</html>