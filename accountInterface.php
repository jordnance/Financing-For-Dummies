<!DOCTYPE html>

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
		<?php
		require_once "config.php";
		?>
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
				header('Content-type: application/json');
				$db = get_connection();
				$querytext = "SELECT * FROM Transacts WHERE";		
				mysqli_multi_query($db, $querytext);
				$results = array();
					
				// If successful, return an array of rows
				$sets = 0;
				do {
					if ($result = mysqli_store_result($db)) {    
						$rs = array();
						while ($row = mysqli_fetch_assoc($result)) {
							$rs[] = $row;
						}
						$results[$sets++] = $rs;
					}
					else {
						$errMsg = mysqli_error($db);
						if (empty($errMsg)) {
							$results[$sets++] = array("status" => "OK");
						}
						else {
							$results[$sets++] = array("error" => $errMsg);
						}
            		}
				} while (mysqli_next_result($db));
				/*
				// If failure, return an object with the error message
				else {
					$results["error"] = mysqli_error($db);
				}
				*/
				echo json_encode($results);				
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

