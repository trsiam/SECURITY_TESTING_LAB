<?php
// sql-injection/user.php - Boolean Blind (MySQL)
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../config/database.php';

if (!isset($conn) || !$conn) {
    die('Database connection failed.');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test 4: Boolean Blind</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f7fb; }
        .container { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
        .back { margin-top: 20px; display: block; }
        .vuln-badge { background: #d32f2f; color: white; padding: 5px 10px; border-radius: 5px; display: inline-block; }
        .found { background: #c8e6c9; padding: 15px; border-left: 5px solid #2e7d32; color: #2e7d32; }
        .not-found { background: #ffcdd2; padding: 15px; border-left: 5px solid #c62828; color: #c62828; }
        .query-box { background: #f5f5f5; padding: 10px; border-radius: 5px; font-family: monospace; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>👤 User Lookup</h1>
        <span class="vuln-badge">VULNERABLE: Boolean Blind</span>
        <p style="color: #666; font-size: 14px;">
            Try: <strong>id=1' AND SUBSTRING(password,1,1)='a' --</strong>
        </p>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $query = "SELECT * FROM users WHERE id=$id";
            echo '<div class="query-box">📝 Query: ' . htmlspecialchars($query) . '</div>';

            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                echo '<div class="found">✅ User found: ' . htmlspecialchars($user['username']) . '</div>';
            } else {
                echo '<div class="not-found">❌ User not found.</div>';
            }
        } else {
            echo '<p style="color: #999;">Enter a user ID in the URL: <strong>?id=1</strong></p>';
        }
        ?>

        <a href="../index.php" class="back">⬅ Back to Home</a>
    </div>
</body>
</html>