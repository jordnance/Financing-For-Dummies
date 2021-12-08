<!DOCTYPE html>

<head>
    <title>Delete a Child account entirely</title>

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

            // Middle-tier programming to delete child account entirely in userRoles1.php

            $usrChildID = $_GET['id'];
            $db = get_connection();
            
            $queryC = $db->prepare("CALL deleteUser(?)");
            $queryC->bind_param('i', $usrChildID);
            $queryC->execute();

            if($queryC->execute())
            {
                echo "<p>Sucessfully deleted your ENTIRE Child account! </p>";
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