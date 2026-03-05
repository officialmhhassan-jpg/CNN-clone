<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CNN Clone</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="auth-wrapper">
    
    <div class="auth-card">
        <a href="index.php" class="logo" style="display: block; text-align: center; margin-bottom: 20px;">CNN CLONE</a>
        <h2>Welcome Back</h2>
        
        <?php if($error): ?>
            <div style="background: rgba(255,0,0,0.1); color: #ff5f5f; padding: 10px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #ff5f5f;"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-neon" style="width: 100%; margin-top: 10px;">LOGIN</button>
        </form>
        <p style="text-align: center; margin-top: 20px; color: var(--text-muted);">
            Don't have an account? <a href="signup.php" style="color: var(--neon-pink);">Sign Up</a>
        </p>
    </div>

    <script src="script.js"></script>
</body>
</html>
