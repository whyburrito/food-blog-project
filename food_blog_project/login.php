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
<form method="POST">
    <h2>Log In</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <input name="username" required placeholder="Username"><br>
    <input name="password" type="password" required placeholder="Password"><br>
    <button type="submit">Log In</button>
</form>
