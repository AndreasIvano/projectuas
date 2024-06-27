<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$follower_id = $_SESSION['user_id'];
$following_id = $_POST['following_id'];

$sql = "INSERT INTO follows (follower_id, following_id) VALUES ('$follower_id', '$following_id')";
if ($conn->query($sql) === TRUE) {
    header("Location: profile.php?id=$following_id");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
