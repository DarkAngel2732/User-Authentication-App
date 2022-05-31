<!-- index page -->
<!DOCTYPE html>
<html>
    <head>
        <!-- Retrieves stylesheets to be used for styling html -->
        <title>Welcome</title>
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    </head>
    <body>
        <h1>Welcome</h1>
        <h2>What would you like to do?</h2>
        <!-- Two forms here directs the user to page they want to go -->
        <!-- Goes to sign-in.php -->
        <form action="login/sign-in.php" method="POST">
            <input type="submit" value="login"><br>
        </form><br>

        <!-- goes to sign-up.php -->
        <form action="login/sign-up.php" method="POST">
            <input type="submit" value="Sign Up"><br>
        </form>
    </body>
</html>