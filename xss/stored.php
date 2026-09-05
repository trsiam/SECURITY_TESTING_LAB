<?php
// xss/stored.php - Stored XSS Vulnerability
session_start();

// Fake "database" (stored in session for demo)
if (!isset($_SESSION['comments'])) {
    $_SESSION['comments'] = [];
}

// Add comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    // 🔥 VULNERABLE - Stores raw input without sanitization
    $_SESSION['comments'][] = $_POST['comment'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stored XSS</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #1a1a2e; color: #fff; }
        .container { max-width: 800px; margin: auto; background: #16213e; padding: 30px; border-radius: 10px; }
        h1 { color: #e94560; }
        .vuln-badge { background: #e94560; color: #fff; padding: 5px 10px; border-radius: 5px; display: inline-block; font-size: 12px; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin: 5px 0; }
        button { background: #e94560; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .comment { background: #0f3460; padding: 10px; border-radius: 5px; margin: 10px 0; border-left: 3px solid #e94560; }
        .back { display: block; margin-top: 20px; color: #4fc3f7; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔸 Stored XSS</h1>
        <span class="vuln-badge">VULNERABLE</span>
        <p style="color: #aaa;">Try: <strong>&lt;script&gt;alert('XSS')&lt;/script&gt;</strong></p>

        <form method="POST">
            <textarea name="comment" placeholder="Write a comment..." rows="3" required></textarea>
            <button type="submit">Post Comment</button>
        </form>

        <h3>📝 Comments:</h3>

        <?php if (!empty($_SESSION['comments'])): ?>
            <?php foreach ($_SESSION['comments'] as $comment): ?>
                <div class="comment">
                    <!-- 🔥 VULNERABLE - Direct output without sanitization -->
                    <?php echo $comment; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: #666;">No comments yet.</p>
        <?php endif; ?>

        <a href="../index.php" class="back">⬅ Back to Home</a>
    </div>
</body>
</html>