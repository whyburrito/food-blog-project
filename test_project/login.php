<?php
include 'db.php';
session_start();

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
    <title>Login - BBB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Atma' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="d-flex flex-column justify-content-center align-items-center vh-100">
    <div class="heading mb-5" style="width: 40%;">
        <!-- Logo -->
        <div class="text-center logo" style="background: white;">
            <img src="icons/logo.png" alt="BBB Logo" class="img-fluid">
        </div>

        <!-- Right Column with Login Form -->
        <div class="col-md-6 p-4 form">
            <h2 class="mb-4">Login</h2>
            <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
            <form method="POST">
                <div class="mb-3">
                    <input name="username" class="form-control" required placeholder="Username">
                </div>
                <div class="mb-3">
                    <input name="password" type="password" class="form-control" required placeholder="Password">
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <div class="d-inline">
                        No account? <a href="signup.php" class="btn btn-link p-0">Click here!</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
