<?php
session_start();
require_once 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$cat_id = (int)$_GET['id'];

// Fetch Category Details
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$cat_id]);
$category = $stmt->fetch();

if (!$category) {
    header("Location: index.php");
    exit;
}

// Fetch Articles in Category
$stmt = $pdo->prepare("SELECT * FROM articles WHERE category_id = ? ORDER BY created_at DESC");
$stmt->execute([$cat_id]);
$articles = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($category['name']) ?> | CNN Clone</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>

    <?php include 'header.php'; ?>

    <main class="container" style="padding-top: 50px;">
        <h1 style="font-size: 3rem; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 5px; color: var(--neon-cyan);">
            <?= htmlspecialchars($category['name']) ?>
        </h1>
        <p style="color: var(--text-muted); margin-bottom: 50px;">Latest updates and deep dives in <?= strtolower(htmlspecialchars($category['name'])) ?>.</p>

        <div class="latest-grid">
            <?php if (empty($articles)): ?>
                <p>No articles found in this category.</p>
            <?php else: ?>
                <?php foreach ($articles as $art): ?>
                    <div class="news-card">
                        <?php $imagePath = !empty($art['image']) ? $art['image'] : 'https://picsum.photos/800/600?random=' . $art['id']; ?>
                        <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($art['title']) ?>" onerror="this.src='https://picsum.photos/800/600?random=<?= $art['id'] ?>&blur=1'">
                        <div class="news-card-content">
                            <h3><?= htmlspecialchars($art['title']) ?></h3>
                            <p style="color: var(--text-muted); font-size: 0.9rem; margin: 10px 0;">
                                <?= substr(htmlspecialchars($art['content']), 0, 150) ?>...
                            </p>
                            <a href="article.php?id=<?= $art['id'] ?>" class="btn-neon" style="display: inline-block; margin-top: 10px;">Read More</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <footer style="padding: 50px 0; text-align: center; border-top: 1px solid rgba(255,255,255,0.05); margin-top: 100px;">
        <p>&copy; 2024 CNN CLONE. All Rights Reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
