<!-- logout.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Logged Out</title>
    <!-- Retrieves stylesheets to be used for styling html -->
    <link rel="stylesheet" type="text/css" href="http://www.userauthenticationapp.com/css/stylesheet.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
</head>
<?php
//ends the session for the user
session_start();
session_destroy();
?>
<!-- displays a button to go back to index.php -->
<form action="http://www.userauthenticationapp.com/" method="POST">
    <p>you are logged out</p>
    <input type="submit" value="continue">
</form>

</html>