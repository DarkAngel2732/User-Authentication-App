<?php
    //config.php
    //required in files that need to access the datbase

    //stores data needed to access the database
    $servername = "localhost";
    $uname = "root";    //username
    $pword = "root";    //password
    $database = "library";

    //creating a new mysqli object to be used in the program
    //$db is the variable used throughout the program to access the database
    $db = new mysqli($servername, $uname, $pword, $database);

    //simple if statement used in testing to make sure there is a connection to the database
    if ($db->connect_error) {
        die("connection falied: " . $db->connect_error);
    } else {
        //echo "connected succesfully"."<br>";
    }
