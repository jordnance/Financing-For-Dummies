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
                                <a class="button" style="display:block;" href="">Threshold</a>
                            </div>
                        </li>
                    </div>

                    <li><a class="button" href="settings.php">Settings</a></li>

                    <li><button class="link" form="logout" name="logout">Log Out</button></li>
                </ul>

                <div id="main">
                    <article>
                        <!-- Place default table here! -->
                        <?php
                            $db = get_connection();
            
                            $queryFA = $db->prepare("SELECT acctID, acctName, balance FROM FinancialAccount WHERE usrID=?");
                            $queryFA->bind_param("i", $_SESSION['usrID']);
                            $queryFA->execute();
                            $queryFA->bind_result($faID, $faName, $faBalance);
                
                            $resultFA = $queryFA->get_result();
                            echo "<table class='spaced' border='1'>
                            <tr>
                            <th>Account Name</th>
                            <th>Amount</th>
                            </tr>";
                            
                            while ($rowFA = $resultFA->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='spaced'>" . $rowFA["acctName"] . "</td>";
                                echo "<td class='spaced'>" . $rowFA["balance"] . "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                            
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
