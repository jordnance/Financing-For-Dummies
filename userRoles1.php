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
                <button name="displayChildFiInfo" class="large" onclick='displayChildFiInfo.style = "display: inline"'
                type = "button" >--- You are viewing your Child's Financial Accounts ---</button>

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
                    
                    $query = $db->prepare("SELECT usrID, acctName, Balance FROM Child NATURAL JOIN FinancialAccount WHERE Child.adultID=?");
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
                            $usrIDChild = $query1["usrID"];
                            $acctNameChild = $query1["acctName"];
                            $balanceChild = $query1["Balance"];
                            $count += 1;
                            
                            echo "<h4>Child Account {$count} :</h4>";
                            echo "<p>Name of the account: {$acctNameChild} </p>";
                            echo "<p>Balance of the account: {$balanceChild} USD</p>";
                            echo "<p> -------------------------------------------------------------- </p>"; 
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