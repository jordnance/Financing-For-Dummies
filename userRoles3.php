<!-- userRoles page allows Adult users to view their Child accounts info if there are any by default: useRoles1.php
 userRoles page allows Adult users to delete their child financial accounts: usrRoles2.php
 userRoles page allows both Adult and Child users to contact the Web master: usrRoles3.php-->

 <!-- This page is not part of the practice of database, but I wanted to implement this page considering for one: if there
 is any problem occured to the client side in viewing User Roles or deleting a Child financial account that I am currently
 working on, and two: the more completed look of our app.-->

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

                <button name="deleteChildFiAccount" class="large" onclick="location.href = 'userRoles2.php'"
                type = "button" >Delete Your Child's Financial Accounts</button>

                                             
                <button name="contactWebMaster" class="large" onclick='contactWebMaster.style = "display: inline"'
                type = "button" >--- Click here to email the developer ---</button>
            </div>  


            <div id="contactWebMaster" class="tabcontent">
                
            <h4>How to email our Web Master:</h4>

          
            
                <form action="#" method="post">
                    <legend>
                        If you want to reach us via email, please, fill out the form below. 
                        <br  />Type your inquiry and submit it to us! We usually get back to you within 24 hours. Thank you.
                    </legend>
                    <br>
                    <label>Provide Your Email that you used to create your account in our app:<br  />
                    <input type="text" name="email" required="required"  /></label><br  />
                    <br>
                    <label>Verify Your Email:<br  />
                    <input type="text" name="name"  maxlength="30"  required="required"  /></label><br  />
                    <br>
                    <label>Do you live in the United States?<br  />
                        Answer:
                    <input id="yes" type="radio" name="yesno" value="Y" required="required">
                    <label for="yes">Yes</label>
                    <input id="no" type="radio" name="yesno" value="N">
                    <label for="no">No</label><br  />
                    <br><br>
                    <label>Provide Your Cellular Phone Number:<br  />
                    <input type="text" name="cellphone" maxlength="30" required="required"  /></label>

                    <p id="black">What is your inquiry?</p>
                    <textarea name="inquiry" cols="40" rows="8">My inquiry is... </textarea><br  />
                    <br>
                    <input type="submit" value="submit"  /> 
                </form>
                  
            
            
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
