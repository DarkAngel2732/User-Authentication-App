<?php
    $servername = "localhost";
    $uname = "root";
    $pword = "root";
    $database = "library";

    $db = new mysqli($servername, $uname, $pword, $database);

    if ($db->connect_error) {
        die("connection falied: " . $db->connect_error);
    } else {
        //echo "connected succesfully"."<br>";
    }
