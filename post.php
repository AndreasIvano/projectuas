<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$post_id = $_GET['id'];

// Fetch post details
$sql = "SELECT posts.*, users.username, users.profile_image FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = '$post_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Post not found.";
    exit();
}

$post = $result->fetch_assoc();

// Fetch comments
$sql = "SELECT comments.*, users.username, users.profile_image FROM comments JOIN users ON comments.user_id = users.id WHERE comments.post_id = '$post_id' ORDER BY comments.created_at DESC";
$comments = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $comment = $_POST['comment'];
    
    $sql = "INSERT INTO comments (post_id, user_id, comment) VALUES ('$post_id', '$user_id', '$comment')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: post.php?id=$post_id");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="post">
        <div class="post-header">
            <img src="<?php echo $post['profile_image']; ?>" alt="Profile Image" width="50">
            <span><?php echo $post['username']; ?></span>
        </div>
        <img src="<?php echo $post['image']; ?>" alt="Post Image">
        <div class="post-description">
            <p><?php echo $post['description']; ?></p>
            <span><?php echo $post['location']; ?></span>
        </div>
    </div>
    
    <div class="comments">
        <h2>Comments</h2>
        <?php while($comment = $comments->fetch_assoc()): ?>
            <div class="comment">
                <div class="comment-header">
                    <img src="<?php echo $comment['profile_image']; ?>" alt="Profile Image" width="30">
                    <span><?php echo $comment['username']; ?></span>
                </div>
                <p><?php echo $comment['comment']; ?></p>
            </div>
        <?php endwhile; ?>
        
        <form action="post.php?id=<?php echo $post_id; ?>" method="post">
            <textarea name="comment" placeholder="Add a comment..."></textarea>
            <button type="submit">Comment</button>
        </form>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>
