<?php
session_start();
require_once 'db.php';

// Fetch Featured News
$stmt = $pdo->query("SELECT a.*, c.name as category_name FROM articles a JOIN categories c ON a.category_id = c.id WHERE a.is_featured = 1 ORDER BY a.created_at DESC LIMIT 3");
$featured = $stmt->fetchAll();

// Fetch Latest News
$stmt = $pdo->query("SELECT a.*, c.name as category_name FROM articles a JOIN categories c ON a.category_id = c.id ORDER BY a.created_at DESC");
$latest = $stmt->fetchAll();

// Fetch Ticker News (Latest 5)
$stmt = $pdo->query("SELECT title FROM articles ORDER BY created_at DESC LIMIT 5");
$ticker = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNN Clone | Neon News</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="ticker-wrapper">
        <div class="ticker">
            <?php foreach ($ticker as $t): ?>
                <span class="ticker-item">BREAKING: <?= htmlspecialchars($t['title']) ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <section class="hero">
        <div class="hero-content">
            <h1>Stay Illuminated.</h1>
            <p>The world's most trusted news, delivered with a neon pulse.</p>
        </div>
    </section>

    <main class="container">
        <h2 style="margin-bottom: 30px; border-left: 5px solid var(--neon-cyan); padding-left: 15px;">FEATURED STORIES</h2>
        <div class="featured-grid">
            <?php if (isset($featured[0])): ?>
            <a href="article.php?id=<?= $featured[0]['id'] ?>" class="featured-main news-card" style="text-decoration: none; color: inherit;">
                <?php $featuredImage = !empty($featured[0]['image']) ? $featured[0]['image'] : 'https://picsum.photos/1200/600?random=featured'; ?>
                <img src="<?= $featuredImage ?>" alt="<?= htmlspecialchars($featured[0]['title']) ?>" onerror="this.src='https://picsum.photos/1200/600?grayscale'">
                <div class="news-card-content" style="position: absolute; bottom: 0; background: linear-gradient(transparent, rgba(0,0,0,0.9)); width: 100%;">
                    <span class="category-tag"><?= $featured[0]['category_name'] ?></span>
                    <h3><?= htmlspecialchars($featured[0]['title']) ?></h3>
                </div>
            </a>
            <?php endif; ?>

            <div class="featured-sub">
                <?php for($i=1; $i<count($featured); $i++): ?>
                <a href="article.php?id=<?= $featured[$i]['id'] ?>" class="news-card" style="text-decoration: none; color: inherit; display: flex; height: 190px;">
                    <img src="<?= $featured[$i]['image'] ?>" style="width: 40%; height: 100%;" alt="">
                    <div class="news-card-content" style="width: 60%;">
                        <span class="category-tag"><?= $featured[$i]['category_name'] ?></span>
                        <h4 style="font-size: 1rem;"><?= htmlspecialchars($featured[$i]['title']) ?></h4>
                    </div>
                </a>
                <?php endfor; ?>
            </div>
        </div>

        <h2 style="margin: 50px 0 30px; border-left: 5px solid var(--neon-purple); padding-left: 15px;">EXPLORE CATEGORIES</h2>
        <div class="cat-grid">
            <?php foreach ($categories as $cat): ?>
                <a href="category.php?id=<?= $cat['id'] ?>" class="cat-card"><?= htmlspecialchars($cat['name']) ?></a>
            <?php endforeach; ?>
        </div>

        <h2 style="margin: 50px 0 30px; border-left: 5px solid var(--neon-pink); padding-left: 15px;">LATEST NEWS</h2>
        <div class="latest-grid">
            <?php foreach ($latest as $art): ?>
                <div class="news-card">
                    <?php $imagePath = !empty($art['image']) ? $art['image'] : 'https://picsum.photos/800/600?random=' . $art['id']; ?>
                    <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($art['title']) ?>" onerror="this.src='https://picsum.photos/800/600?random=<?= $art['id'] ?>&blur=2'">
                    <div class="news-card-content">
                        <span class="category-tag"><?= htmlspecialchars($art['category_name']) ?></span>
                        <h3><?= htmlspecialchars($art['title']) ?></h3>
                        <p style="color: var(--text-muted); font-size: 0.9rem; margin: 10px 0;">
                            <?= substr(htmlspecialchars($art['content']), 0, 100) ?>...
                        </p>
                        <a href="article.php?id=<?= $art['id'] ?>" class="btn-neon" style="display: inline-block; margin-top: 10px; font-size: 0.8rem;">Read More</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer style="padding: 50px 0; text-align: center; border-top: 1px solid rgba(255,255,255,0.05);">
        <p>&copy; 2024 CNN CLONE. All Rights Reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
