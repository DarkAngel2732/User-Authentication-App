<!DOCTYPE html>
<html>
<?php
session_start();
require_once "C:\wamp64\www\UserAuthenticationApp\User-Authentication-App\config.php";
$sql = $search = "";
if ($_SESSION['permissions'] = 'member' or $_SESSION['permissions'] = 'librarian') {
?>

    <head>
        <h1>
            Welcome to the library
        </h1><br>
    </head>

    <body>
        <?php
        $sql = "SELECT books.book_name, authors.author_name FROM books LEFT JOIN authors ON books.author_id = authors.author_id;";
        $result = $db->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                echo "<table border=1>";
                while ($row = $result->fetch_assoc()) {

                    echo "<tr>";
                    echo "<td>" . $row['book_name'] . "</td>";
                    echo "<td>" . $row['author_name'] . "</td>";
                    echo "<tr>";
                }
                echo "</table><br>";
            }
        } else {
            echo "Error selecting table " . $conn->error;
        }
        if (!$_POST) { ?>
            <form method="POST">
                <label for="search">Looking for something specific?</label><br>
                <input type="text" name="serach"><br>

                <input type="submit" value="search">
            </form>
        <?php } else {

            $search = $_POST['search'];
            if ($_SESSION['permissions'] = 'member') {
                $sql = "SELECT books.book_name, authors.author_name FROM books LEFT JOIN authors ON books.author_id = authors.author_id;";
                $result = $db->query($sql);

                if ($result) {
                    if ($result->num_rows > 0) {
                        echo "<table border=1>";
                        while ($row = $result->fetch_assoc()) {

                            echo "<tr>";
                            echo "<td>" . $row['book_name'] . "</td>";
                            echo "<td>" . $row['author_name'] . "</td>";
                            echo "<tr>";
                        }
                        echo "</table><br>";
                    }
                } else {
                    echo "Error selecting table " . $conn->error;
                }
            } elseif ($_SESSION['permissions'] = 'librarian') {
            }
        }
        ?>
    </body>
<?php
} else {
?>
    <h1>Error, you are not logged in. Would you like to sign in?</h1>
    <form action="login/sign-in.php">
        <input type="submit" value="sign in">
    </form>

<?php
}
?>

</html>