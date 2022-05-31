<?php
//sign-up.php
require_once "C:\wamp64\www\UserAuthenticationApp\User-Authentication-App\config.php"; //requires config.php

?>
<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <!-- Retrieves stylesheets to be used for styling html -->
    <link rel="stylesheet" type="text/css" href="http://www.userauthenticationapp.com/css/stylesheet.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
</head>

<body>
    <h1>Sign Up</h1>
    <?php if (!$_POST) { ?>
        <!-- Form that retrieves a new username, new password, confirm password and permission -->
        <form method="POST">
            <label for="nUsername">New Username:</label>
            <input type="text" name="nUsername" id="nUsername" required><br>

            <label for="nPassword">New Password:</label>
            <input type="password" name="nPassword" id="nPassword" required><br>

            <label for="cPassword">Confirm Password:</label>
            <input type="password" name="cPassword" id="cPassword" required><br>

            <p>Select a role:</p>
            <label for="member">member</label>
            <input type="radio" id="member" name="permission" value="member" required><br>


            <label for="librarian">Librarian</label>
            <input type="radio" id="librarian" name="permission" value="librarian" required><br>


            <input type="submit" value="Sign Up">

        </form>
        <?php } else {
        //stores POST superglobals in variables
        $nUsername = $_POST['nUsername'];
        $nPassword = $_POST['nPassword'];
        $cPassword = $_POST['cPassword'];
        $permission = $_POST['permission'];

        //checks if the new password entered is the same as the confirmation password
        if ($nPassword == $cPassword) {

            //storeing sql statement in a variable. inserts new username, new password and permission in the database
            $sql = "INSERT INTO users (user_name, password, permissions) VALUES ('$nUsername', '$nPassword', '$permission')";

            //runs the statement and checks if it was created succesfully
            if ($db->query($sql) === TRUE) {
                echo "New record created successfully"; //displays if succesfully created
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error; //displays error if unsuccesful
            }

        ?>
        <!-- form takes user to sign in page -->
            <form action="sign-in.php">
                <p>You are signed up. Click continue to login</p>
                <input type="submit" value="continue">
            </form>
    <?php
        } else {
            //displayed if new password and confirm password are incorrect
            echo "<form method='post'>
                    <p>Please confirm your password</p>
                    <input type='submit'>
                </form>";
        }
    }
    ?>
</body>

</html>