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
</head>
<body class="container mt-4">
    <h2>Add New Post</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Title:</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Content:</label>
            <textarea name="content" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Image URL:</label>
            <input type="text" name="image" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Post</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
