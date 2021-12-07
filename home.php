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

<html lang=en>
    <head>
        <title><?php echo $_SESSION['fName']; ?>'s Home</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">  
        <link rel="stylesheet" href="style.css">
    </head>
        <body>          
            <div id=page>
                <div id="header">
                    <h1 id="top">Financing for Dummies</h1>
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

                <!-- div main re-structured by Yeana on 12/06 to generate proper greetings the User upon logging in to the app
                     and encourage the User to add a finanancial account to start recording financial activities -->

                <div id="main">
                    <article>
                        <!-- Place default table here! -->

                        
						<?php
							$db = get_connection();
			
							
                            $queryUserName = $db->prepare("SELECT fName FROM User WHERE usrID=?");
                            $queryUserName->bind_param("i", $_SESSION['usrID']);
                            if($queryUserName->execute())
                            {
                                $resultUserName = $queryUserName->get_result();
                                while($queryGetUserName = $resultUserName->fetch_assoc())
                                {
                                    $fNameUserName = $queryGetUserName['fName'];
                                    echo "<h2>Hello, {$fNameUserName}!</h2>";
                                
                                }
                                $queryUserName->close();

                            }
                            
                            else
                            {
                                echo "<h2>Something went wrong!</h2>";
                            }
                        ?>

                        <?php

                            $db = get_connection();
                            
                            $queryFiExist = $db->prepare("SELECT acctID FROM FinancialAccount WHERE usrID=?");
                            $queryFiExist->bind_param("i", $_SESSION['usrID']);
                            
                            if($queryFiExist->execute())
                            {
                                $result = $queryFiExist->get_result(); 

                                $count = 0;

                                while($query1 = $result->fetch_assoc())
                                {
                                    $acctIDUser = $query1['acctID'];
                                    $count += 1;
                                    

                                }

                                if($count == 0)                                        
                                {                      
                                    
                                    echo "<p>You have not created any financial account.</p>
                                    <p>You can add one and start logging your financial activities by clicking CREATE NEW.</p>";
                                                                                
                                }

                                elseif($count != 0)
                                {

                                    echo "<p>Logging your financial activities is a great habit!";
                                    $queryFA = $db->prepare("SELECT acctID, acctName, balance FROM FinancialAccount WHERE usrID=?");
                                    $queryFA->bind_param("i", $_SESSION['usrID']);
        
                                  
                                    if($queryFA->execute())
                                    {   
                                        $queryFA->bind_result($faID, $faName, $faBalance);
                            
                                        $resultFA = $queryFA->get_result();
        
                                        
                                        echo "<table border='2'>
                                        <tr>
                                        <th style='background-color:#488AC7'>Name of Your Financial Account</th>
                                        <th style='background-color:#488AC7'>Amount</th>
                                        </tr>";
                                        

                                        
                                        while ($rowFA = $resultFA->fetch_assoc()) 
                                        {
                                            echo "<tr>";
                                            echo "<td>" . $rowFA["acctName"] . "</td>";
                                            echo "<td>&#36; " . $rowFA["balance"] . "</td>";
                                            echo "</tr>";
                                            
                                                                               
                                        }
                                        echo "</table>";
                                        
        
                                    }

                                }
                            
                            }
                     

                            $queryFiExist->close();
                     

                        ?>
				
                    </article>
                </div>              
            </div>
            <!-- Added by Marcus on 12/1 -->
            <?php
				if (isset($_SESSION['error']))
				{
					echo "<p class='error'>" . $_SESSION['error'] . "</p>";
					unset($_SESSION['error']);
				}
			?>
        </body>
        <!-- Added by Marcus on 11/30 -->
        <form id="logout" method="post" action="AccountAction.php"> </form>
</html>
