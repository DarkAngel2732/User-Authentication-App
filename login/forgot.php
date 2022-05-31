<?php
//forgot.php
require_once "C:\wamp64\www\UserAuthenticationApp\User-Authentication-App\config.php"; //requires config.php
error_reporting(E_ERROR | E_WARNING | E_PARSE); //doesn't display certain errors, most notably an error when a search is made for a something that doesn't exist in the datbase

?>
<!DOCTYPE html>
<html>

<head>
    <!-- Retrieves stylesheets to be used for styling html -->
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="http://www.userauthenticationapp.com/css/stylesheet.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
</head>

<body>
    <h1>Forgot Password</h1>
    <?php if (!$_POST) { //if statment to check for a $_POST superglobal?>

        <!-- form that retrieves both a username and their permission to be used later -->
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
        <!-- back button -->
        <form action="sign-in.php">
            <input type="submit" value="back">
        </form>
        <?php } else {

        //stores POST superglobals in variables
        $username = $_POST['username'];
        $permissions = $_POST['permissions'];

        $sql = "SELECT * FROM users WHERE user_name='$username' AND permissions='$permissions'";//stores sql statment in a variable. sql statement uses username and permission as search conditions
        $result = $db->query($sql); //searches database using sql statement
        $row = $result->fetch_assoc(); //stores search in object variable

        //if statment checking if information is valid
        if ($row['user_name'] == $username and $row['permissions'] == $permissions) {
            echo "The password for $username is " . $row['password'] . "<br>"; //tells the user their password
        ?>
            <form action="sign-in.php">
                <input type="submit" value="continue to sign in">
            </form>
        <?php
        } else {
        ?>
        <!-- displays if information entered is not valid -->
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