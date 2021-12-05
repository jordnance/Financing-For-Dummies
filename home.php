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
        <style type="text/css">
        * {box-sizing: border-box;}

        #header  {background-color: #488AC7;
                  padding: 20px;
                  text-align: center;
                  font-family: Georgia;
                  font-size: 30px;
                  color: white;
                  border-top: 3px solid #000;
                  border-bottom: 3px solid #000;
                  border-left: 3px solid #000;
                  border-right: 3px solid #000;
                  margin: auto auto 8px auto;}

        #footer  {background-color: #777;
                  padding: 10px;
                  text-align: center;
                  color: white;}

        ul  {width: auto;
             padding: 10px;
             background-color: #98AFC7;
             margin: auto auto auto auto;
             font-family: Georgia;
             border-top: 3px solid #000;
             border-bottom: 3px solid #000;
             border-left: 3px solid #000;
             border-right: 3px solid #000;
             text-align: center;}
        
        li  {display: inline;
             margin: 0px 4px;}
     
        a  {color: #000000;
            text-transform: uppercase;
            text-decoration: none;
            padding: 6px 18px 5px 18px;}

        a:hover, a.on  {color: #cc3333;
                        background-color: #ffffff;}

        /* Added by Marcus on 11/30 
           I don't think I got this done quite right
           (or efficiently), but it's pretty close? Maybe? */
        button.link {background: none;
                     border: none;
                     color: #000000;
                     text-transform: uppercase;
                     text-decoration: none;
                     text-align: center;
                     cursor: pointer;
                     padding: 6px 18px 5px 18px;
                     font-family: Georgia;
                     font-size: 15px;}

        button.link:hover {color: #cc3333;
                           background-color: #ffffff;}

        p {float: left;
           width: 20%;
           height: auto;
           background: #ccc;
           padding: 20px;
           margin-right: 10px;}
        
        article {float: center;
                 padding: 20px;
                 width: auto;
                 background-color: #B9D9EB;
                 height: auto;
                 margin-top: 10px;}
        
        #main:after  {content: "";
                      display: table;
                      clear: both;}

        #content {width: 100%;}
        
        </style>
    </head>
        <body>          
            <div id=page>
                <div id="header">
                    <h1 id="top">Financing for Dummies</h1>
                </div>
                <ul id="navigation">
                    <li><a href="#top">Home</a></li>
                    <li><a href="accountInterface.php">Accounts</a></li>
                    <li><a href="analytics.php">Analytics</a></li>
                    <li><button class="link" form ="userRoles" href="userRoles.php">User Roles</a></button>
                    <li><a href="newTransaction.php">New Transaction</a></li>
                    <li><a href="settings.php">Settings</a></li>
                    <li><button class="link" form="logout" name="logout">Log Out</button></li>
                </ul>
                <div id="main">
                    <article>
                        <!-- Place default table here! -->
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
	<!-- Added by Yeana on 12/05 -->
	<form id="userRoles" method="post" action="userRoles.php"></form>
</html>
