<?php
include 'db.php';
$post_id = $_GET['id'];
$conn->query("DELETE FROM Blog_Posts WHERE post_id=$post_id");
header("Location: index.php");
?>
