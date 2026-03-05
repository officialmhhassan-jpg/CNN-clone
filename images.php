<?php
require_once 'db.php';

// Fix for articles with empty or broken images
$placeholder = "https://picsum.photos/800/600?random=";

$stmt = $pdo->query("SELECT id, image FROM articles");
$articles = $stmt->fetchAll();

foreach ($articles as $art) {
    if (empty($art['image']) || strpos($art['image'], 'picsum.photos') !== false) {
        $new_image = "https://picsum.photos/800/600?random=" . $art['id'];
        $update = $pdo->prepare("UPDATE articles SET image = ? WHERE id = ?");
        $update->execute([$new_image, $art['id']]);
    }
}

echo "Images updated successfully.";
?>
