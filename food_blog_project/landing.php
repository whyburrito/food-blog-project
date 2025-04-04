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
    <link rel="stylesheet" href="css/styles.css">
</head>
<body style="background-color: #dbc7b4;" class="d-flex flex-column justify-content-center align-items-center vh-100">
    <!-- Logo and Header -->
    <div class="text-center mb-4">
        <img src="icons/logo1.png" alt="BBB Logo" class="img-fluid" style="max-height: 150px;">
        <h1 class="mt-3 fw-bold">Boodle Bazinga Bonanza</h1>
        <h3>Welcome to BBB! This is a food blog where you can share your favorite meals!</h3>
    </div>

    <!-- Navigation Buttons Section -->
    <div class="container">
        <div class="row justify-content-center mb-4">
            <!-- Log In and Sign Up Buttons -->
            <div class="col-auto">
                <a href="login.php" class="btn btn-primary btn-lg m-2">Log In</a>
            </div>
            <div class="col-auto">
                <a href="signup.php" class="btn btn-secondary btn-lg m-2">Sign Up</a>
            </div>
        </div>

        <!-- About Us Text and Button -->
        <div class="text-center">
            <h3>Want to learn more about the website? Check here!</h3>
            <a href="about.php" class="btn btn-info btn-lg m-2">About Us</a>
        </div>
    </div>
</body>
</html>
