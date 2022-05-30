<!DOCTYPE html>
<html>
<?php
session_start();
require_once "C:\wamp64\www\UserAuthenticationApp\User-Authentication-App\config.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);

if ($_SESSION['permissions'] == 'member' or $_SESSION['permissions'] == 'librarian') {

?>

    <head>
        <title>Library</title>
        <link rel="stylesheet" type="text/css" href="http://www.userauthenticationapp.com/css/stylesheet.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    </head>

    <body>
        <h1>
            Welcome to the library
        </h1><br>
        <?php
        //sorting methods start here
        ?>
        <form method="POST">
            Sort by:
            <input type="submit" value="books" name="sort" id="book">
            <input type="submit" value="authors" name="sort" id="author">
            <input type="submit" value="genre" name="sort" id="genre">
        </form><br>
        <?php
        if ($_POST['sort']) {
            $sort = $_POST['sort'];
            switch ($_POST['sort']) {
                case 'books':
                    $sort = ' ORDER BY book_name';
                    break;
                case 'authors':
                    $sort = ' ORDER BY author_name';
                    break;
                case 'genre':
                    $sort = ' ORDER BY genre';
                    break;
            }
        }
        //display all start here
        $sql = "SELECT * FROM books LEFT JOIN authors ON books.author_id = authors.author_id $sort;";
        $result = $db->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                echo "<table border=1>";
                while ($row = $result->fetch_assoc()) {

                    echo "<tr>";
                    echo "<td>" . $row['book_name'] . "</td>";
                    echo "<td>" . $row['year'] . "</td>";
                    echo "<td>" . $row['genre'] . "</td>";
                    echo "<td>" . $row['age_group'] . "</td>";
                    echo "<td>" . $row['author_name'] . "</td>";
                    echo "<tr>";
                }
                echo "</table><br>";
            }
        } else {
            echo "Error selecting table " . $conn->error;
        }

        //search bar starts here
        if (!$_POST['search']) { ?>
            <form method="POST">
                <label for="search">Looking for something specific?</label>
                <input type="text" name="search">

                <input type="submit" value="search"><br>
            </form>
            <?php } else {

            $search = $_POST['search'];

            if ($_SESSION['permissions'] == 'member') {
                $sql = "SELECT * FROM books 
                WHERE book_name LIKE '%$search%' 
                or year LIKE '%$search%' 
                or genre LIKE '%$search%' 
                or age_group like '$search';";
            } elseif ($_SESSION['permissions'] == 'librarian') {
                $sql = "SELECT * FROM books  LEFT JOIN authors ON books.author_id = authors.author_id 
                WHERE books.book_name LIKE '%$search%' 
                or books.year LIKE '%$search%' 
                or books.genre LIKE '%$search%' 
                or books.age_group LIKE '%$search%'
                or authors.author_name LIKE '%$search%'
                or authors.age LIKE '%$search%'
                or authors.writing_genre LIKE '%$search%';";
            }
            $result = $db->query($sql);

            if ($result) {
                if ($result->num_rows > 0) {
                    echo "<p>This is what we found<p>";
                    echo "<table border=1>";
                    while ($row = $result->fetch_assoc()) {

                        echo "<tr>";
                        echo "<td>" . $row['book_name'] . "</td>";
                        echo "<td>" . $row['year'] . "</td>";
                        echo "<td>" . $row['genre'] . "</td>";
                        echo "<td>" . $row['age_group'] . "</td>";
                        if ($_SESSION['permissions'] == 'librarian') {
                            echo "<td>" . $row['author_name'] . "</td>";
                            echo "<td>" . $row['age'] . "</td>";
                            echo "<td>" . $row['writing_genre'] . "</td>";
                        }
                        echo "<tr>";
                    }
                    echo "</table><br>";
            ?>
                    <form method="POST">
                        <input type="submit" value="go back">
                    </form>
                <?php
                } else {
                ?>
                    <form method="POST">
                        <p>nothing matches your search</p>
                        <input type="submit" value="go back">
                    </form>
            <?php
                }
            } else {
                echo "Error selecting table " . $conn->error;
            }
        }
        if ($_SESSION['permissions'] == 'librarian') {
            ?>
            <form action="catalogue.php">
                <p>Access catalogue
                    <input type="submit" value="Go">
                </p>
            </form>
            <?php
            echo "signed in as librarian.";
        } else {
            echo "signed in as a member.";
        }
            ?>
            <a href="login\logout.php">Logout</a>
    </body>
<?php
} else {
?>
    <h1>Error, you are not signed in. Would you like to sign-in?</h1>
    <form action="http://www.userauthenticationapp.com/">
        <input type="submit" value="sign in">
    </form>

<?php
}
?>

</html>