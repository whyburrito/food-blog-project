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
$result = $conn->query("SELECT * FROM Blog_Posts WHERE post_id=$post_id");
$post = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("UPDATE Blog_Posts SET title=?, content=?, image=? WHERE post_id=?");
    $stmt->bind_param("sssi", $title, $content, $image, $post_id);
    
    if ($stmt->execute()) {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2>Edit Post</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Title:</label>
            <input type="text" name="title" class="form-control" value="<?php echo $post['title']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Content:</label>
            <textarea name="content" class="form-control" required><?php echo $post['content']; ?></textarea>
        </div>
        <div class="mb-3">
            <label>Image URL:</label>
            <input type="text" name="image" class="form-control" value="<?php echo $post['image']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Post</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
