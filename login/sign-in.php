<?php
//sign-in.php
session_start(); //starts a session to be able to use the $_SESSION superglobal
require_once "C:\wamp64\www\UserAuthenticationApp\User-Authentication-App\config.php"; //require config.php
$username = $password = $permissions = ""; //Instantiating of important variabled for the sign in page
error_reporting(E_ERROR | E_WARNING | E_PARSE); //stops a couple errors from reporting, mostly because of accessing information in a table that doesn't exist yet i.e. a wrong password/username

?>
<!DOCTYPE html>
<html>

<head>
    <!-- Retrieves stylesheets to be used for styling html -->
    <title>Sign In</title>
    <link rel="stylesheet" type="text/css" href="http://www.userauthenticationapp.com/css/stylesheet.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
</head>
<body>
<?php if (!$_POST) { //if statment to check for a $_POST superglobal?>
        <h1>Sign In</h1>
        <!-- sign in form retrieving username and password and storing in POST superglobal -->
        <form method="post">

            <p><label for="username">Username:</label>
            <input type="text" name="username" required></p>

            <p><label for="password">Password:</label>
            <input type="password" name="password" required></p>

            <p><input type="submit"></p>
        </form>
        <form action="forgot.php">
            <input type="submit" value="forgot password?">
        </form>
    </body>
    <?php
} else {
    //Storing POST superglobals into variables
    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "SELECT * FROM users WHERE user_name='$username' AND password='$password'"; //Storing sql statment
    $result = $db->query($sql); //search database for corresponding username and password in POST using db object
    $row = $result->fetch_assoc(); //stores information in variable using db object

    //if statement checks if username and password corresponds
    if ($row['user_name'] == $username and $row['password'] == $password) {
        $permissions = $row['permissions'];//stores permissions found in database

        $_SESSION['username'] = $username; //stores username in session superglobal
        $_SESSION['permissions'] = $permissions; //stores permissions in sesssion superglobal

    ?>
    </body>
        <p>You are logged in!</p>
        <form action="http://www.userauthenticationapp.com/library.php">
            <input type="submit" value="continue">
        </form>

<?php

    } else {
        //shown if wrong usernbame or password is entered
        echo "Please enter a correct username and password";
    }
} ?>

</html>