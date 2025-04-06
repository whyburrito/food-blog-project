<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: landing.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>About</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Atma' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
</head>

<body>
    <div class="navbar mb-5" id="nav">
        <img src="icons/logo.png" alt="BBB Logo" class="img-navbar">
        <h5 class="fw-bold head-navbar" style="text-transform: uppercase; width: fit-content;">BBB</h5>
        <div id="menu">
            <a href="index.php">Home</a>
            <a href="about.php" class="active">About</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- Box Container -->
    <div class="container my-4">
        <div class="text-center mb-3">
            <img src="icons/logo.png" alt="BBB Logo" class="img-fluid" style="min-height: 100px;">
            <h2 style="text-transform: uppercase; margin-left: auto;">About US</h2>
            <p style="margin: 0;">Boodle Bazinga Bonanza is a food blog website created by a team of four people for their Information Management Finals.</p>
        </div>

        <div class="card shadow-lg p-4 text-black">
            <h2 class="text-center mb-3">Meet The Team</h2>

            <div class="team-member text-center my-2">
                <h3 class="mb-2">Lloyd Lorenzo</h3>
                <p>Description here</p>
            </div>

            <div class="team-member text-center my-2">
                <h3 class="mb-2">Matthew Mesia</h3>
                <p>An aspiring game developer with experience in sound programming. He loves eating food. He helps out with the website's front-end coding.</p>
            </div>

            <div class="team-member text-center my-2">
                <h3 class="mb-2">Rysa Abadier</h3>
                <p>An aspiring programmer who aims to explore every language to further understand computers to help make things a little bit easier.</p>
            </div>

            <div class="team-member text-center my-2">
                <h3 class="mb-2">Sean Salvador</h3>
                <p>Description Here</p>
            </div>  
        </div>
    </div>
</body>
</html>