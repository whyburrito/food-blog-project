<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

    <h2 class="text-center mb-4">Simple Blog</h2>

    <div class="text-end mb-3">
        <a href="add.php" class="btn btn-success">+ Add New Post</a>
    </div>

    <div class="row">
        <?php
        $result = $conn->query("SELECT * FROM Blog_Posts ORDER BY created_at DESC");
        while ($row = $result->fetch_assoc()):
        ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="Post Image">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['title']; ?></h5>
                    <p class="card-text"><?php echo substr($row['content'], 0, 100) . '...'; ?></p>
                    <a href="view.php?id=<?php echo $row['post_id']; ?>" class="btn btn-primary btn-sm">Read More</a>
                    <a href="edit.php?id=<?php echo $row['post_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?php echo $row['post_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this post?')">Delete</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

</body>
</html>
