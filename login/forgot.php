<?php
//require_once "C:\wamp64\www\UserAuthenticationApp\User-Authentication-App\config.php";

?>
<!DOCTYPE html>
<html>

<head>
    Forgot password?
</head>

<body>
    <?php if (!$_POST) { ?>
        <form method="POST">
            <p>If you've forgotten your password, please enter your username and select your role</p>

            <label for="username">Username:</label>
            <input type="text" name="username"><br>

            <p>Select a role:</p>
            <input type="radio" id="member" name="permission" value="member">
            <label for="member">member</label><br>

            <input type="radio" id="librarian" name="permission" value="librarian">
            <label for="librarian">Librarian</label><br><br>

            <input type="submit" value="continue">
        </form>
        <?php } else {

        $username = $_POST['username'];
        $permission = $_POST['permission'];

        //sql select statement here

        if ($username == $tempu and $permission == $tempp) {

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