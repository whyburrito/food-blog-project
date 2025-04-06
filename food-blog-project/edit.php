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
        <div class="heading mb-5">
            <div class="text-center logo">
                <?php
                $result = $conn->query("SELECT * FROM Blog_Posts WHERE post_id=$post_id");
                ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="Post Image">
                        <div class="card-body" style="border-top: solid 1px #EBDBCC;">
                            <h5 class="card-title"><?php echo $row['title']; ?></h5>
                            <p class="card-text"><?php echo substr($row['content'], 0, 100) . '...'; ?></p>
                            <button class="btn btn-read" data-bs-toggle="modal" data-bs-target="#postModal<?php echo $row['post_id']; ?>">
                                Read More
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center header">
                <h2>Edit Post</h2>
                <form method="POST">
                    <div class="mb-3">
                        <label>Title:</label>
                        <input type="text" name="title" class="form-control edit-form" value="<?php echo $post['title']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Content:</label>
                        <textarea name="content" class="form-control edit-form" required><?php echo $post['content']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Image URL:</label>
                        <input type="text" name="image" class="form-control edit-form" value="<?php echo $post['image']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Post</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
