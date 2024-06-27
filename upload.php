<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $description = $_POST['description'];
    $location = $_POST['location'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        
        $sql = "INSERT INTO posts (user_id, image, description, location) VALUES ('$user_id', '$target_file', '$description', '$location')";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" required>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
        
        <label for="location">Location:</label>
        <input type="text" id="location" name="location">
        
        <button type="submit">Upload</button>
    </form>
</body>
</html>
