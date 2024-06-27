<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_GET['id'];
$sql = "SELECT users.* FROM follows JOIN users ON follows.following_id = users.id WHERE follows.follower_id = '$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Following</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="following">
        <h2>Following</h2>
        <?php while ($following = $result->fetch_assoc()): ?>
            <div class="following">
                <img src="<?php echo $following['profile_image']; ?>" alt="Profile Image" width="50">
                <span><?php echo $following['username']; ?></span>
            </div>
        <?php endwhile; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
