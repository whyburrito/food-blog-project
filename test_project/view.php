<?php
include 'db.php';
$post_id = $_GET['id'];
$result = $conn->query("SELECT * FROM Blog_Posts WHERE post_id=$post_id");
$post = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $post['title']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2><?php echo $post['title']; ?></h2>
    <img src="<?php echo $post['image']; ?>" class="img-fluid mb-3">
    <p><?php echo $post['content']; ?></p>
    <a href="index.php" class="btn btn-secondary">Back</a>
</body>
</html>
