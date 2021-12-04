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
    		<ul id="navigation">
        		<li><a class="button" href="home.php">Home</a></li>
        		<li><a class="button" href="accountInterface.php">Accounts</a></li>
        		<li><a class="button" href="analytics.php">Analytics</a></li>
        		<li><a class="button" href="userRoles.php">User Roles</a></li>
        		<li><a class="button" href="#top">New Transaction</a></li>
        		<li><a class="button" href="settings.php">Settings</a></li>
        		<li><button class="link" form="logout" name="logout">Log Out</button></li>
   		</ul>
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

