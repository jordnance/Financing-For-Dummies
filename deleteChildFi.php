<!DOCTYPE html>

<head>
    <title>Delete Child Financial Account</title>

    <link rel="stylesheet" href="style.css">
          
  

    <!-- The JQuery library is needed for Javascript to invoke PHP -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"
		integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
		crossorigin="anonymous">
	</script>

</head>

<body>
    <div id="header">
		<h1>Financing for Dummies</h1>
	</div>

    <div id="main">

        <?php
            require_once "config.php";

            // Middle-tier programming to delete child account in userRoles2.php

            $usrChildAcctID = $_GET['id'];
            $db = get_connection();
            
            $queryC = $db->prepare("CALL deleteCheckingOnly(?)");
            $queryC->bind_param('i', $usrChildAcctID);
            $queryC->execute();

            $queryS = $db->prepare("CALL deleteSavingsOnly(?)");
            $queryS->bind_param('i', $usrChildAcctID);
            $queryS->execute();

            $queryL = $db->prepare("CALL deleteLoanOnly(?)");
            $queryL->bind_param('i', $usrChildAcctID);
            $queryL->execute();

            if($queryC->execute() || $queryS->execute() || $queryL->execute())
            {
                echo "<p>Sucessfully deleted the account of your Child account! </p>";
                echo "<p>Please click the go back arrow to reach the previous page.</p>";
            }

      
            else
            {
                echo "<p>Failed to delete it!</p>";
                echo "<p>Please click the go back arrow and contact our Web Master.</p>";
            }
        ?> 
    </div>
    <?php
    exit
    ?>
</html>
