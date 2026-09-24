<?php
// cookie_demo.php - Set random cookies for testing

// Generate random values
$session_id = bin2hex(random_bytes(16)); // 32 character random hex
$username = ['admin', 'john', 'jane', 'test', 'alice', 'bob'][rand(0, 5)];
$roles = ['administrator', 'moderator', 'editor', 'viewer', 'guest'];
$role = $roles[array_rand($roles)];

// Set cookies with random values
setcookie('session_id', $session_id, time() + 3600);
setcookie('username', $username, time() + 3600);
setcookie('role', $role, time() + 3600);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cookie Demo</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f7fb; }
        .container { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
        h1 { color: #0d47a1; }
        .cookie-box { background: #f5f5f5; padding: 15px; border-radius: 5px; font-family: monospace; margin: 10px 0; }
        .btn { display: inline-block; background: #0d47a1; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🍪 Cookies Set!</h1>
        <p>Cookies have been set with random values.</p>

        <div class="cookie-box">
            <strong>Current Cookies:</strong><br>
            session_id = <?php echo $session_id; ?><br>
            username = <?php echo $username; ?><br>
            role = <?php echo $role; ?>
        </div>

        <p><a href="xss/reflected.php" class="btn">Go to XSS Test</a></p>
        <p><a href="cookie_demo.php" class="btn" style="background: #28a745;">Refresh Cookies</a></p>
    </div>
</body>
</html>