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
        		<li><a class="button" href="#top">Accounts</a></li>
        		<li><a class="button" href="analytics.php">Analytics</a></li>
        		<li><button class="link" form ="userRoles" href="userRoles.php">User Roles</a></button>
        		<li><a class="button" href="newTransaction.php">New Transaction</a></li>
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
				
				
				echo "<table border='1'>
							<tr>
							<th>Account Name</th>
							<th>Amount</th>
							<th>Type</th>
							</tr>";
				
				while ($rowFA = $resultFA->fetch_assoc()) {
					echo "<tr>";
								echo "<td>" . $rowFA["acctName"] . "</td>";
								echo "<td>" . $rowFA["balance"] . "</td>";
								echo "<td>Checking</td>";
								echo "</tr>";
					
					echo "<tr><th>Transactions</th></tr>";
							
					
					echo "<tr>
							<th>Name</th>
							<th>Date</th>
							<th>Amount</th>
							<th>Category</th>
							</tr>";
					
					$queryT = $db->prepare("SELECT Title, Date, Amount, Category FROM Transacts NATURAL JOIN FinancialAccount WHERE acctID=?");
					$queryT->bind_param("i", $rowFA["acctID"]);
					$queryT->execute();
					$queryT->bind_result($tID, $tDate, $tAmount, $tCategory);
					
				 
					$resultT = $queryT->get_result();
					while($rowTFA = $resultT->fetch_assoc()) {
						echo "<tr>";
								echo "<td>" . $rowTFA["Title"] . "</td>";
								echo "<td>" . $rowTFA["Date"] . "</td>";
								echo "<td>" . $rowTFA["Amount"] . "</td>";
								echo "<td>" . $rowTFA["Category"] . "</td>";
								
								echo "</tr>";
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
				echo "<table border='1'>
							<tr>
							<th>Account Name</th>
							<th>Amount</th>
							<th>Type</th>
							</tr>";
				while ($rowFA = $resultFA->fetch_assoc()) {
					echo "<tr>";
								echo "<td>" . $rowFA["acctName"] . "</td>";
								echo "<td>" . $rowFA["balance"] . "</td>";
								echo "<td>Savings</td>";
								echo "</tr>";
					
					echo "<tr><th>Transactions</th></tr>";
							
					
					echo "<tr>
							<th>Name</th>
							<th>Date</th>
							<th>Amount</th>
							<th>Category</th>
							</tr>";
					
					$queryT = $db->prepare("SELECT Title, Date, Amount, Category FROM Transacts NATURAL JOIN FinancialAccount WHERE acctID=?");
					$queryT->bind_param("i", $rowFA["acctID"]);
					$queryT->execute();
					$queryT->bind_result($tID, $tDate, $tAmount, $tCategory);
					
				 
					$resultT = $queryT->get_result();
					while($rowTFA = $resultT->fetch_assoc()) {
						echo "<tr>";
								echo "<td>" . $rowTFA["Title"] . "</td>";
								echo "<td>" . $rowTFA["Date"] . "</td>";
								echo "<td>" . $rowTFA["Amount"] . "</td>";
								echo "<td>" . $rowTFA["Category"] . "</td>";
								
								echo "</tr>";
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
				
				echo "<table border='1'>
							<tr>
							<th>Account Name</th>
							<th>Amount</th>
							<th>Type</th>
							</tr>";
				while ($rowFA = $resultFA->fetch_assoc()) {
					echo "<tr>";
								echo "<td>" . $rowFA["acctName"] . "</td>";
								echo "<td>" . $rowFA["balance"] . "</td>";
								echo "<td>Loan</td>";
								echo "</tr>";
					
					echo "<tr><th>Transactions</th></tr>";
							
					
					echo "<tr>
							<th>Name</th>
							<th>Date</th>
							<th>Amount</th>
							<th>Category</th>
							</tr>";
					
					$queryT = $db->prepare("SELECT Title, Date, Amount, Category FROM Transacts NATURAL JOIN FinancialAccount WHERE acctID=?");
					$queryT->bind_param("i", $rowFA["acctID"]);
					$queryT->execute();
					$queryT->bind_result($tID, $tDate, $tAmount, $tCategory);
					
				 
					$resultT = $queryT->get_result();
					while($rowTFA = $resultT->fetch_assoc()) {
						echo "<tr>";
								echo "<td>" . $rowTFA["Title"] . "</td>";
								echo "<td>" . $rowTFA["Date"] . "</td>";
								echo "<td>" . $rowTFA["Amount"] . "</td>";
								echo "<td>" . $rowTFA["Category"] . "</td>";
								
								echo "</tr>";
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

	<!-- Added by Yeana on 12/05 -->
	<form id="userRoles" method="post" action="userRoles.php"></form>
	<form id="logout" method="post" action="AccountAction.php"></form>
</html>

