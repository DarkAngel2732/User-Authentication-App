<?php
session_start();
require_once "C:\wamp64\www\UserAuthenticationApp\User-Authentication-App\config.php";

$username = $password = $permissions = "";
?>
<!DOCTYPE html>
<html>

<head>
    Welcome
</head>
<?php if (!$_POST) { ?>

    <body>
        <form method="post">

            <label for="username">Username:</label>
            <input type="text" name="username"><br>

            <label for="password">Password:</label>
            <input type="password" name="password"><br>

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

        $_SESSION[$username] = $username;
        $_SESSION[$permissions] = $permissions;


    ?>

        <head>
            You are logged in
        </head>
        <form action="C:\wamp64\www\UserAuthenticationApp\User-Authentication-App\library.php">
            <input type="submit" value="continue">
        </form>

<?php
    } else {
        echo "Please enter a correct username and password";
    }
    
} ?>

</html>