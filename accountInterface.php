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
						<a class="button" style="display:block;" href="newFinancialAccount.php">Account</a>
						<a class="button" style="display:block;" href="newTransaction.php">Transaction</a>
						<a class="button" style="display:block;" href="thresholds.php">Threshold</a>
					</div>
				</li>
			</div>

			<li><a class="button" href="settings.php">Settings</a></li>

			<li><button class="link" form="logout" name="logout">Log Out</button></li>
		</ul>

		
			<?php
				$checkingStatus = 'unchecked';
				$loanStatus = 'unchecked';
				$savingsStatus = 'unchecked';
				
				$db = get_connection();
			
				$queryFA = $db->prepare("SELECT acctID, acctName, balance FROM FinancialAccount NATURAL JOIN Checking WHERE usrID=?");
				$queryFA->bind_param("i", $_SESSION['usrID']);
				$queryFA->execute();
				//$queryFA->bind_result($faID, $faName, $faBalance);

                				
				$resultFA = $queryFA->get_result();
				
				while ($rowFA = $resultFA->fetch_assoc()) {
					$checkingStatus = 'checked';
					echo "<table border='1'>
							<tr>
							<th>Account Name</th>
							<th>Amount</th>
							<th>Type</th>
                                                        <th style='background-color:#488AC7'>Action</th>
							</tr>";
					
					echo "<tr>";
					echo "<td>" . $rowFA["acctName"] . "</td>";
					echo "<td>$" . $rowFA["balance"] . "</td>";
					echo "<td>Checking</td>";
                                        echo "<td><a href = 'deleteFiAcct.php?id=$rowFA[acctID]'
                                        >Delete this financial account</td>"; 
					echo "</tr>";
					
					echo "<tr><th>Transactions</th></tr>";
							
					
					echo "<tr>
							<th>Name</th>
							<th>Date</th>
							<th>Amount ($)</th>
							<th>Category</th>
							</tr>";
					
					$queryT = $db->prepare("SELECT Title, Date, Amount, Category FROM Transacts NATURAL JOIN FinancialAccount WHERE acctID=? ORDER BY Date");
					$queryT->bind_param("i", $rowFA["acctID"]);
					$queryT->execute();
					//$queryT->bind_result($tID, $tDate, $tAmount, $tCategory);
					
				 
					$resultT = $queryT->get_result();
					while($rowTFA = $resultT->fetch_assoc()) {
						echo "<tr>";
								echo "<td>" . $rowTFA["Title"] . "</td>";
								echo "<td>" . $rowTFA["Date"] . "</td>";
								echo "<td>" . $rowTFA["Amount"] . "</td>";
								echo "<td>" . $rowTFA["Category"] . "</td>";
								
								echo "</tr>";
					}
					$queryT->close();
				}
				$queryFA->close();
				echo "<br/><br/><br/>";	
			?>
			
			<?php
				$queryFA = $db->prepare("SELECT acctID, acctName, balance FROM FinancialAccount NATURAL JOIN Savings WHERE usrID=?");
				$queryFA->bind_param("i", $_SESSION['usrID']);
				$queryFA->execute();
				//$queryFA->bind_result($faID, $faName, $faBalance);
				
				$resultFA = $queryFA->get_result();
		
				while ($rowFA = $resultFA->fetch_assoc()) {
					$savingsStatus = 'checked';
					echo "<table border='1'>
							<tr>
							<th>Account Name</th>
							<th>Amount</th>
							<th>Type</th>
                            <th style='background-color:#488AC7'>Action</th>
							</tr>";
					
					echo "<tr>";
					echo "<td>" . $rowFA["acctName"] . "</td>";
					echo "<td>$" . $rowFA["balance"] . "</td>";
					echo "<td>Savings</td>";
                                        echo "<td><a href = 'deleteFiAcct.php?id=$rowFA[acctID]'
                                        >Delete this financial account</td>";
					echo "</tr>";
					
					echo "<tr><th>Transactions</th></tr>";
							
					
					echo "<tr>
							<th>Name</th>
							<th>Date</th>
							<th>Amount ($)</th>
							<th>Category</th>
							</tr>";
					
					$queryT = $db->prepare("SELECT Title, Date, Amount, Category FROM Transacts NATURAL JOIN FinancialAccount WHERE acctID=?");
					$queryT->bind_param("i", $rowFA["acctID"]);
					$queryT->execute();
					//$queryT->bind_result($tID, $tDate, $tAmount, $tCategory);
					
				 
					$resultT = $queryT->get_result();
					while($rowTFA = $resultT->fetch_assoc()) {
						echo "<tr>";
								echo "<td>" . $rowTFA["Title"] . "</td>";
								echo "<td>" . $rowTFA["Date"] . "</td>";
								echo "<td>" . $rowTFA["Amount"] . "</td>";
								echo "<td>" . $rowTFA["Category"] . "</td>";
								
								echo "</tr>";
					}
					$queryT->close();
				}
				$queryFA->close();
				echo "<br/><br/><br/>";	
			?>
			
			
			<?php
				$queryFA = $db->prepare("SELECT acctID, acctName, balance FROM FinancialAccount NATURAL JOIN Loan WHERE usrID=?");
				$queryFA->bind_param("i", $_SESSION['usrID']);
				$queryFA->execute();
				//$queryFA->bind_result($faID, $faName, $faBalance);
				
				$resultFA = $queryFA->get_result();
				
				while ($rowFA = $resultFA->fetch_assoc()) {
					$loanStatus = 'checked';
					echo "<table border='1'>
							<tr>
							<th>Account Name</th>
							<th>Amount</th>
							<th>Type</th>
                            <th style='background-color:#488AC7'>Action</th>
							</tr>";
					
					echo "<tr>";
								echo "<td>" . $rowFA["acctName"] . "</td>";
								echo "<td>$" . $rowFA["balance"] . "</td>";
								echo "<td>Loan</td>";
                                                                echo "<td><a href = 'deleteFiAcct.php?id=$rowFA[acctID]'
                                                                >Delete this financial account</td>";
								echo "</tr>";
					
					echo "<tr><th>Transactions</th></tr>";
							
					
					echo "<tr>
							<th>Name</th>
							<th>Date</th>
							<th>Amount ($)</th>
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
					$queryT->close();
				}
				$queryFA->close();

				if ($checkingStatus != 'checked' && $savingsStatus != 'checked' && $loanStatus != 'checked') {
					echo "<h2>No accounts found...</h2>";
					echo "<p>Currently, you do NOT any financial accounts within our app.</p>
                                        <p>You can add one and start logging your financial activities by clicking CREATE NEW any time.</p>";
				}
				echo "<br/><br/><br/>";	
			?>


	

	</body>

	
	<form id="logout" method="post" action="AccountAction.php"></form>
</html>
