<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "blog_project";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
