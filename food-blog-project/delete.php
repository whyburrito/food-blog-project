<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: landing.php");
    exit();
}
?>

<?php
include 'db.php';
$post_id = $_GET['id'];
$conn->query("DELETE FROM Blog_Posts WHERE post_id=$post_id");
header("Location: index.php");
?>
