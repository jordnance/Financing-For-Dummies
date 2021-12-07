<!-- userRoles page allows Adult users to view their Child accounts info if there are any by default: useRoles1.php
 userRoles page allows Adult users to delete their child financial accounts: usrRoles2.php
 userRoles page allows both Adult and Child users to contact the Web master: usrRoles3.php-->



<!DOCTYPE html>

<?php
    require_once "config.php";

    // Don't let anyone who isn't logged in onto this page
    if (!isset($_SESSION['usrID']))
    {
        header("Location: index.php");
        exit;
    }

    
?>

<head>
    <title>User Roles</title>

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
	
	<div id="main">
        
        <div class="controlPanel">
            <!--<h2>Control Panel<h2>-->
            <div class="tab">
                <button name="displayChildFiInfo" class="large" onclick="location.href = 'userRoles1.php'" 
                type = "button" >Display Your Child's Financial Accounts</button>

                <button name="deleteChildFiAccount" class="large" onclick="location.href = 'userRoles2.php'"
                type = "button" >Delete Your Child's Financial Accounts</button>

                <button name="contactWebMaster" class="large" onclick="location.href = 'userRoles3.php'"
                type = "button" >Contact Web Master</button>
                                             

            </div> 
     
                <?php
                
               
                    if ($_SESSION['isAdult'] == 1)
                    {
                        echo "<h2>Control Panel as an Adult account holder</h2>";
                                 
                    }

                    elseif ($_SESSION['isAdult'] == 0)
                    {   
                        echo "<h2>As a Child account holder,</h2>";
                        echo "<p>You do NOT have any Child accounts. </p>";
                    }

                    else
                    {
                        $_SESSION['error'] = "Unable to excetue query";
                    }
                ?>
                
               
            
            
            
        </div>
    </div>

    <!-- As ever, print any session errors at the bottom of the page if they exist -->
    <?php
        if (isset($_SESSION['error']))
        {
            echo "<p class='error'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
    ?>


</body>
<form id="logout" method="post" action="AccountAction.php"></form>

</html>
