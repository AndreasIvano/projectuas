<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_GET['id'];
$sql = "SELECT users.* FROM follows JOIN users ON follows.follower_id = users.id WHERE follows.following_id = '$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Followers</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="followers">
        <h2>Followers</h2>
        <?php while ($follower = $result->fetch_assoc()): ?>
            <div class="follower">
                <img src="<?php echo $follower['profile_image']; ?>" alt="Profile Image" width="50">
                <span><?php echo $follower['username']; ?></span>
            </div>
        <?php endwhile; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
