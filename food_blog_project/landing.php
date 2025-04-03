<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome to BBB</title>
</head>
<body>
    <h1>Boodle Bazinga Bonanza</h1>
    <a href="login.php">Log In</a> |
    <a href="signup.php">Sign Up</a>
</body>
</html>
