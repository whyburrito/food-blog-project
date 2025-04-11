<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';
$error = null;
$post_id = $_GET['id'] ?? null;

if (!$post_id || !filter_var($post_id, FILTER_VALIDATE_INT)) {
    die("Invalid Post ID.");
}
$post_id = (int)$post_id;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submitted_post_id = $_POST['post_id'] ?? null;
    if ($submitted_post_id != $post_id) {
        die("Post ID mismatch during update.");
    }

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $image = trim($_POST['image']);

    if (empty($title) || empty($content) || empty($image)) {
        $error = "All fields are required.";
    } else {
        $stmt = $conn->prepare("UPDATE Blog_Posts SET title=?, content=?, image=? WHERE post_id=?");
        if ($stmt) {
            $stmt->bind_param("sssi", $title, $content, $image, $post_id);
            if ($stmt->execute()) {
                header("Location: index.php?status=updated");
                exit();
            } else {
                $error = "Update failed: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Database error preparing update statement: " . $conn->error;
        }
    }
}

// Fetch post data using JOIN to get username
$stmt_fetch = $conn->prepare("SELECT p.*, u.username AS author_username
                             FROM Blog_Posts p
                             LEFT JOIN users u ON p.author_id = u.id
                             WHERE p.post_id = ?");
$post = null;
if ($stmt_fetch) {
    $stmt_fetch->bind_param("i", $post_id);
    $stmt_fetch->execute();
    $result = $stmt_fetch->get_result();
    $post = $result->fetch_assoc();
    $stmt_fetch->close();
} else {
    die("Database error preparing fetch statement: " . $conn->error);
}

if (!$post) {
     header("Location: index.php?status=notfound");
     exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post - <?php echo htmlspecialchars($post['title']); ?> - BBB</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Atma' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
     <div class="navbar mb-5" id="nav">
         <a href="index.php" class="d-flex align-items-center text-decoration-none text-dark">
            <img src="icons/logo.png" alt="BBB Logo" class="img-navbar">
            <h5 class="fw-bold head-navbar mb-0" style="text-transform: uppercase;">BBB</h5>
         </a>
         <div id="menu" class="d-flex align-items-center">
            <a href="index.php" class="active">Home</a>
            <a href="about.php">About</a>
            <span class="navbar-text mx-3">
                Hi, <?php echo htmlspecialchars($_SESSION['username']); ?>!
            </span>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="d-flex flex-column flex-lg-row justify-content-center align-items-start" style="min-height: 75vh;">
             <div class="edit-card-preview mb-4 mb-lg-0 me-lg-4">
                <p class="text-center text-muted small mb-1">Preview</p>
                 <div class="card h-100">
                    <img src="<?php echo htmlspecialchars(!empty($_POST['image']) ? $_POST['image'] : $post['image']); ?>" class="card-img-top" alt="Post Image Preview" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars(!empty($_POST['title']) ? $_POST['title'] : $post['title']); ?></h5>
                        <p class="card-text text-muted mb-2">
                            <small>
                                By: <?php echo htmlspecialchars($post['author_username'] ?? 'Unknown Author'); ?> <br>
                                Created: <?php echo date('M j, Y', strtotime($post['created_at'])); ?>
                                <?php if ($post['updated_at'] && strtotime($post['updated_at']) > strtotime($post['created_at'])): ?>
                                    <br>Updated: <?php echo date('M j, Y', strtotime($post['updated_at'])); ?>
                                <?php endif; ?>
                            </small>
                        </p>
                        <p class="card-text flex-grow-1">
                            <?php
                                $display_content = !empty($_POST['content']) ? $_POST['content'] : $post['content'];
                                echo htmlspecialchars(substr($display_content, 0, 100)) . (strlen($display_content) > 100 ? '...' : '');
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="edit-form-container card shadow-lg p-4" style="background: white; border-radius: 15px; width: 100%; max-width: 600px;">
                <h2 class="text-center mb-3">Edit Post</h2>
                 <?php if ($error): ?>
                    <div class="alert alert-danger p-2 small"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST" action="edit.php?id=<?php echo $post_id; ?>">
                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars(!empty($_POST['title']) ? $_POST['title'] : $post['title']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content:</label>
                        <textarea id="content" name="content" class="form-control" rows="8" required><?php echo htmlspecialchars(!empty($_POST['content']) ? $_POST['content'] : $post['content']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image URL:</label>
                        <input type="url" id="image" name="image" class="form-control" value="<?php echo htmlspecialchars(!empty($_POST['image']) ? $_POST['image'] : $post['image']); ?>" required>
                    </div>
                     <div class="d-flex justify-content-end">
                         <a href="index.php" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>