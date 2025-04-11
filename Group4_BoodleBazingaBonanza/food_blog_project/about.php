<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About BBB</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Atma' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="navbar mb-5 sticky-top" id="nav">
         <a href="<?php echo isset($_SESSION['user_id']) ? 'index.php' : 'landing.php'; ?>" class="d-flex align-items-center text-decoration-none text-dark">
            <img src="icons/logo.png" alt="BBB Logo" class="img-navbar">
            <h5 class="fw-bold head-navbar mb-0" style="text-transform: uppercase;">BBB</h5>
         </a>
        <div id="menu" class="d-flex align-items-center">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="index.php">Home</a>
            <a href="about.php" class="active">About</a>
            <span class="navbar-text mx-3">
                Hi, <?php echo htmlspecialchars($_SESSION['username']); ?>!
            </span>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="landing.php">Home</a>
            <a href="about.php" class="active">About</a>
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
        <?php endif; ?>
        </div>
    </div>

    <div class="container my-4">
        <div class="text-center mb-4">
            <img src="icons/logo.png" alt="BBB Logo" class="img-fluid mb-3" style="max-height: 150px;">
            <h2 style="text-transform: uppercase;">About Us</h2>
            <p class="lead" style="margin: 0;">Boodle Bazinga Bonanza is a food blog website created by a team of four people for their Information Management Finals.</p>
        </div>

        <div class="card shadow-lg p-4 text-black" style="border-radius: 15px;">
            <h2 class="text-center mb-4">Meet The Team</h2>
            <div class="row text-center">
                 <div class="col-md-6 col-lg-3 mb-4">
                    <div class="team-member">
                        <h3 class="mb-2">Lloyd Lorenzo</h3>
                        <p>A programmer who loves to play games.</p>
                    </div>
                 </div>
                 <div class="col-md-6 col-lg-3 mb-4">
                    <div class="team-member">
                        <h3 class="mb-2">Matthew Mesia</h3>
                        <p>An aspiring game developer with experience in sound programming. He loves eating food. He helps out with the website's front-end coding.</p>
                    </div>
                 </div>
                  <div class="col-md-6 col-lg-3 mb-4">
                    <div class="team-member">
                        <h3 class="mb-2">Rysa Abadier</h3>
                        <p>An aspiring programmer who aims to explore every language to further understand computers to help make things a little bit easier.</p>
                    </div>
                  </div>
                 <div class="col-md-6 col-lg-3 mb-4">
                    <div class="team-member">
                        <h3 class="mb-2">Sean Salvador</h3>
                        <p>A programmer who loves traveling and trying out new cuisines.</p>
                    </div>
                 </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>