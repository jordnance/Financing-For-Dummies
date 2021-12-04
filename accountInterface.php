<!DOCTYPE html>

<?php
	require_once "config.php";
?>
<html>
	<head>
		<title>Account Details</title>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"
			integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
			crossorigin="anonymous">
		</script>
		<style>
body {
    margin:40px auto;
    max-width:650px;
    line-height:1.6;
    font-size:18px;
    color:#444;
    padding:0 10px
	font-family: Georgia, 'Times New Roman', Times, serif; 
}

h1,h2,h3 {
    line-height:1.2
}

.query {
    width: 400px;
    height: 200px;
}

table, th, td { 
	border: 2px black; 
    border-style: ridge;
    text-align:center;
}

th, td  {
	padding: 10px;
	width: 400px;
}

table {
	width: 700;
    height: 550;
}
th {
	font-weight: 700;
    font-size-adjust: 0.55;
    color: black;
    }
.total {
	font-weight: 700;
    }
		</style>
	
	<!-- Financial Accounts Overview 
		- A list of the accounts you have
		- Their respective balances
	-->
	
	</head>


	<body>
		<div>
			<?php
				echo "Hello, " . $_SESSION['username'];
				echo "<br/><a href=\"logout.php\">Log out</a><br/>";
			?>
		</div>
		
		<h2>Financial Account Transactions Table Prototype</h2>
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
				$query = $db->prepare("SELECT transactionID, Date, Amount, Category FROM Transacts WHERE usrID=?");
				$query->bind_param("i", $_SESSION['usrID']);
				$query->execute();
				$query->bind_result($tID, $tDate, $tAmount, $tCategory);
				while($row = mysql_fetch_array($query)) {
					echo print_r($row);
				}
			?>
		</div>
		
		
		<!-- Divider will contain the needed portion to connect to the DB, select values, and print them onto the webpage-->
		
		<!--Priority Checking
			- Checking
			- Credit/Loan
			- Savings
		-->
		
		
	</body>
</html>

