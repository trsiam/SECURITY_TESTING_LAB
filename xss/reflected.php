<?php
// xss/reflected.php - Reflected XSS Vulnerability
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reflected XSS</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #1a1a2e; color: #fff; }
        .container { max-width: 800px; margin: auto; background: #16213e; padding: 30px; border-radius: 10px; }
        h1 { color: #e94560; }
        .vuln-badge { background: #e94560; color: #fff; padding: 5px 10px; border-radius: 5px; display: inline-block; font-size: 12px; }
        input { width: 60%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        button { background: #e94560; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .result { background: #0f3460; padding: 15px; border-radius: 5px; margin-top: 20px; }
        .back { display: block; margin-top: 20px; color: #4fc3f7; }
        .payload { background: #1a1a2e; padding: 10px; border-left: 3px solid #e94560; font-family: monospace; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔸 Reflected XSS</h1>
        <span class="vuln-badge">VULNERABLE</span>
        <p style="color: #aaa;">Try: <strong>&lt;script&gt;alert('XSS')&lt;/script&gt;</strong></p>

        <form method="GET">
            <input type="text" name="q" placeholder="Search..." required>
            <button type="submit">Search</button>
        </form>

        <?php if (isset($_GET['q'])): ?>
            <div class="result">
                <h3>🔍 Search Results for:</h3>
                <!-- 🔥 VULNERABLE - Direct output without sanitization -->
                <div class="payload">
                    <?php echo $_GET['q']; ?>
                </div>
            </div>
        <?php endif; ?>

        <a href="../index.php" class="back">⬅ Back to Home</a>
    </div>
</body>
</html>