<?php
// sql-injection/login.php - Auth Bypass (MySQL)
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../config/database.php';

if (!isset($conn) || !$conn) {
    die('Database connection failed.');
}

session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 🔥 VULNERABLE CODE - Direct concatenation
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    
    echo '<div style="background: #f5f5f5; padding: 10px; font-family: monospace; margin: 10px 0;">📝 Query: ' . htmlspecialchars($query) . '</div>';
    
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user'] = $user['username'];
        $_SESSION['is_admin'] = $user['is_admin'];
        $message = "✅ LOGIN SUCCESSFUL! Welcome " . $user['full_name'];
    } else {
        $message = "❌ Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test 1: Auth Bypass</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f7fb; }
        .container { max-width: 400px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
        input { width: 100%; padding: 10px; margin: 5px 0 15px; border: 1px solid #ccc; border-radius: 5px; }
        button { background: #0d47a1; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .back { margin-top: 20px; display: block; }
        .vuln-badge { background: #d32f2f; color: white; padding: 5px 10px; border-radius: 5px; display: inline-block; }
        .message { padding: 10px; border-radius: 5px; margin: 10px 0; }
        .success { background: #c8e6c9; color: #2e7d32; }
        .error { background: #ffcdd2; color: #c62828; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Login Page</h1>
        <span class="vuln-badge">VULNERABLE: Auth Bypass</span>
        <p style="color: #666; font-size: 14px;">Try: <strong>admin'--</strong> (any password)</p>

        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'SUCCESSFUL') ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" placeholder="Enter username" required>

            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter password" required>
            
            <button type="submit">Login</button>
        </form>

        <a href="../index.php" class="back">⬅ Back to Home</a>
    </div>
</body>
</html>