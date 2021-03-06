<!-- userRoles page allows Adult users to view/delete their Child accounts if there are any by default: useRoles1.php
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
            
            <div class="tab">
                <button name="displayChildFiInfo" class="large" onclick='displayChildFiInfo.style = "display: inline"'
                type = "button" >--- Click here to View Your Child Account Info ---</button>

                <button name="deleteChildFiAccount" class="large" onclick="location.href = 'userRoles2.php'"
                type = "button" >Delete Your Child's Financial Accounts</button>

                <button name="contactWebMaster" class="large" onclick="location.href = 'userRoles3.php'"
                type = "button" >Contact Web Master</button>
                                             

            </div>  
            
           
            <div id="displayChildFiInfo" class="tabcontent">
                
                <?php
                
                
                if ($_SESSION['isAdult'] == 1)
                {
                    echo "<h2>Control Panel as an Adult account holder</h2>";
                    // Query the database to get all of the user's Child accounts
                    $db = get_connection();
                    
                    $query = $db->prepare("SELECT usrID, fName, mName, lName, Date_Of_Birth, Email, Phone_Number FROM User Natural Join Child WHERE Child.AdultID =?");
                    // bind_param('s' for string that is the type of variable in the query)
                    $query->bind_param('i', $_SESSION['usrID']);

                    if ($query->execute())
                    {
                        
                        // bind_result is like a receving basket from the query
                        // $query->bind_result($usrIDChild, $acctNameChild, $balanceChild);

                        // get_result() is slightly different from blind_result()
                        
                        $result = $query->get_result();
                        $count = 0;
                        
                        while($query1 = $result->fetch_assoc())
                        {
				
                            $usrIDChild = $query1['usrID'];
                            $fNameChild = $query1['fName'];
                            $mNameChild = $query1['mName'];
                            $lNameChild = $query1['lName'];
                            $dobChild = $query1['Date_Of_Birth'];
                            $pNumberChild = $query1['Phone_Number'];
                            $emailChild = $query1['Email'];
                            $count += 1;
                            
                            echo "<h4>Child Account {$count} :</h4>";
                            echo "<p>Full name of this account holder: {$fNameChild} {$mNameChild} {$lNameChild}  </p>";
                            echo "<p>Date of Birth: {$dobChild} </p>";
                            echo "<p>Phone Number: {$pNumberChild} </p>";
                            echo "<p>Email: {$emailChild} </p>";
                            echo "<p> -------------------------------------------------------------- </p>"; 
                            echo "<p><a href = 'deleteChildAcct.php?id=$query1[usrID]'>Delete this Child Account {$count}</a></p>";
                            echo "<p> -------------------------------------------------------------- </p>"; 
                         
                        }
                        

                        if ($count == 0)
                        {
                            echo "<p>You do NOT have any Child accounts.</p>";
                        }
                    }

                    else
                    {
                        $_SESSION['error'] = "Unable to excetue query when adult is true";
                    }

                    $query1->close();
                }
                ?>

                <?php

                if($_SESSION['isAdult'] == 0)
                {   
                    $db = get_connection();
                    echo "<h2>As a Child account holder,</h2>";
                    echo "<p>You do NOT have any Child accounts.</p>";
                                   
                }

                else
                {
                    $_SESSION['error'] = "Unable to excetue query when adult is false";
                }
                
                ?>
                
            
            </div>
          
            
            
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

