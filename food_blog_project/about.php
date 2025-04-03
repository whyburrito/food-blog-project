<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
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
<body>
    <div>
        <h1 class="text-center">ABOUT</h1>
        <p>Boodle Bazinga Bonanza is a food blog website created by a team of four people for their Information Management Finals</p>
    </div>

    <h2>Meet The Team</h2>
    <h3>Lloyd Lorenzo</h3>
    <p>Description here</P>
    <h3>Matthew Mesia</h3>
    <p>An aspiring game developer with experience in sound programming. He loves eating food. He helps out with the website's front-end coding.</P>
    <h3>Rysa Abadier</h3>
    <p>Description here</P>
    <h3>Sean Salvador</h3>
    <p>Description Here</P>

    <a href="index.php" class="btn btn-view" type="button" id="index"><span></span><img src="icons/back.png" height="20rem" width="20rem"></a>

</body>
</html>