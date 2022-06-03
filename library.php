<!DOCTYPE html>
<!-- library.php -->
<html>
<?php
session_start();//starts session to have access to SESSION superglovals
require_once "C:\wamp64\www\UserAuthenticationApp\User-Authentication-App\config.php"; //requires config.php
error_reporting(E_ERROR | E_WARNING | E_PARSE);//stops minor errors from showing to user, such as referencing something in database that doesn't exist

if ($_SESSION['permissions'] == 'member' or $_SESSION['permissions'] == 'librarian') { //Stops unauthorised access to this page

?>

    <head>
        <!-- Retrieves stylesheets to be used for styling html -->
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
        <!-- Form creating buttons for sort methods -->
        <form method="POST">
            Sort by:
            <input type="submit" value="books" name="sort" id="book">
            <input type="submit" value="authors" name="sort" id="author">
            <input type="submit" value="genre" name="sort" id="genre">
        </form><br>
        <?php
        if ($_POST['sort']) { // Simple if statment so that this code only runs if above form button has been clicked
            $sort = $_POST['sort']; //stores superglobal into a variabel
            switch ($_POST['sort']) { //switch statement that stores part of an sql statement that will be used later
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
        $sql = "SELECT * FROM books LEFT JOIN authors ON books.author_id = authors.author_id $sort;"; //Sql statment to select all data from books table and authors table and appends the $sort variable from above
        $result = $db->query($sql); //runs and stores the result of the sql statment

        if ($result) { //runs only if $result exists
            if ($result->num_rows > 0) { //runs only if there is data in the table
                echo "<table border=1>";//start of table
                while ($row = $result->fetch_assoc()) {//loop that runs through entire table in database and displays it to user

                    echo "<tr>";
                    echo "<td>" . $row['book_name'] . "</td>";
                    echo "<td>" . $row['year'] . "</td>";
                    echo "<td>" . $row['genre'] . "</td>";
                    echo "<td>" . $row['age_group'] . "</td>";
                    echo "<td>" . $row['author_name'] . "</td>";
                    echo "<tr>";
                }
                echo "</table><br>";//end of table
            }
        } else {
            echo "Error selecting table " . $conn->error; //runs only if there was an issue selecting the table
        }

        //search bar starts here
        if (!$_POST['search']) { //if statement to ensure code is run only of a search is made?>
            <form method="POST">
                <label for="search">Looking for something specific?</label>
                <input type="text" name="search">

                <input type="submit" value="search"><br>
            </form>
            <?php } else {

            $search = $_POST['search']; //stores POST superglobal in a variable

            if ($_SESSION['permissions'] == 'member') {//adjusts sql statment depending on what permission the user has
                //user with member permission can only search through books table
                $sql = "SELECT * FROM books 
                WHERE book_name LIKE '%$search%' 
                or year LIKE '%$search%' 
                or genre LIKE '%$search%' 
                or age_group like '$search';";
            } elseif ($_SESSION['permissions'] == 'librarian') {
                //user with librarian permission can search through all tables
                $sql = "SELECT * FROM books  LEFT JOIN authors ON books.author_id = authors.author_id 
                WHERE books.book_name LIKE '%$search%' 
                or books.year LIKE '%$search%' 
                or books.genre LIKE '%$search%' 
                or books.age_group LIKE '%$search%'
                or authors.author_name LIKE '%$search%'
                or authors.age LIKE '%$search%'
                or authors.writing_genre LIKE '%$search%';";
            }else{
                echo "HOW THE HELL ARE YOU HERE"; //This should never run EVER
            }
            
            $result = $db->query($sql);// runs and stores the sql statement above

            if ($result) { //checks if the variable exists
                if ($result->num_rows > 0) { //Only runs if there is data in the search
                    echo "<p>This is what we found<p>";
                    echo "<table border=1>";//start of table
                    while ($row = $result->fetch_assoc()) {//loop runs as long as there is data to be displayed

                        echo "<tr>";
                        echo "<td>" . $row['book_name'] . "</td>";
                        echo "<td>" . $row['year'] . "</td>";
                        echo "<td>" . $row['genre'] . "</td>";
                        echo "<td>" . $row['age_group'] . "</td>";
                        if ($_SESSION['permissions'] == 'librarian') {//only runs for users that have librarian permissions
                            echo "<td>" . $row['author_name'] . "</td>";
                            echo "<td>" . $row['age'] . "</td>";
                            echo "<td>" . $row['writing_genre'] . "</td>";
                        }
                        echo "<tr>";
                    }
                    echo "</table><br>";//end of table
            ?>
            <!-- Resets the search bar and clears POST superglobal -->
                    <form method="POST">
                        <input type="submit" value="go back">
                    </form>
                <?php
                } else {
                ?>
                <!-- Onlt displayed if there was nothing found in the search -->
                    <form method="POST">
                        <p>nothing matches your search</p>
                        <input type="submit" value="go back">
                    </form>
            <?php
                }
            } else {
                echo "Error selecting table " . $conn->error;//runs if there was an error with sql
            }
        }
        if ($_SESSION['permissions'] == 'librarian') { //runs only if the user has librarian permissions
            ?>
            <!-- Button to access the catalogue page which allows CRUD operations -->
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
            <!-- Links to the logout page and allows user to logout -->
            <a href="login\logout.php">Logout</a>
    </body>
<?php
} else {
?>
    <!-- Displays if there is unauthorised access to the page -->
    <h1>Error, you are not signed in. Would you like to sign-in?</h1>
    <form action="http://www.userauthenticationapp.com/">
        <input type="submit" value="sign in">
    </form>

<?php
}
?>

</html>