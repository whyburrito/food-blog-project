<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: landing.php");
    exit();
}

$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$logged_in_user = $_SESSION['username'];
$logged_in_user_id = $_SESSION['user_id'];

$search_query = trim($_GET['search_query'] ?? '');
$sort_by = $_GET['sort_by'] ?? 'created_at_desc';

$sql = "SELECT p.*, u.username AS author_username
        FROM Blog_Posts p
        LEFT JOIN users u ON p.author_id = u.id";

$params = [];
$types = "";
$where_clauses = [];

if (!empty($search_query)) {
    $where_clauses[] = "(p.title LIKE ? OR p.content LIKE ? OR u.username LIKE ?)";
    $search_term = "%" . $search_query . "%";
    $params = [$search_term, $search_term, $search_term];
    $types = "sss";
}

if (!empty($where_clauses)) {
    $sql .= " WHERE " . implode(' AND ', $where_clauses);
}

switch ($sort_by) {
    case 'created_at_asc': $sql .= " ORDER BY p.created_at ASC"; break;
    case 'author_asc': $sql .= " ORDER BY u.username ASC, p.created_at DESC"; break;
    case 'author_desc': $sql .= " ORDER BY u.username DESC, p.created_at DESC"; break;
    case 'title_asc': $sql .= " ORDER BY p.title ASC"; break;
    case 'title_desc': $sql .= " ORDER BY p.title DESC"; break;
    case 'updated_at_desc': $sql .= " ORDER BY p.updated_at DESC, p.created_at DESC"; break;
    case 'updated_at_asc': $sql .= " ORDER BY p.updated_at ASC, p.created_at ASC"; break;
    case 'created_at_desc': default: $sql .= " ORDER BY p.created_at DESC"; break;
}

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Database error preparing statement: " . $conn->error);
}
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BBB Food Blog - Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Atma' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
    <style>
        .loading-spinner { border: 4px solid rgba(0, 0, 0, 0.1); width: 36px; height: 36px; border-radius: 50%; border-left-color: #BD9A75; animation: spin 1s ease infinite; margin: 2rem auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>

<body class="gallery-view">
    <!-- Navbar -->
    <div class="navbar sticky-top" id="nav">
        <a href="index.php" style="text-decoration: none; color: inherit; display: inline-flex; align-items: center;">
            <img src="icons/logo.png" alt="BBB Logo" class="img-navbar">
            <h5 class="fw-bold head-navbar" style="text-transform: uppercase;">BBB</h5>
        </a>
        <div id="menu">
            <a href="index.php" class="active">Home</a>
            <a href="about.php">About</a>
            <span class="navbar-text mx-3" style="font-family: sans-serif; font-size: medium; vertical-align: middle;">
                Hi, <?php echo htmlspecialchars($logged_in_user); ?>!
            </span>
            <a href="logout.php" title="Logout">Logout</a>
        </div>
    </div>

    <div class="container" id="index-container">
        <div class="card search-sort-form p-3 mb-4 shadow-sm">
             <form method="GET" action="index.php" class="row g-2 align-items-center">
                 <div class="col-md-5">
                     <input type="search" name="search_query" class="form-control form-control-sm" placeholder="Search title, content, or author..." value="<?php echo htmlspecialchars($search_query); ?>" aria-label="Search Posts">
                 </div>
                 <div class="col-md-3">
                    <select name="sort_by" class="form-select form-select-sm" aria-label="Sort Posts By">
                        <option value="updated_at_desc" <?php if ($sort_by == 'updated_at_desc') echo 'selected'; ?>>Sort: Recently Updated</option>
                        <option value="created_at_desc" <?php if ($sort_by == 'created_at_desc') echo 'selected'; ?>>Sort: Newest First</option>
                        <option value="created_at_asc" <?php if ($sort_by == 'created_at_asc') echo 'selected'; ?>>Sort: Oldest First</option>
                        <option value="title_asc" <?php if ($sort_by == 'title_asc') echo 'selected'; ?>>Sort: Title A-Z</option>
                        <option value="title_desc" <?php if ($sort_by == 'title_desc') echo 'selected'; ?>>Sort: Title Z-A</option>
                        <option value="author_asc" <?php if ($sort_by == 'author_asc') echo 'selected'; ?>>Sort: Author A-Z</option>
                        <option value="author_desc" <?php if ($sort_by == 'author_desc') echo 'selected'; ?>>Sort: Author Z-A</option>
                    </select>
                 </div>
                 <div class="col-md-auto">
                     <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                     <?php if (!empty($search_query) || $sort_by !== 'created_at_desc'): ?>
                        <a href="index.php" class="btn btn-outline-secondary btn-sm ms-1">Clear</a>
                     <?php endif; ?>
                 </div>
                 <div class="col-md text-end">
                     <?php if ($is_admin): ?>
                         <button type="button" class="btn btn-add btn-sm" title="Add New Post" id="create" data-bs-toggle="modal" data-bs-target="#addPostModal">
                             <img src="icons/add-post.png" height="18rem" width="18rem">
                             <span class="d-none d-md-inline"> Add Post</span>
                         </button>
                     <?php endif; ?>
                     <button class="btn btn-view btn-sm" type="button" title="Gallery View" onclick="galleryView()" id="gallery"><img src="icons/gallery.png" height="18rem" width="18rem"></button>
                     <button class="btn btn-view btn-sm" type="button" title="List View" onclick="listView()" id="list"><img src="icons/list.png" height="18rem" width="18rem"></button>
                 </div>
             </form>
        </div>

        <!-- Status Messages -->
        <?php if (isset($_GET['status'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php
                    switch ($_GET['status']) {
                        case 'added': echo 'Post successfully added!'; break;
                        case 'updated': echo 'Post successfully updated!'; break;
                        case 'deleted': echo 'Post successfully deleted!'; break;
                        case 'notfound': echo 'Post not found.'; break;
                    }
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Search Results Info -->
        <?php if (!empty($search_query)): ?>
            <p class="mb-3 fst-italic">Showing results for: <strong><?php echo htmlspecialchars($search_query); ?></strong></p>
        <?php endif; ?>

        <!-- Post Display Area -->
        <div class="row" id="post-container">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()):
                    $created_date = date('M j, Y', strtotime($row['created_at']));
                    $updated_date = null;
                    if ($row['updated_at'] && strtotime($row['updated_at']) > strtotime($row['created_at']) + 60) {
                       $updated_date = date('M j, Y', strtotime($row['updated_at']));
                    }
                ?>
                <div class="col-md-6 col-lg-4 mb-4 post-card-column">
                    <div class="card h-100 shadow-sm post-card">
                        <div class="position-relative">
                            <img src="<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>" style="height: 200px; object-fit: cover;">
                            <?php if ($is_admin): ?>
                                <div class="btn-group dropdown post-actions">
                                    <button type="button" class="btn btn-sm btn-view btn-extra" data-bs-toggle="dropdown" aria-expanded="false" title="Post Actions"><img src="icons/dots.png" height="15rem" width="15rem"></button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a href="edit.php?id=<?php echo $row['post_id']; ?>" class="dropdown-item">Edit</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['post_id']; ?>">
                                                Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text text-muted mb-2 post-meta">
                                <small>
                                    By: <strong><?php echo htmlspecialchars($row['author_username'] ?? 'Unknown'); ?></strong><br>
                                    Posted: <?php echo $created_date; ?>
                                    <?php if ($updated_date): ?>
                                        <span class="text-info">(Updated: <?php echo $updated_date; ?>)</span>
                                    <?php endif; ?>
                                </small>
                            </p>
                            <p class="card-text flex-grow-1 post-excerpt">
                                <?php echo htmlspecialchars(substr($row['content'], 0, 120)) . (strlen($row['content']) > 120 ? '...' : ''); ?>
                            </p>
                            <button class="btn btn-read mt-auto align-self-start" data-bs-toggle="modal" data-bs-target="#postModal<?php echo $row['post_id']; ?>">
                                Read More »
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Read More Modal -->
                <div class="modal fade" id="postModal<?php echo $row['post_id']; ?>" tabindex="-1" aria-labelledby="postModalLabel<?php echo $row['post_id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="postModalLabel<?php echo $row['post_id']; ?>"><?php echo htmlspecialchars($row['title']); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="<?php echo htmlspecialchars($row['image']); ?>" class="img-fluid-modal mb-3 rounded shadow-sm" alt="<?php echo htmlspecialchars($row['title']); ?>">
                                <p class="text-muted mb-2">
                                    <small>
                                        By: <strong><?php echo htmlspecialchars($row['author_username'] ?? 'Unknown'); ?></strong><br>
                                        Posted: <?php echo date('F j, Y, g:i a', strtotime($row['created_at'])); ?>
                                        <?php if ($row['updated_at'] && strtotime($row['updated_at']) > strtotime($row['created_at']) + 60): ?>
                                            <br>Updated: <?php echo date('F j, Y, g:i a', strtotime($row['updated_at'])); ?>
                                        <?php endif; ?>
                                    </small>
                                </p>
                                <hr>
                                <p class="post-full-content"><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                            </div>
                            <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->
                 <?php if ($is_admin): ?>
                    <div class="modal fade" id="deleteModal<?php echo $row['post_id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $row['post_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 1rem;">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel<?php echo $row['post_id']; ?>">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete the post titled:<br><strong><?php echo htmlspecialchars($row['title']); ?></strong>?
                                    <p class="text-danger small mt-2">This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form method="POST" action="delete.php" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $row['post_id']; ?>">
                                        <button type="submit" class="btn btn-danger">Delete Post</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                 <?php endif; ?>

                <?php endwhile; ?>
             <?php elseif (!empty($search_query)) : ?>
                <div class="col">
                    <p class="text-center mt-4">No posts found matching your search criteria.</p>
                </div>
            <?php else: ?>
                 <div class="col">
                    <p class="text-center mt-4">No posts available yet.</p>
                    <?php if ($is_admin): ?>
                        <p class="text-center"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPostModal">Add the First Post</button></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php $stmt->close(); ?>
        </div>

        <!-- Loading Indicator (Optional) -->
        <div id="loading-indicator" style="display: none;" class="text-center my-4">
            <div class="loading-spinner"></div>
            <p>Loading posts...</p>
        </div>

        <!-- Back to Top Button -->
        <button class="btn btn-view btn-float shadow" type="button" onclick="scrollToTop()" id="scroll" title="Back to top"><img src="icons/back-to-top.png" height="25rem" width="25rem"></button>

    </div> <!-- End Container -->

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
                    <label for="addTitle" class="form-label">Title:</label>
                    <input type="text" id="addTitle" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="addContent" class="form-label">Description:</label>
                    <textarea id="addContent" name="content" class="form-control" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="addImage" class="form-label">Image URL:</label>
                    <input type="url" id="addImage" name="image" class="form-control" required placeholder="https://example.com/image.jpg">
                </div>
                </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                     <button type="submit" class="btn btn-primary">Add Post</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Your Custom Script -->
    <script src="script.js"></script>
</body>
</html>
<?php $conn->close(); ?>