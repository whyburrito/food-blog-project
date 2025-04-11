<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {

    $post_id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

    if ($post_id === false) {
        header("Location: index.php?status=invalid_id");
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM Blog_Posts WHERE post_id = ?");

    if ($stmt) {
        $stmt->bind_param("i", $post_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                header("Location: index.php?status=deleted");
                exit();
            } else {
                header("Location: index.php?status=notfound");
                exit();
            }
        } else {
            header("Location: index.php?status=delete_error");
            exit();
        }
        $stmt->close();
    } else {
        header("Location: index.php?status=db_error");
        exit();
    }

} else {
    header("Location: index.php");
    exit();
}

$conn->close();
?>