<!DOCTYPE html>

<?php
	require_once "config.php";
	if (!isset($_SESSION['usrID']))
    {
        header("Location: index.php");
        exit;
    }
?>

<html>
	<head>
		<title>Account Details</title>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"
			integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
			crossorigin="anonymous">
		</script>
		<link rel="stylesheet" href="style.css">
	
	<!-- Financial Accounts Overview 
		- A list of the accounts you have
		- Their respective balances
	-->
	
	</head>


	<body>
		<div id="header">
			<h1>Financing for Dummies</h1>
		</div>
	
		<div id="main">
			<p class="leftColumn">
				Financing for Dummies is an easy-to-use and free tool to
				track your spending and view basic analytics. Log in or register here!
			</p>

			<div style="margin-bottom:1em; padding-top:5px; width:210px; margin:auto;">
				<p>Don't have an account? <a href="register.php">Register</a></p>
					<?php
					if (isset($_SESSION['error']))
					{
						echo "<p class='error'>" . $_SESSION['error'] . "</p>";
						unset($_SESSION['error']);
					}
					?>
			</div>

			<div style="width:210px; margin:auto;">
				<form action="AccountAction.php" method="post" autocomplete="off" class="tableForm">
					<p class="tableForm">
						<label class="tableForm">Email:</label>
						<input type="text" name="email" required="true" class="soloInput">
					</p>
					<p class="tableForm">
						<label class="tableForm" style="padding-right:10px;">Password:</label>
						<input type="password" name="password" required="true" class="soloInput">
					</p>
					<input class="link" type="submit" name="login" value="Log In">	
				</form>
			</div>
		</div>
		
        <table>
            <tr>
                <th>Name</th>
                <th>Date</th>
				<th>Amount</th>
				<th>Category</th>
            </tr>
        </table>
		
		<div>
			<?php
				$db = get_connection();
				
				$queryFA = $db->prepare("SELECT acctID, acctName, balance FROM FinancialAccount WHERE usrID=?");
				$queryFA->bind_param("i", $_SESSION['usrID']);
				$queryFA->execute();
				$queryFA->bind_result($faID, $faName, $faBalance);
				
				$resultFA = $queryFA->get_result();

				while($rowFA = $resultFA->fetch_assoc()) {
					echo[$rowFA];
					
					$queryT = $db->prepare("SELECT transactionID, Date, Amount, Category FROM Transacts WHERE usrID=?");
					$queryT->bind_param("i", $_SESSION['usrID']);
					$queryT->execute();
					$queryT->bind_result($tID, $tDate, $tAmount, $tCategory);
				
					$resultT = $queryT->get_result();
					while($rowT = $result->fetch_assoc()) {
						echo [$rowT];
					}
				}
				
				/*
				$queryFAChecking = $db->prepare("SELECT acctID, acctName, balance FROM FinancialAccount NATURAL JOIN Checking WHERE usrID=?");
				$queryFAChecking->bind_param("i", $_SESSION['usrID']);
				$queryFAChecking->execute();
				$queryFAChecking->bind_result($faID, $faName, $faBalance);
				
				$resultFAChecking = $queryFAChecking->get_result();

				while($rowFAChecking = $resultFAChecking->fetch_assoc()) {
					echo[$rowFAChecking];
					
					$queryT = $db->prepare("SELECT transactionID, Date, Amount, Category FROM Transacts INNER JOIN FinancialAccount WHERE FinancialAccount.usrID=? AND Transacts.acctID = FinancialAccount.acctID");
					$queryT->bind_param("i", $_SESSION['usrID']);
					$queryT->execute();
					$queryT->bind_result($tID, $tDate, $tAmount, $tCategory);
				
					$resultT = $queryT->get_result();
					while($rowT = $result->fetch_assoc()) {
						echo [$rowT];
					}
				}
				
				
				$queryFASavings = $db->prepare("SELECT acctID, acctName, balance FROM FinancialAccount NATURAL JOIN Savings WHERE usrID=?");
				$queryFASavings->bind_param("i", $_SESSION['usrID']);
				$queryFASavings->execute();
				$queryFASavings->bind_result($faID, $faName, $faBalance);
				
				$resultFASavings = $queryFASavings->get_result();

				while($rowFASavings = $resultFASavings->fetch_assoc()) {
					echo[$rowFASavings];
					
					$queryT = $db->prepare("SELECT transactionID, Date, Amount, Category FROM Transacts INNER JOIN FinancialAccount WHERE FinancialAccount.usrID=? AND Transacts.acctID = FinancialAccount.acctID");
					$queryT->bind_param("i", $_SESSION['usrID']);
					$queryT->execute();
					$queryT->bind_result($tID, $tDate, $tAmount, $tCategory);
				
					$resultT = $queryT->get_result();
					while($rowT = $result->fetch_assoc()) {
						echo [$rowT];
					}
				}
				
				
				$queryFALoan = $db->prepare("SELECT acctID, acctName, balance FROM FinancialAccount NATURAL JOIN Loan WHERE usrID=?");
				$queryFALoan->bind_param("i", $_SESSION['usrID']);
				$queryFALoan->execute();
				$queryFALoan->bind_result($faID, $faName, $faBalance);
				
				$resultFALoan = $queryFALoan->get_result();

				while($rowFALoan = $resultFALoan->fetch_assoc()) {
					echo[$rowFALoan];
					
					$queryT = $db->prepare("SELECT transactionID, Date, Amount, Category FROM Transacts INNER JOIN FinancialAccount WHERE FinancialAccount.usrID=? AND Transacts.acctID = FinancialAccount.acctID");
					$queryT->bind_param("i", $_SESSION['usrID']);
					$queryT->execute();
					$queryT->bind_result($tID, $tDate, $tAmount, $tCategory);
				
					$resultT = $queryT->get_result();
					while($rowT = $result->fetch_assoc()) {
						echo [$rowT];
					}
				}
				*/
			?>
		</div>
		
		<!--Priority Checking
			- Checking
			- Credit/Loan
			- Savings
		-->
		
		
	</body>
</html>

