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
		<div>
			
			<?php
				$db = get_connection();
			
				$queryFA = $db->prepare("SELECT acctID, acctName, balance FROM FinancialAccount NATURAL JOIN Checking WHERE usrID=?");
				$queryFA->bind_param("i", $_SESSION['usrID']);
				$queryFA->execute();
				$queryFA->bind_result($faID, $faName, $faBalance);
				
				$resultFA = $queryFA->get_result();
				
				while ($rowFA = $resultFA->fetch_assoc()) {
					echo "<h2>Account Name &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; Amount<h2>";
					
					printf("%s", $rowFA["acctName"]);
					echo "<b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</b>";
					printf("$%8.2f", $rowFA["balance"]);
					
					echo "<br/><br/>";
					echo "<b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Transactions</b><br/><br/>";
					
					echo "<tr>";
					echo "<table>";
					echo "<th>Name&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>";
					echo "<th>Date&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>";
					echo "<th>Amount&emsp;&emsp;&emsp;&emsp;&emsp;</th>";
					echo "<th>Category</th>";
					echo "</tr>";
					echo "</table>";
					
					$queryT = $db->prepare("SELECT Title, Date, Amount, Category FROM Transacts NATURAL JOIN FinancialAccount WHERE acctID=?");
					$queryT->bind_param("i", $rowFA["acctID"]);
					$queryT->execute();
					$queryT->bind_result($tID, $tDate, $tAmount, $tCategory);
					
				 
					$resultT = $queryT->get_result();
					while($rowTFA = $resultT->fetch_assoc()) {
						printf("%s", $rowTFA["Title"]);
						echo "<b>&emsp;&emsp;&emsp;&emsp;&emsp;</b>";
						printf("%s", $rowTFA["Date"]);
						echo "<b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;</b>";
						printf("$%8.2f", $rowTFA["Amount"]);
						echo "<b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</b>";
						printf("%s", $rowTFA["Category"]);
						
						echo "<br/>";
					}
					
				}
				echo "<br/><br/><br/>";	
			?>
			
			<?php
				$queryFA = $db->prepare("SELECT acctID, acctName, balance FROM FinancialAccount NATURAL JOIN Savings WHERE usrID=?");
				$queryFA->bind_param("i", $_SESSION['usrID']);
				$queryFA->execute();
				$queryFA->bind_result($faID, $faName, $faBalance);
				
				$resultFA = $queryFA->get_result();
				
				while ($rowFA = $resultFA->fetch_assoc()) {
					echo "<h2>Account Name &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; Amount<h2>";
					
					printf("%s", $rowFA["acctName"]);
					echo "<b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</b>";
					printf("$%8.2f", $rowFA["balance"]);
					
					echo "<br/><br/>";
					echo "<b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Transactions</b><br/><br/>";
					
					echo "<tr>";
					echo "<table>";
					echo "<th>Name&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>";
					echo "<th>Date&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>";
					echo "<th>Amount&emsp;&emsp;&emsp;&emsp;&emsp;</th>";
					echo "<th>Category</th>";
					echo "</tr>";
					echo "</table>";
					
					$queryT = $db->prepare("SELECT Title, Date, Amount, Category FROM Transacts NATURAL JOIN FinancialAccount WHERE acctID=?");
					$queryT->bind_param("i", $rowFA["acctID"]);
					$queryT->execute();
					$queryT->bind_result($tID, $tDate, $tAmount, $tCategory);
					
				 
					$resultT = $queryT->get_result();
					while($rowTFA = $resultT->fetch_assoc()) {
						printf("%s", $rowTFA["Title"]);
						echo "<b>&emsp;&emsp;&emsp;&emsp;&emsp;</b>";
						printf("%s", $rowTFA["Date"]);
						echo "<b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;</b>";
						printf("$%8.2f", $rowTFA["Amount"]);
						echo "<b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</b>";
						printf("%s", $rowTFA["Category"]);
						
						echo "<br/>";
					}
					
				}
				echo "<br/><br/><br/>";	
			?>
			
			
			<?php
				$queryFA = $db->prepare("SELECT acctID, acctName, balance FROM FinancialAccount NATURAL JOIN Loan WHERE usrID=?");
				$queryFA->bind_param("i", $_SESSION['usrID']);
				$queryFA->execute();
				$queryFA->bind_result($faID, $faName, $faBalance);
				
				$resultFA = $queryFA->get_result();
				
				while ($rowFA = $resultFA->fetch_assoc()) {
					echo "<h2>Account Name &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; Amount<h2>";
					
					printf("%s", $rowFA["acctName"]);
					echo "<b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</b>";
					printf("$%8.2f", $rowFA["balance"]);
					
					echo "<br/><br/>";
					echo "<b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Transactions</b><br/><br/>";
					
					echo "<tr>";
					echo "<table>";
					echo "<th>Name&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>";
					echo "<th>Date&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>";
					echo "<th>Amount&emsp;&emsp;&emsp;&emsp;&emsp;</th>";
					echo "<th>Category</th>";
					echo "</tr>";
					echo "</table>";
					
					$queryT = $db->prepare("SELECT Title, Date, Amount, Category FROM Transacts NATURAL JOIN FinancialAccount WHERE acctID=?");
					$queryT->bind_param("i", $rowFA["acctID"]);
					$queryT->execute();
					$queryT->bind_result($tID, $tDate, $tAmount, $tCategory);
					
				 
					$resultT = $queryT->get_result();
					while($rowTFA = $resultT->fetch_assoc()) {
						printf("%s", $rowTFA["Title"]);
						echo "<b>&emsp;&emsp;&emsp;&emsp;&emsp;</b>";
						printf("%s", $rowTFA["Date"]);
						echo "<b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;</b>";
						printf("$%8.2f", $rowTFA["Amount"]);
						echo "<b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</b>";
						printf("%s", $rowTFA["Category"]);
						
						echo "<br/>";
					}
					
				}
				echo "<br/><br/><br/>";	
			?>
			
		</div>

		<!--Priority Checking
			- Checking
			- Credit/Loan
			- Savings
		-->

	</body>
</html>

