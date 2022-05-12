<?php
session_start();
require_once "C:\wamp64\www\UserAuthenticationApp\User-Authentication-App\config.php";
$username = $password = $permissions = "";
error_reporting(E_ERROR | E_WARNING | E_PARSE);

?>
<!DOCTYPE html>
<html>

<head>
    Welcome
</head><br>
<?php if (!$_POST) { ?>

    <body>
        <form method="post">

            <label for="username">Username:</label>
            <input type="text" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <input type="submit">
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

        <head>
            You are logged in
        </head>
        <form action="http://www.userauthenticationapp.com/library.php">
            <input type="submit" value="continue">
        </form>

<?php

    } else {
        
        echo "Please enter a correct username and password";
    }
    
} ?>

</html>