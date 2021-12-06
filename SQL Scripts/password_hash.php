<?php
    // Based on Dr. Toothman's update_pw.php script, but simplified for this project
    $db = mysqli_connect('localhost', 'financingfordummies', 'seimmudrofgnicnanif3420', 'financingfordummies') or die(mysqli_connect_error());
    if ($db == false)
    {
        echo "Unable to connect to database<br/>";
        echo mysqli_connect_error();
        exit;
    }

    $query = $db->prepare("SELECT usrID, Passcode FROM User");
    $query->execute();
    $results = $query->get_result();
    while ($row = $results->fetch_assoc())
    {
        $usrID = $row['usrID'];
        $passcode = $row['Passcode'];
        $hashed_passcode = password_hash($passcode, PASSWORD_DEFAULT);

        $update = $db->prepare("UPDATE User SET Passcode=? WHERE usrID=?");
        $update->bind_param('si', $hashed_passcode, $usrID);
        $update->execute();
    }
?>