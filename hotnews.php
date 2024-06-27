<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch RSS feed
$feed_url = 'https://rss.nytimes.com/services/xml/rss/nyt/HomePage.xml';
$rss = simplexml_load_file($feed_url);
$news = [];

foreach ($rss->channel->item as $item) {
    $news[] = [
        'title' => (string) $item->title,
        'link' => (string) $item->link,
        'description' => (string) $item->description
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hot News</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Hot News</h1>
    <div class="news">
        <?php foreach ($news as $item): ?>
            <div class="news-item">
                <h2><?php echo $item['title']; ?></h2>
                <p><?php echo $item['description']; ?></p>
                <a href="<?php echo $item['link']; ?>" target="_blank">Read more</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
