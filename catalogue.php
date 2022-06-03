<!DOCTYPE html>
<!-- catalogue.php -->
<html>
<head>
    <!-- Retrieves stylesheets to be used for styling html -->
    <title>Catalogue</title>
    <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
</head>

<body>
    <?php
    ob_start(); //creates an output buffer
    session_start(); //starts session for login
    require_once "C:\wamp64\www\UserAuthenticationApp\User-Authentication-App\config.php"; //requires config.php
    error_reporting(E_ERROR | E_WARNING | E_PARSE); //stops minor errors from showing to user, such as referencing something in database that doesn't exist
    if ($_SESSION['permissions'] == 'librarian') { //Makes sure only a user with librarian permissions can access the database
    ?>

        <head>
            <h1>
                Welcome Librarian
            </h1><br>
        </head>

        <body>
            <?php
            //books table
            $sql = "SELECT * FROM books LEFT JOIN authors ON books.author_id = authors.author_id $sort;"; //stores SQL statement used to select all from the books table and joins it to the author name in the author table
            $result = $db->query($sql); //runs the sql statment and stores it in $result

            if ($result) { //checks if $result exists and ran succesfully
                if ($result->num_rows > 0) { //runs only if there is data in the table
                    //Sets up basic table for books
                    echo "<table border=1>";
                    echo "<tr>";
                    echo "<td>Book ID</td>";
                    echo "<td>Book Name</td>";
                    echo "<td>Year Published</td>";
                    echo "<td>Book Genre</td>";
                    echo "<td>Booke Age Group</td>";
                    echo "<td>Author Name</td>";
                    echo "<tr>";
                    while ($row = $result->fetch_assoc()) { //loop to put all data from database into table

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
                echo "Error selecting table " . $conn->error; //only runs if there was an error selecting table
            }


            //authors table
            $sql = "SELECT * FROM authors;"; //selects all data from the authors table
            $result = $db->query($sql); //runs and stores the sql statement

            if ($result) { //checks if $result exists and ran succesfully
                if ($result->num_rows > 0) { //runs only if there is data in the table
                    //Sets up basic table for authors
                    echo "<table border=1>";
                    echo "<tr>";
                    echo "<td>Author ID</td>";
                    echo "<td>Author Name</td>";
                    echo "<td>Author Age</td>";
                    echo "<td>Author's Writing Genre</td>";
                    echo "<tr>";
                    while ($row = $result->fetch_assoc()) { //loop to put all data from database into table

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
                echo "Error selecting table " . $conn->error; //only runs if there was an error selecting the table
            }
            ?>
            <!-- Form gathering information to add a book -->
            <form method="POST">
                Add book:<br>
                <!-- BOOK NAME -->
                <label for="bookName">Book Name:</label>
                <input type="text" id="bookName" name="bookName" required><br>

                <!-- YEAR BOOK RELEASED -->
                <label for="year">Year:</label>
                <input type="text" id="year" name="year" required><br>

                <!-- GENRE OF BOOK -->
                <label for="genre">Genre:</label>
                <input type="text" id="genre" name="genre" required><br>

                <!-- BOOK AGE GROUP -->
                <label for="ageGroup">Age-group:</label>
                <input type="text" id="ageGroup" name="ageGroup" required><br>

                <!-- ID OF AUTHOR FOR BOOK -->
                <label for="authorID">Author ID:</label>
                <input type="text" id="authorID" name="authorID" required><br>

                <!-- SUBMIT BUTTON -->
                <p><input type="submit"></p>
            </form><br>
            <?php
            if ($_POST['bookName']) { //insures code is only run when form is submitted
                //Storing information from form into variables to be used in code
                $bookName = $_POST['bookName'];
                $year = $_POST['year'];
                $genre = $_POST['genre'];
                $ageGroup = $_POST['ageGroup'];
                $authorID = $_POST['authorID'];

                //Using variables above to create an sql query to access the books table and storing it a variable named $sql
                $sql = "INSERT INTO books (book_name, year, genre, age_group, author_id) VALUES ('$bookName', $year, '$genre', '$ageGroup', $authorID)";

                header("refresh: 0"); //refreshes page to update table

                //runs the sql statement while telling the user if the sql statement was succesful
                if ($db->query($sql) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            ?>
            <!-- Form gathering information to add a book -->
            <form method="POST">
                Add Author:<br>
                <!-- Author Name -->
                <label for="authorName">Author Name:</label>
                <input type="text" id="authorName" name="authorName" required><br>

                <!-- Age of Author -->
                <label for="age">Age:</label>
                <input type="text" id="age" name="age" required><br>

                <!-- Author writing genre -->
                <label for="writingGenre">Writing-genre:</label>
                <input type="text" id="writingGenre" name="writingGenre" required><br>

                <!-- submit button -->
                <p><input type="submit"></p>
            </form><br>
            <?php
            if ($_POST['authorName']) { //Only runs if something is stored in the authorname POST superglobal
                //stores information stored in superglobals into variables
                $authorName = $_POST['authorName'];
                $age = $_POST['age'];
                $writingGenre = $_POST['writingGenre'];

                //sql statment that inserts data gathered from form into authors table
                $sql = "INSERT INTO authors (author_name, age, writing_genre) VALUES ('$authorName', '$age', '$writingGenre')";

                header("refresh: 0"); //refreshes the page so that the table that is shown to the user gets updated while clearing POST superglobal to stop data from getting entered twice
                if ($db->query($sql) === TRUE) { //runs the query while checking if it was succesful
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            ?>
            <!-- Form Gathring information for delete book -->
            <form method="POST">
                Delete Book:<br>
                <!-- ID of book that needs to be deleted -->
                <label for="deleteBook">Book ID:</label>
                <input type="text" id="deleteBook" name="deleteBook" required><br>

                <p><input type="submit"></p>
            </form><br>
            <?php
            if ($_POST['deleteBook']) { //runs only if form was entered
                $deleteBook = $_POST['deleteBook']; //stores POST superglobal into variable

                $sql = "DELETE FROM books WHERE book_id = $deleteBook"; //simple sql statement to delete book with specific ID

                header("refresh: 0"); //refreshes the page

                if ($db->query($sql) === TRUE) { //runs the sql statement while checking if it was succesfully run
                    echo "Record deleted successfully";
                } else {
                    echo "Error deleting record: " . $conn->error;
                }

            }
            ?>
            <form method="POST">
                <!-- Form Gathering information for delete author -->
                Delete Author:<br>
                <!-- ID of author that needs to be deleted -->
                <label for="deleteAuthor">Author ID:</label>
                <input type="text" id="deleteAuthor" name="deleteAuthor" required><br>

                <p><input type="submit"></p>
            </form><br>
            <?php
            if ($_POST['deleteAuthor']) { //runs onlt if form was entered
                $deleteAuthor = $_POST['deleteAuthor']; //stores POST superglobal into a variable

                $sql = "DELETE FROM authors WHERE author_id = $deleteAuthor"; //simple sql statement to delete author with specific ID

                if ($db->query($sql) === TRUE) { //runs sql statment whilc cheking if it was succesfully run
                    echo "Record deleted successfully";
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
                header("refresh: 0");
            }
            ?>
            <!-- Form gathering information to update a book -->
            <form method="POST">
                Update Book:<br>
                <!-- BOOK ID THAT YOU WANT TO UPDATE -->
                <label for="bookIDChange">ID of the book you want to change:</label>
                <input type="text" id="bookIDChange" name="bookIDChange" required><br>

                <!-- WHAT YOU WANT TO UPDATE THE VALUE TO -->
                <label for="newValue">New Value:</label>
                <input type="text" id="newValue" name="newValue" required><br>

                <!-- WHICH INFORMATION WOULD YOU LIKE TO UPDATE -->
                <label for="column">Column:</label>
                <select name="column" id="column" required>
                    <option value="">Select an option</option>
                    <option value="book_id">Book ID</option>
                    <option value="book_name">Book Name</option>
                    <option value="year">Year Published</option>
                    <option value="genre">Book Genre</option>
                    <option value="age_group">Book Age Group</option>
                    <option value="author_id">Author ID</option>
                </select><br>

                <p><input type="submit"></p>
            </form><br>
            <?php
            if ($_POST['bookIDChange']) {   //insures code is only run when form is submitted
                //Storing information from form into variables to be used in code
                $column = $_POST['column'];
                $bookIDChange = $_POST['bookIDChange'];
                $newValue = $_POST['newValue'];

                //Using variables above to create an sql query to access the books table and storing it a variable named $sql
                $sql = "UPDATE books SET $column = '$newValue' WHERE book_id = $bookIDChange";

                header("refresh: 0"); //refreshes page to update table

                //runs the sql statement while telling the user if the sql statement was succesful
                if ($db->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            ?>

            <!-- Form gathering information to update a book -->
            <form method="POST">
                Update Author:<br>
                <!-- Author ID you want to change -->
                <label for="AuthorIDChange">ID of the Author you want to change:</label>
                <input type="text" id="AuthorIDChange" name="AuthorIDChange" required><br>

                <!-- New value of the data you want to change -->
                <label for="newValue">New Value:</label>
                <input type="text" id="newValue" name="newValue" required><br>

                <!-- Where can this data be found -->
                <label for="column">Column:</label>
                <select name="column" id="column" required>
                    <option value="">Select an option</option>
                    <option value="auhtor_id">Author ID</option>
                    <option value="author_name">Author Name</option>
                    <option value="age">Age</option>
                    <option value="writing_genre">Writing Genre</option>
                </select><br>

                <p><input type="submit"></p>

            </form>
            <?php
            if ($_POST['AuthorIDChange']) { //insures code is only run when form is submitted
                //stores POST superglobals into variables
                $column = $_POST['column'];
                $AuthorIDChange = $_POST['AuthorIDChange'];
                $newValue = $_POST['newValue'];

                $sql = "UPDATE authors SET $column = '$newValue' WHERE author_id = $AuthorIDChange"; //sql statement to update author with paremeters gathered in form

                header("refresh: 0"); //refreshes page to update table

                if ($db->query($sql) === TRUE) { //runs the sql statement while checking if it was successful
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            }
            ?>
            <p>
                Signed in as a Librarian
                <!-- Links to logout page and logsout the user -->
                <a href="login\logout.php">Logout</a>
            </p>
        </body>
    <?php

    } else {
        //Runs only if a user accesses this page but doesn't have permission to do so
    ?><h1>Error, you are not signed in as a librarian. Would you like to sign-in?</h1>
        <form action="http://www.userauthenticationapp.com/">
            <input type="submit" value="sign in">
        </form>
    <?php
    }
    ?>

</html>