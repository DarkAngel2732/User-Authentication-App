<?php
require_once "C:\wamp64\www\UserAuthenticationApp\User-Authentication-App\config.php";
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
    <h1>Forgot Password</h1>
    <?php if (!$_POST) { ?>
        <form method="POST">
            <p>If you've forgotten your password, please enter your username and select your role</p>

            <label for="username">Username:</label>
            <input type="text" name="username"><br>

            <p>Select a role:</p>
            <input type="radio" id="member" name="permissions" value="member">
            <label for="member">member</label><br>

            <input type="radio" id="librarian" name="permissions" value="librarian">
            <label for="librarian">Librarian</label><br><br>

            <input type="submit" value="continue">
        </form>
        <form action="sign-in.php">
            <input type="submit" value="back">
        </form>
        <?php } else {

        $username = $_POST['username'];
        $permissions = $_POST['permissions'];

        $sql = "SELECT * FROM users WHERE user_name='$username' AND permissions='$permissions'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();

        if ($row['user_name'] == $username and $row['permissions'] == $permissions) {
            echo "The password for $username is " . $row['password'] . "<br>";
        ?>
            <form action="sign-in.php">
                <input type="submit" value="continue to sign in">
            </form>
        <?php
        } else {
        ?>
            <form method="POST">
                <p>This user does not exist, please enter a valid username and permission</p>
                <input type="submit" value="back">
            </form>
    <?php
        }
    }
    ?>
</body>

</html>