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

            <?php
            //books table
            $sql = "SELECT * FROM books LEFT JOIN authors ON books.author_id = authors.author_id $sort;";
            $result = $db->query($sql);

            if ($result) {
                if ($result->num_rows > 0) {
                    echo "<table border=1>";
                    echo "<tr>";
                    echo "<td>Book ID</td>";
                    echo "<td>Book Name</td>";
                    echo "<td>Year Published</td>";
                    echo "<td>Book Genre</td>";
                    echo "<td>Booke Age Group</td>";
                    echo "<td>Author Name</td>";
                    echo "<tr>";
                    while ($row = $result->fetch_assoc()) {

                        echo "<tr>";
                        echo "<td>" . $row['book_id'] . "</td>";
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


            //authors table
            $sql = "SELECT * FROM authors;";
            $result = $db->query($sql);

            if ($result) {
                if ($result->num_rows > 0) {
                    echo "<table border=1>";
                    echo "<tr>";
                    echo "<td>Author ID</td>";
                    echo "<td>Author Name</td>";
                    echo "<td>Author Age</td>";
                    echo "<td>Author's Writing Genre</td>";
                    echo "<tr>";
                    while ($row = $result->fetch_assoc()) {

                        echo "<tr>";
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
            //Add book
            ?>
            <form method="POST">
                Add book:<br>
                <label for="bookName">Book Name:</label>
                <input type="text" id="bookName" name="bookName" required><br>

                <label for="year">Year:</label>
                <input type="text" id="year" name="year" required><br>

                <label for="genre">Genre:</label>
                <input type="text" id="genre" name="genre" required><br>

                <label for="ageGroup">Age-group:</label>
                <input type="text" id="ageGroup" name="ageGroup" required><br>

                <label for="authorID">Author ID:</label>
                <input type="text" id="authorID" name="authorID" required><br>

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


            //Add Author
            ?>
            <form method="POST">
                Add Author:<br>
                <label for="authorName">Author Name:</label>
                <input type="text" id="authorName" name="authorName" required><br>

                <label for="age">Age:</label>
                <input type="text" id="age" name="age" required><br>

                <label for="writingGenre">Writing-genre:</label>
                <input type="text" id="writingGenre" name="writingGenre" required><br>

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


            //Delete Book
            ?>
            <form method="POST">
                Delete Book: <br>
                <label for="deleteBook">Book ID:</label>
                <input type="text" id="deleteBook" name="deleteBook" required><br>

                <input type="submit">
            </form><br>
            <?php
            if ($_POST['deleteBook']) {
                $deleteBook = $_POST['deleteBook'];

                $sql = "DELETE FROM books WHERE book_id = $deleteBook";

                if ($db->query($sql) === TRUE) {
                    echo "Record deleted successfully";
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
            }


            //Delete Author
            ?>
            <form method="POST">
                Delete Author: <br>
                <label for="deleteAuthor">Author ID:</label>
                <input type="text" id="deleteAuthor" name="deleteAuthor" required><br>

                <input type="submit">
            </form><br>
            <?php
            if ($_POST['deleteAuthor']) {
                $deleteAuthor = $_POST['authorID'];

                $sql = "DELETE FROM authors WHERE author_id = $deleteAuthor";

                if ($db->query($sql) === TRUE) {
                    echo "Record deleted successfully";
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
            }

            //Update Book
            //Update books SET "column" = "new value" WHERE book_id = ""
            ?>
            <form method="POST">
                Update Book: <br>
                <label for="column">Column:</label>
                <select name="column" id="column" required>
                    <option value="">Select an option</option>
                    <option value="book_id">Book ID</option>
                    <option value="book_name">Book Name</option>
                    <option value="year">Year Published</option>
                    <option value="genre">Book Genre</option>
                    <option value="age_group">Book Age Group</option>
                    <option value="author_id">Author ID</option>
                    <option value="author_name">Author Name</option>
                    <option value="age">Author Age</option>
                    <option value="writing_genre">Author's writng genre</option>
                </select><br>

                <label for="bookIDChange">ID of book you want to change:</label>
                <input type="text" id="bookIDChange" name="bookIDChange" required><br>

                <label for="newValue">New Value:</label>
                <input type="text" id="newValue" name="newValue" required><br>

                <input type="submit">
            </form><br>
            <?php
            if (!$_POST['bookIDChange']) {
                $column = $_POST['column'];
                $bookIDChange = $_POST['bookIDChange'];
                $newValue = $_POST['newValue'];

                $sql = "DELETE FROM authors WHERE author_id = $deleteAuthor";

                if ($db->query($sql) === TRUE) {
                    echo "Record deleted successfully";
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
            }


            //Update Author
            ?>
            <form method="POST">
                Update Author: <br>
                <label for="column">Column:</label>
                <select name="column" id="column" required>
                    <option value="">Select an option</option>
                    <option value="book_id">Book ID</option>
                    <option value="book_name">Book Name</option>
                    <option value="year">Year Published</option>
                    <option value="genre">Book Genre</option>
                    <option value="age_group">Book Age Group</option>
                    <option value="author_id">Author ID</option>
                    <option value="author_name">Author Name</option>
                    <option value="age">Author Age</option>
                    <option value="writing_genre">Author's writng genre</option>
                </select><br>

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