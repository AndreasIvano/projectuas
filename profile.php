<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "User not found.";
    exit();
}

$user = $result->fetch_assoc();

$sql_posts = "SELECT * FROM posts WHERE user_id='$user_id' ORDER BY created_at DESC";
$result_posts = $conn->query($sql_posts);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>&nbsp;</h1>
    <table width="200" border="0">
      <tr>
        <td>&nbsp;</td>
        <td><?php echo htmlspecialchars($user['username']); ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Image" width="100"></td>
      </tr>
    </table>
    <h2 align="center">My Posts</h2>
    <div class="posts">
        <?php while($post = $result_posts->fetch_assoc()): ?>
            <div class="post">
                <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image">
                <div class="post-description">
                    <p><?php echo htmlspecialchars($post['description']); ?></p>
                    <?php if($post['location']): ?>
                        <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($post['location']); ?>" target="_blank">
                            <span><?php echo htmlspecialchars($post['location']); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
