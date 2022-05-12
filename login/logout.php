<!DOCTYPE html>
<html>
<?php
session_start();
session_destroy();
?>

<form action="http://www.userauthenticationapp.com/" method="POST">
    <p>you are logged out</p>
    <input type="submit" value="continue">
</form>

</html>