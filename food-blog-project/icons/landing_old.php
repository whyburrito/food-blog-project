<?php
include 'db.php';
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid login.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to BBB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-body d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="max-width: 800px; width: 100%;">
        <div class="row g-0">
            <!-- Left Column with Logo -->
            <div class="col-md-6 d-flex align-items-center justify-content-center bg-light">
                <img src="icons/logo.png" alt="BBB Logo" class="img-fluid p-3" style="max-height: 200px;">
            </div>

            <!-- Right Column with Login Form -->
            <div class="col-md-6 p-4">
                <h2 class="mb-4">Log In</h2>
                <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
                <form method="POST">
                    <div class="mb-3">
                        <input name="username" class="form-control" required placeholder="Username">
                    </div>
                    <div class="mb-3">
                        <input name="password" type="password" class="form-control" required placeholder="Password">
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">Log In</button>
                        <a href="signup.php" class="btn btn-link">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>