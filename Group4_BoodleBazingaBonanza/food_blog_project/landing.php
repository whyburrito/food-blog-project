<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to BBB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Atma' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="d-flex flex-column justify-content-center align-items-center vh-100">
    <!-- Logo and Header -->
    <div class="heading mb-5">
        <div class="text-center logo">
            <img src="icons/logo.png" alt="BBB Logo" class="img-fluid">
            <h2 class="fw-bold" style="text-transform: uppercase;">Boodle Bazinga Bonanza</h2>
        </div>
        <div class="text-center header">
            <p class="mb-4">Welcome to BBB! This is a food blog where we share our favorite meals!</p>

            <div class="row justify-content-center">
            <!-- Log In and Sign Up Buttons -->
                <a href="login.php" class="btn btn-primary m-2 auth">Login</a>
                <a href="signup.php" class="btn btn-primary m-2 auth">Sign Up</a>
            </div>
        </div>
    </div>

    <!-- Navigation Buttons Section -->
    <div class="text-center">
        <h4>Want to learn more about the website? Check here!</h4>
        <a href="about.php" class="btn btn-info btn-lg m-2">About Us</a>
    </div>
</body>
</html>
