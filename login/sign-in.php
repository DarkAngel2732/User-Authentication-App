<?php
session_start();
require_once "C:\wamp64\www\UserAuthenticationApp\User-Authentication-App\config.php";
$username = $password = $permissions = "";
error_reporting(E_ERROR | E_WARNING | E_PARSE);

?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="http://www.userauthenticationapp.com/css/stylesheet.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
</head>
<body>
<?php if (!$_POST) { ?>
        <h1>Sign In</h1>
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
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE user_name='$username' AND password='$password'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    if ($row['user_name'] == $username and $row['password'] == $password) {
        $permissions = $row['permissions'];

        $_SESSION['username'] = $username;
        $_SESSION['permissions'] = $permissions;

    ?>
    </body>
        <p>You are logged in!</p>
        <form action="http://www.userauthenticationapp.com/library.php">
            <input type="submit" value="continue">
        </form>

<?php

    } else {

        echo "Please enter a correct username and password";
    }
} ?>

</html>