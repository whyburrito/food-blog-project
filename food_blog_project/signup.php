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
<form method="POST">
    <h2>Sign Up</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <input name="username" required placeholder="Username"><br>
    <input name="password" type="password" required placeholder="Password"><br>
    <button type="submit">Register</button>
</form>
