
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
    <link rel="stylesheet" href="styles.css">

</head>
<body style="background-color: #dbc7b4;">
    <div class="about-header">
        <h1 class="text-center">ABOUT US</h1>
        <p>Boodle Bazinga Bonanza is a food blog website created by a team of four people for their Information Management Finals</p>
    </div>

    <!-- Box Container -->
    <div class="container my-5">
    <div class="card shadow-lg p-4 text-black" style="background-color: #dbc7b4;">
            <h2 class="text-center mb-3">Meet The Team</h2>

            <div class="team-member text-center my-3">
                <h3 class="mb-2">Lloyd Lorenzo</h3>
                <p>Description here</p>
            </div>

            <div class="team-member text-center my-3">
                <h3 class="mb-2">Matthew Mesia</h3>
                <p>An aspiring game developer with experience in sound programming. He loves eating food. He helps out with the website's front-end coding.</p>
            </div>

            <div class="team-member text-center my-3">
                <h3 class="mb-2">Rysa Abadier</h3>
                <p>Description here</p>
            </div>

            <div class="team-member text-center my-3">
                <h3 class="mb-2">Sean Salvador</h3>
                <p>Description Here</p>
            </div>  
        </div>
    </div>

    <div class="text-center mt-3">
        <a href="index.php" class="btn btn-primary">
            <img src="icons/back.png" height="20rem" width="20rem"> Back
        </a>
    </div>
</body>
</html>