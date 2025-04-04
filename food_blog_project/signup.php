<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        $error = "Username already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 'user';
            header("Location: index.php");
            exit();
        } else {
            $error = "Signup failed.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up - BBB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body style="background-color: #dbc7b4;" class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="max-width: 800px; width: 100%;">
        <div class="row g-0">
            <!-- Left Column with Logo -->
            <div class="col-md-6 d-flex align-items-center justify-content-center bg-light">
                <img src="icons/logo1.png" alt="BBB Logo" class="img-fluid p-3" style="max-height: 200px;">
            </div>

            <!-- Right Column with Signup Form -->
            <div class="col-md-6 p-4">
                <h2 class="mb-4">Sign Up</h2>
                <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
                <form method="POST">
                    <div class="mb-3">
                        <input name="username" class="form-control" required placeholder="Username">
                    </div>
                    <div class="mb-3">
                        <input name="password" type="password" class="form-control" required placeholder="Password">
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-success">Register</button>
                        <div class="d-inline">
                            Already have an account? <a href="login.php" class="btn btn-link p-0">Log in!</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
