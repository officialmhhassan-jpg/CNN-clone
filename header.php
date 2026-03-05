<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';
// Fetch Categories (Grouped by name to avoid duplicates)
$categories = $pdo->query("SELECT MIN(id) as id, name FROM categories GROUP BY name")->fetchAll();
?>
<header class="navbar">
    <div class="container nav-content">
        <a href="index.php" class="logo">CNN CLONE</a>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <?php foreach ($categories as $cat): ?>
                <?php 
                    $isActive = (isset($cat_id) && $cat_id == $cat['id']) || (isset($article['category_id']) && $article['category_id'] == $cat['id']);
                ?>
                <a href="category.php?id=<?= $cat['id'] ?>" class="<?= $isActive ? 'active' : '' ?>" style="<?= $isActive ? 'color: var(--neon-cyan);' : '' ?>">
                    <?= htmlspecialchars($cat['name']) ?>
                </a>
            <?php endforeach; ?>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <span style="color: var(--neon-pink); margin-left: 20px;">@<?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="logout.php" class="btn-neon">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="signup.php" class="btn-neon">Sign Up</a>
            <?php endif; ?>
        </div>
    </div>
</header>
