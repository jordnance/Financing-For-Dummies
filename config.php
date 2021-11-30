<?php

if (session_status() == PHP_SESSION_NONE)
{
    session_start();
}

// Credit for this function goes to Dr. Toothman.
// Signed: A PHP noob
function get_connection()
{
    static $connection;

    if (!isset($connection))
    {
        $connection = mysqli_connect('localhost', 'financingfordummies', '', 'financingfordummies')
        or die(mysqli_connect_error());
    }
    if ($connection == false)
    {
        echo "Unable to connect to database<br/>";
        echo mysqli_connect_error();
    }

    return $connection;
}

?>