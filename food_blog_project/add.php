<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $image = trim($_POST['image']);
    $author_id = $_SESSION['user_id']; // Get user_id from session

    if (empty($title) || empty($content) || empty($image)) {
        $error = "All fields are required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO Blog_Posts (author_id, title, content, image) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("isss", $author_id, $title, $content, $image);
            if ($stmt->execute()) {
                header("Location: index.php?status=added");
                exit();
            } else {
                $error = "Failed to add post: " . $stmt->error;
            }
            $stmt->close();
        } else {
             $error = "Database error preparing statement: " . $conn->error;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Post - BBB</title>
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

    <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 600px; background: white; border-radius: 15px;">
            <h2 class="text-center mb-4">Add New Post</h2>
             <?php if ($error): ?>
                <div class="alert alert-danger p-2 small"><?php echo $error; ?></div>
             <?php endif; ?>
            <div class="add-form">
                <form method="POST" action="add.php">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" id="title" name="title" class="form-control" required value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Description:</label>
                        <textarea id="content" name="content" class="form-control" rows="6" required><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image URL:</label>
                        <input type="url" id="image" name="image" class="form-control" required placeholder="https://example.com/image.jpg" value="<?php echo isset($_POST['image']) ? htmlspecialchars($_POST['image']) : ''; ?>">
                    </div>
                    <div class="d-flex justify-content-end">
                         <a href="index.php" class="btn btn-secondary me-2">Cancel</a>
                         <button type="submit" class="btn btn-primary">Add Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>