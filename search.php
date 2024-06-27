<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Memastikan query terdefinisi
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Menambahkan escaping pada query untuk mencegah SQL Injection
$escaped_query = $conn->real_escape_string($query);

$sql = "SELECT * FROM users WHERE username LIKE '%$escaped_query%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="search-container">
        <form action="search.php" method="get">
            <input type="text" name="query" placeholder="Search users..." value="<?php echo htmlspecialchars($query); ?>">
            <button type="submit">Search</button>
        </form>

        <div class="search-results">
            <?php if ($result->num_rows > 0): ?>
                <ul>
                    <?php while($user = $result->fetch_assoc()): ?>
                        <li>
                            <a href="profile.php?user_id=<?php echo $user['id']; ?>">
                                <?php echo htmlspecialchars($user['username']); ?>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No users found.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>
