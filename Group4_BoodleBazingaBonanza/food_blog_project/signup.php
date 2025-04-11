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
            header("Location: landing.php?status=signup_success");
            exit();
        } else {
            $error = "Signup failed.";
        }
        $stmt->close();
    }
    $check->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up - BBB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Atma' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="d-flex flex-column justify-content-center align-items-center vh-100">
    <div class="heading mb-5" style="width: 40%;">
        <!-- Logo -->
        <div class="text-center mt-2" style="position: absolute;">
            <a href="landing.php" class="btn btn-view btn-back"><img src="icons/back.png" height="10rem" width="10rem" style="margin: 0.2rem 0.2rem 0;"><span></span></a>
        </div>
        <div class="text-center logo" style="background: white;">
            <img src="icons/logo.png" alt="BBB Logo" class="img-fluid">
        </div>

        <!-- Right Column with Signup Form -->
        <div class="col-md-6 p-4 form">
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
                    <button type="submit" class="btn btn-primary">Register</button>
                    <div class="d-inline">
                        Already have an account? <a href="login.php" class="btn btn-link p-0">Log in!</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
