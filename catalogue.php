<!DOCTYPE html>
<html>

<body>
    <?php
    session_start();
    require_once "C:\wamp64\www\UserAuthenticationApp\User-Authentication-App\config.php";
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    echo $crud;
    if ($_SESSION['permissions'] == 'librarian') {
    ?>

        <head>
            <h1>
                Welcome Librarian
            </h1><br>
        </head>

        <body>
            <form method="POST">
                Sort by:
                <input type="submit" value="bookID" name="sort">
                <input type="submit" value="books" name="sort">
                <input type="submit" value="authors" name="sort">
                <input type="submit" value="genre" name="sort">
            </form>
            <?php
            if ($_POST['sort']) {
                $sort = $_POST['sort'];
                switch ($sort) {
                    case 'bookID':
                        $sort = ' ORDER BY book_id';
                        break;
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
            $sql = "SELECT * FROM books LEFT JOIN authors ON books.author_id = authors.author_id $sort;";
            $result = $db->query($sql);

            if ($result) {
                if ($result->num_rows > 0) {
                    echo "<table border=1>";
                    while ($row = $result->fetch_assoc()) {

                        echo "<tr>";
                        echo "<td>" . $row['book_id'] . "</td>";
                        echo "<td>" . $row['book_name'] . "</td>";
                        echo "<td>" . $row['year'] . "</td>";
                        echo "<td>" . $row['genre'] . "</td>";
                        echo "<td>" . $row['age_group'] . "</td>";
                        echo "<td>" . $row['author_id'] . "</td>";
                        echo "<td>" . $row['author_name'] . "</td>";
                        echo "<td>" . $row['age'] . "</td>";
                        echo "<td>" . $row['writing_genre'] . "</td>";
                        echo "<tr>";
                    }
                    echo "</table><br>";
                }
            } else {
                echo "Error selecting table " . $conn->error;
            }
            //CRUD operations start here
            ?>
            <form method="POST">
                Add book:<br>
                <label for="bookName">Book Name</label>
                <input type="text" id="bookName" name="bookName" required>

                <label for="year">Year</label>
                <input type="text" id="year" name="year" required>

                <label for="genre">Genre</label>
                <input type="text" id="genre" name="genre" required>

                <label for="ageGroup">Age-group</label>
                <input type="text" id="ageGroup" name="ageGroup" required>

                <label for="authorID">Author ID</label>
                <input type="text" id="authorID" name="authorID" required>

                <input type="submit">
            </form><br>
            <?php
            if ($_POST['bookName']) {
                $bookName = $_POST['bookName'];
                $year = $_POST['year'];
                $genre = $_POST['genre'];
                $ageGroup = $_POST['ageGroup'];
                $authorID = $_POST['authorID'];

                $sql = "INSERT INTO books (book_name, year, genre, age_group, author_id) VALUES ('$bookName', $year, '$genre', '$ageGroup', $authorID)";

                if ($db->query($sql) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            ?>
            <form method="POST">
                Add Author:<br>
                <label for="authorName">Author Name</label>
                <input type="text" id="authorName" name="authorName" required>

                <label for="age">Age</label>
                <input type="text" id="age" name="age" required>

                <label for="writingGenre">Writing-genre</label>
                <input type="text" id="writingGenre" name="writingGenre" required>

                <input type="submit">
            </form><br>
            <?php
            if ($_POST['authorName']) {
                $authorName = $_POST['authorName'];
                $age = $_POST['age'];
                $writingGenre = $_POST['writingGenre'];

                $sql = "INSERT INTO authors (author_name, age, writing_genre) VALUES ('$authorName', '$age', '$writingGenre')";

                if ($db->query($sql) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            ?>
            <form method="POST">
                Delete Book: <br>
                <label for="bookID">Book ID:</label>
                <input type="text" id="bookID" name="bookID" required>

                <input type="submit">
            </form><br>
            <?php
            $bookID = $_POST['bookID'];

            $sql = "DELETE FROM books WHERE book_id = $bookID";

            if ($db->query($sql) === TRUE) {
                echo "Record deleted successfully";
            } else {
                echo "Error deleting record: " . $conn->error;
            }

            ?>
            <form method="POST">
                Delete Author: <br>
                <label for="authorID">Author ID:</label>
                <input type="text" id="authorID" name="authorID" required>

                <input type="submit">
            </form><br>
            <?php
            $authorID = $_POST['authorID'];

            $sql = "DELETE FROM authors WHERE author_id = $authorID";

            if ($db->query($sql) === TRUE) {
                echo "Record deleted successfully";
            } else {
                echo "Error deleting record: " . $conn->error;
            }
            ?>
            <form method="POST">
                Update Book: <br>
                <label for="col">Column</label>
                <input type="text" id="col" name="col" required>

                <label for="val">New Value</label>
                <input type="text" id="val" name="val" required>

                <input type="submit">
            </form><br>
            <?php

            ?>
            <form method="POST">
                Update Author: <br>
                <label for="col">Column</label>
                <input type="text" id="col" name="col" required>

                <label for="val">New Value</label>
                <input type="text" id="val" name="val" required>

                <input type="submit">

            </form>
            <?php

            ?>
        </body>
    <?php

    } else {
    ?>
        <h1>Error, you are not signed in as a librarian. Would you like to sign-in?</h1>
        <form action="http://www.userauthenticationapp.com/">
            <input type="submit" value="sign in">
        </form>
    <?php
    } ?>

</html>