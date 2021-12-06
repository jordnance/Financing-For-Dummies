<!DOCTYPE html>

<?php
require_once "config.php";
?>

<html>
<head>
  <title>New Transaction</title>
  <link rel="stylesheet" href="style.css">

  <?php


  function isSelected()
	{  
    if (isset($_POST['account'])) 
    {
      if($account = $_POST('account')) 
      {
        $db = get_connection();
        $query = $db->prepare("SELECT acctID FROM FinancialAccount WHERE usrID=?");
        $query->bind_param('i', $_SESSION['usrID']);
        if ($query->execute()) 
        {
          $query->bind_result($res_acctID);
          return $res_accID;
        }
  	  }
	  }
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  //unset($_SESSION['acct']);
  //unset($_SESSION['title']);
  //unset($_SESSION['date']);
  //unset($_SESSION['amount']);
  //unset($_SESSION['category']);
  //unset($_POST['acct']);
  //unset($_POST['title']);
  //unset($_POST['date']);
  //unset($_POST['amount']);
  //unset($_POST['category']);

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
    $date = test_input($_POST["date"]);
    //$date = $_POST["date"];

    if (empty($_POST['amount'])) {
      $amountErr = "Amount is required";
    } 
    else {
      $amount = test_input($_POST['amount']);
      //$amount = $_POST['amount'];
    }

    if (empty($_POST['category'])) {
      $categoryErr = "Category is required";
    } 
    else {
      $category = test_input($_POST['category']);
      //$category = $_POST['category'];
    }
  }

  if (!empty($acct)) {
    $result = isSelected();
    if (isset($result)) 
    {
      $query = $db->prepare("SELECT acctID FROM Checking WHERE acctID=?");
      $query->bind_param('i', $result);
      if ($query->execute())
      {
        $query->bind_result($resID);
        if (empty($resID))
        {
          $query = $db->prepare("SELECT acctID FROM Loan WHERE acctID=?");
          $query->bind_param('i', $result);
          if ($query->execute())
          {
            $query->bind_result($resID);
            if (empty($resID))
            {
              $query = $db->prepare("SELECT acctID FROM Savings WHERE acctID=?");
              $query->bind_param('i', $result);
              if ($query->execute())
              {
                $query->bind_result($resID);
              }
            }
          }
        }
      }
    } 
  }
  ?>
	
</head>

<body>
<?php
?>

<div id="header">
	<h1>Financing for Dummies</h1>
</div>
  <ul id="navigation">
    <li><a class="button" href="home.php">Home</a></li>
    <li><a class="button" href="accountInterface.php">Accounts</a></li>
    <li><a class="button" href="analytics.php">Analytics</a></li>
    <li><button class="link" form ="userRoles" href="userRoles.php">User Roles</a></button>
    <li><a class="button" href="#top">New Transaction</a></li>
    <li><a class="button" href="settings.php">Settings</a></li>
    <li><button class="link" form="logout" name="logout">Log Out</button></li>
  </ul>

<p><span class="error">* required field</span></p>
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
    <span class="error">* <?php echo $amountErr;?></span>
	</p>
	<p class="tableForm">
		<label class="tableForm" style="padding-right:5px;">Transaction Category:</label>
    <input type="text" name="category" style="width:165px;"></label>
    <span class="error">* <?php echo $categoryErr;?></span>
	</p>
  <input class="link" type="submit" name="submit" value="SUBMIT"><br/><br/>
</form>

<?php
if (!empty($account) && !empty($amount) && !empty($category))
{
  $db = get_connection();
  $result = $db->prepare("INSERT INTO Transacts(usrID, acctID, Title, Date, Amount, Category) VALUES (?, ?, ?, ?, ?, ?)");
  $result->bind_param("iisssds", $_SESSION['usrID'], $acct, $title, $date, $amount, $category);
  $result->execute();
  echo "Your transaction has been added!<br>";
}
?>

</body>
<form id="logout" method="post" action="AccountAction.php"> </form>
<!-- Added by Yeana on 12/05 -->
<form id="userRoles" method="post" action="userRoles.php"></form>

<?php
exit
?>

</html>