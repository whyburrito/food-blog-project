<?php include 'db.php'; 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: landing.php");
    exit();
}
$is_admin = ($_SESSION['role'] === 'admin');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
</head>
<body class="container mt-4">

    <h2 class="text-center">BBB</h2>
    <h4 class="text-center mb-4">Boodle Bazinga Bonanza</h4>
    
        <div class="text-end mb-3">

            <?php if ($is_admin): ?>
                <a href="add.php" class="btn btn-add" id="create" onmouseover="createPost()"><img src="icons/add-post.png" height="20rem" width="20rem"><span></span></a>
            <?php endif; ?>
            <button class="btn btn-view" type="button" onclick="galleryView()" onmouseover="gallery()" id="gallery"><span></span><img src="icons/gallery.png" height="20rem" width="20rem"></button>
            <button class="btn btn-view" type="button" onclick="listView()" onmouseover="list()" id="list"><span></span><img src="icons/list.png" height="20rem" width="20rem"></button>
            <a href="about.php" class="btn btn-view" type="button" id="about"><span></span><img src="icons/information.png" height="20rem" width="20rem"></a>
            <a href="logout.php" class="btn btn-view" type="button" onlick="logout()" onmouseover="logout()" id="logout"><span></span><img src="icons/logout.png" height="20rem" width="20rem"></a>
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

                        <?php if ($is_admin): ?>
                            <a href="edit.php?id=<?php echo $row['post_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?id=<?php echo $row['post_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this post?')">Delete</a>
                        <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <button class="btn btn-view" type="button" onclick="scrollToTop()" id="scroll"><img src="icons/back-to-top.png" height="25rem" width="25rem"></button>
    <a href="add.php" class="btn btn-add" id="new"><img src="icons/add-post.png" height="25rem"></a>
</body>
</html>
