<?php
//require_once "C:\wamp64\www\UserAuthenticationApp\User-Authentication-App\config.php";

?>
<!DOCTYPE html>
<html>
    <head>
        <h1>Sign Up</h1>
    </head>
    <body>
        <?php if(!$_POST) { ?>
        <form method="POST">
            <label for="nUsername">New Username:</label>
            <input type="text" name="nUsername" id="nUsername"><br>

            <label for="nPassword">New Password:</label>
            <input type="password" name="nPassword" id="nPassword"><br>

            <label for="cPassword">Confirm Password:</label>
            <input type="password" name="cPassword" id="cPassword"><br>

            <p>Select a role:</p>
            <input type="radio" id="member" name="permission" value="member">
            <label for="member">member</label><br>

            <input type="radio" id="librarian" name="permission" value="librarian">
            <label for="librarian">Librarian</label><br><br>

            <input type="submit" value="Sign Up">

        </form>
        <?php } else {
            $nUsername = $_POST['nUsername'];
            $nPassword = $_POST['nPassword'];
            $cPassword = $_POST['cPassword'];
            $permission = $_POST['permission'];
            if($nPassword == $cPassword){
                //sql code goes here

                ?>
            <form action="sign-in.php">
                <p>You are signed up. Click continue to login</p>
                <input type="submit" value="continue">
            </form>
                <?php
            }else{
                echo "<form method='post'>
                    <p>Please confirm your password</p>
                    <input type='submit'>
                </form>";
            }

        }
        ?>    
    </body>
</html>