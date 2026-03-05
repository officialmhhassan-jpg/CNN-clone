<?php
session_start();
require_once 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];

// Fetch Article Details
$stmt = $pdo->prepare("SELECT a.*, c.name as category_name FROM articles a JOIN categories c ON a.category_id = c.id WHERE a.id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    header("Location: index.php");
    exit;
}

// Fetch Related Articles (Same category, excluding current)
$stmt = $pdo->prepare("SELECT * FROM articles WHERE category_id = ? AND id != ? LIMIT 3");
$stmt->execute([$article['category_id'], $id]);
$related = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title']) ?> | CNN Clone</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>

    <?php include 'header.php'; ?>

    <article class="container">
        <div class="article-header text-center" style="text-align: center;">
            <span class="category-tag" style="font-size: 1.2rem; letter-spacing: 3px;"><?= $article['category_name'] ?></span>
            <h1 style="font-size: 3.5rem; margin: 20px 0; line-height: 1.2;"><?= htmlspecialchars($article['title']) ?></h1>
            <p style="color: var(--text-muted);"><?= date('F j, Y', strtotime($article['created_at'])) ?> | Published by Editorial Team</p>
            <img src="<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>">
        </div>

        <div class="article-body">
            <?= nl2br(htmlspecialchars($article['content'])) ?>
            
            <div style="margin-top: 50px; padding: 30px; background: var(--card-bg); border-radius: 15px; border-left: 5px solid var(--neon-cyan);">
                <h4 style="color: var(--neon-cyan);">Share this story</h4>
                <div style="margin-top: 15px;">
                    <button class="btn-neon" onclick="alert('Shared to Twitter!')">Twitter</button>
                    <button class="btn-neon" onclick="alert('Shared to Facebook!')">Facebook</button>
                </div>
            </div>
        </div>

        <section style="margin-top: 100px;">
            <h2 style="margin-bottom: 30px; border-left: 5px solid var(--neon-pink); padding-left: 15px;">RELATED ARTICLES</h2>
            <div class="latest-grid">
                <?php foreach ($related as $rel): ?>
                    <div class="news-card">
                        <?php $relImage = !empty($rel['image']) ? $rel['image'] : 'https://picsum.photos/800/600?random=' . $rel['id']; ?>
                        <img src="<?= $relImage ?>" alt="<?= htmlspecialchars($rel['title']) ?>" onerror="this.src='https://picsum.photos/800/600?random=<?= $rel['id'] ?>&sepia=1'">
                        <div class="news-card-content">
                            <h3><?= htmlspecialchars($rel['title']) ?></h3>
                            <a href="article.php?id=<?= $rel['id'] ?>" class="btn-neon" style="display: inline-block; margin-top: 10px;">Read More</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </article>

    <footer style="padding: 50px 0; text-align: center; border-top: 1px solid rgba(255,255,255,0.05); margin-top: 100px;">
        <p>&copy; 2024 CNN CLONE. All Rights Reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
