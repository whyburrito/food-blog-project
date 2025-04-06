<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: landing.php");
    exit();
}
?>

<?php include 'db.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_POST['image']; 

    $stmt = $conn->prepare("INSERT INTO Blog_Posts (title, content, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $image);
    
    if ($stmt->execute()) {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Atma' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
</head>
<body>
    <div class="navbar mb-5" id="nav">
        <img src="icons/logo.png" alt="BBB Logo" class="img-navbar">
        <h5 class="fw-bold head-navbar" style="text-transform: uppercase; width: fit-content;">BBB</h5>
        <div id="menu">
            <a href="index.php" class="active">Home</a>
            <a href="about.php">About</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="d-flex flex-column justify-content-center align-items-center" style="height: 75vh! important;">
        <div class="header" style="border-radius: 25px;">
            <h2>Add New Post</h2>
            <div class="add-form form">
                <form method="POST">
                    <div class="mb-3">
                        <label>Title:</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Description:</label>
                        <textarea name="content" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Image URL:</label>
                        <input type="text" name="image" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Post</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>