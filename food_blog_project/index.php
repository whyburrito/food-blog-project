<?php
include 'db.php';
session_start();
$is_admin = ($_SESSION['role'] === 'admin');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
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
            <a href="#" class="active">Home</a>
            <a href="about.php">About</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="text-end mb-3">
            <?php if ($is_admin): ?>
                <button class="btn btn-add" id="create" data-bs-toggle="modal" data-bs-target="#addPostModal"><img src="icons/add-post.png" height="20rem" width="20rem"><span></span></button>
            <?php endif; ?>
            <button class="btn btn-view" type="button" onclick="galleryView()" onmouseover="gallery()" id="gallery"><span></span><img src="icons/gallery.png" height="20rem" width="20rem"></button>
            <button class="btn btn-view" type="button" onclick="listView()" onmouseover="list()" id="list"><span></span><img src="icons/list.png" height="20rem" width="20rem"></button>
        </div>

        <div class="row">
            <?php
            $result = $conn->query("SELECT * FROM Blog_Posts ORDER BY created_at DESC");
            while ($row = $result->fetch_assoc()):
            ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="Post Image">
                    <?php if ($is_admin): ?>
                        <div class="btn-group dropdown">
                            <button type="button" class="btn btn-view btn-extra" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 2.5rem;"><img src="icons/dots.png" height="15rem" width="15rem"></button>

                            <ul class="dropdown-menu">
                                <li><a href="edit.php?id=<?php echo $row['post_id']; ?>" class="btn btn-dropdown">Edit</a></li>
                                <li>
                                    <button type="button" class="btn btn-dropdown" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['post_id']; ?>">
                                    Delete
                                    </button>
                                </li>
                            </ul>
                            
                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal<?php echo $row['post_id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $row['post_id']; ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: 1rem;">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel<?php echo $row['post_id']; ?>">Confirm Deletion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete the post titled:<br><strong><?php echo $row['title']; ?></strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <form method="GET" action="delete.php">
                                        <input type="hidden" name="id" value="<?php echo $row['post_id']; ?>">
                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php endif; ?>

                    <div class="card-body" style="border-top: solid 1px #EBDBCC;">
                        <h5 class="card-title"><?php echo $row['title']; ?></h5>
                        <p class="card-text"><?php echo substr($row['content'], 0, 100) . '...'; ?></p>
                        <button class="btn btn-read" data-bs-toggle="modal" data-bs-target="#postModal<?php echo $row['post_id']; ?>">
                            Read More
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Modal for Read More -->
            <div class="modal fade" id="postModal<?php echo $row['post_id']; ?>" tabindex="-1" aria-labelledby="postModalLabel<?php echo $row['post_id']; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="min-width: 100%;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="postModalLabel<?php echo $row['post_id']; ?>"><?php echo $row['title']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="<?php echo $row['image']; ?>" class="img-fluid-modal mb-3">
                            <p style="margin-bottom: 5px;"><?php echo $row['content']; ?></p>
                        </div>
                        <div class="modal-footer"></div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <button class="btn btn-view" type="button" onclick="scrollToTop()" id="scroll"><img src="icons/back-to-top.png" height="25rem" width="25rem"></button>
        <?php if ($is_admin): ?>
            <button class="btn btn-add" id="new" data-bs-toggle="modal" data-bs-target="#addPostModal"><img src="icons/add-post.png" height="25rem"></button>
        <?php endif; ?>
    </div>

    <!-- Bootstrap 5 Modal JavaScript (Required) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Add Post Modal -->
    <div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 1rem;">
        <div class="modal-header">
            <h5 class="modal-title" id="addPostModalLabel">Add New Post</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form method="POST" action="add.php">
            <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Title:</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description:</label>
                <textarea name="content" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Image URL:</label>
                <input type="text" name="image" class="form-control" required>
            </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add Post</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
        </div>
    </div>
    </div>
</body>
</html>
