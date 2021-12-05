 <!-- userRoles page allows Adult users to view their Child accounts info if there are any by default.
 userRoles page allows Adults to share or block their accounts with Child accounts.
 userRoles page does NOT allow Child users to view their parent(Adult) accounts info by default. -->


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
        <li><a class="button" href="accountInterface.php">Accounts</a></li>
        <li><a class="button" href="analytics.php">Analytics</a></li>
        <li><button class="link" form ="userRoles" href="#top">User Roles</a></button>
        <li><a class="button" href="newTransaction.php">New Transaction</a></li>
        <li><a class="button" href="settings.php">Settings</a></li>
        <li><button class="link" form="logout" name="logout">Log Out</button></li>
    </ul>
	
	<div id="main">
        
        <div class="controlPanel">
            
            <div class="tab">
                <button name="displayChildFiInfo" class="large" onclick="location.href = 'userRoles1.php'" 
                type = "button" >Display Your Child's Financial Accounts</button>
                                             

                <button name="displayChildAccountInfo" class="large" onclick='displayChildAccountInfo.style = "display: inline"'
                type = "button" >--- You can delete Your Child's Financial Accounts ---</button>

                                             
                <button name="contactWebMaster" class="large" onclick="location.href = 'userRoles3.php'"
                type = "button" >Email Our Web Master</button>
            </div>  
            
            
            <!--$sqlForView = "SELECT acctName, Balance FROM FinancialAccount WHERE usrID=?" -->

            <div id="displayChildAccountInfo" class="tabcontent">
                <table border="2">
                <tr>
                    <th>First Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Your Child's Financial Account Name</th>
                    <th>Balance</th>
                    <th>Action</th>
                </tr>
                
                <?php
                
                //if (true) 
                if ($_SESSION['isAdult'] == 1)
                {
                    echo "<h2>Control Panel as an Adult account holder</h2>";
                    // Query the database to get all of the user's Child accounts
                    $db = get_connection();
                    
                    $query = $db->prepare("SELECT usrID, acctID, fName, Phone_Number, Email, acctName, Balance FROM Users_Child NATURAL JOIN FinancialAccount WHERE Users_Child.adultID=?");
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
                            $children []= $query1;
                            $usrIDChild = $query1['usrID'];
                            $acctIDChild = $query1['acctID'];
                            $fNameChild = $query1['fName'];
                            $mNameChild = $query1['mName'];
                            $lNameChild = $query1['lName'];
                            $pNumberChild = $query1['Phone_Number'];
                            $emailChild = $query1['Email'];
                            $acctNameChild = $query1['acctName'];
                            $balanceChild = $query1['Balance'];
                            $count += 1;
                            
                            
                            echo "<tr>";
                            echo "<td>{$fNameChild}</td>"; 
                            echo "<td>{$pNumberChild}</td>"; 
                            echo "<td>{$emailChild}</td>"; 
                            echo "<td>{$acctNameChild}</td>"; 
                            echo "<td>&#36; {$balanceChild}</td>"; 
                            echo "<td><a href = 'deleteChlidFi.php?id=$acctIDChild'>Delete</td>"; 
                            echo "</tr>";    




                            //echo "<h4>Child Account {$count} :</h4>";
                            //echo "<p>Name of the account: {$acctNameChild} </p>";
                            //echo "<p>Balance of the account: {$balanceChild} USD</p>";
                            //echo "<h5>Do you want to delete this account, {$acctNameChild} ?</h5>";
                            //echo "<p> -------------------------------------------------------------- </p>"; 
                            
                            //foreach($children as $child) {
                               //echo "<h4>Child Account {$child} </h4>";
                            //    echo $chlid['acctName'];
                            //        
                            //}


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
                }

                elseif ($_SESSION['isAdult'] == 0)
                {   
                    echo "<h2>As a Child account holder,</h2>";
                    echo "<p>You do NOT have any Child accounts. </p>";
                }

                else
                {
                    $_SESSION['error'] = "Unable to excetue query when adult is false";
                }
                ?>
                
               
            </div>
          
            
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
<form id="userRoles" method="post" action="userRoles.php"></form>

</html>
