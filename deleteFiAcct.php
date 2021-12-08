<!-- deleteFiAccount.php is created because it
has more general messages different from the ones in deleteChildFi.php
after deleting a financial account of any type of user in accountInterface.php -->

<!DOCTYPE html>

<head>
    <title>Delete a Financial Account</title>

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

            // Middle-tier programming to delete financial account in accountInterface.php

            $usrFiAcctID = $_GET['id'];
            $db = get_connection();
            
            $queryC = $db->prepare("CALL deleteCheckingOnly(?)");
            $queryC->bind_param('i', $usrFiAcctID);
            $queryC->execute();

            $queryS = $db->prepare("CALL deleteSavingsOnly(?)");
            $queryS->bind_param('i', $usrFiAcctID);
            $queryS->execute();

            $queryL = $db->prepare("CALL deleteLoanOnly(?)");
            $queryL->bind_param('i', $usrFiAcctID);
            $queryL->execute();

           
            
            if($queryC->execute())
            {

                echo "<p>Sucessfully deleted your CHECKING account! </p>";
                echo "<p>Please click the go back arrow to reach the previous page.</p>";
            }

                  

            elseif($queryS->execute())
            {

                echo "<p>Sucessfully deleted your SAVINGS account! </p>";
                echo "<p>Please click the go back arrow to reach the previous page.</p>";
            }

           

            elseif($queryL->execute())
            {
                echo "<p>Sucessfully deleted your LOAN account!</p>";
                echo "<p>Please click the go back arrow to reach the previous page.</p>";
            }

        

            else
            {
                echo "<p>Failed to delete it!</p>";
                echo "<p>Please click the go back arrow and contact our Web Master.</p>";
            }

            $queryC->close();
            $queryS->close();
            $queryL->close();
        ?> 
    </div>

    <?php
    exit
    ?>

</html>