<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT posts.*, users.username, users.profile_image FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="posts">
        <?php while($post = $result->fetch_assoc()): ?>
            <div class="post">
                <div class="post-header">
                    <img src="<?php echo $post['profile_image']; ?>" alt="Profile Image" width="50">
                    <span><?php echo $post['username']; ?></span>
                </div>
                <a href="post.php?id=<?php echo $post['id']; ?>">
                    <img src="<?php echo $post['image']; ?>" alt="Post Image">
                </a>
                <div class="post-description">
                    <p><?php echo $post['description']; ?></p>
                    <span><?php echo $post['location']; ?></span>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>
