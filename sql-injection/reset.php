<?php
// sql-injection/reset.php - Time-Based Blind (MySQL)
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
    <title>Test 5: Time-Based Blind</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f7fb; }
        .container { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
        .back { margin-top: 20px; display: block; }
        .vuln-badge { background: #d32f2f; color: white; padding: 5px 10px; border-radius: 5px; display: inline-block; }
        .result { background: #e3f2fd; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .query-box { background: #f5f5f5; padding: 10px; border-radius: 5px; font-family: monospace; margin: 10px 0; }
        .time-info { background: #fff3cd; padding: 10px; border-left: 5px solid #ff9800; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>⏱️ Password Reset</h1>
        <span class="vuln-badge">VULNERABLE: Time-Based Blind</span>
        <p style="color: #666; font-size: 14px;">
            Try: <strong>token=1' AND IF(1=1, SLEEP(5), 0) --</strong>
        </p>

        <?php
        if (isset($_GET['token'])) {
            $token = $_GET['token'];

            $query = "SELECT * FROM users WHERE id=$token";
            echo '<div class="query-box">📝 Query: ' . htmlspecialchars($query) . '</div>';

            $start = microtime(true);
            $result = mysqli_query($conn, $query);
            $end = microtime(true);
            $time = round(($end - $start), 2);

            echo '<div class="time-info">⏱️ Response time: <strong>' . $time . ' seconds</strong></div>';

            if ($result && mysqli_num_rows($result) > 0) {
                echo '<div class="result">✅ Reset token valid for user: ' . htmlspecialchars(mysqli_fetch_assoc($result)['username']) . '</div>';
            } else {
                echo '<div class="result">❌ Invalid reset token.</div>';
            }
        } else {
            echo '<p style="color: #999;">Enter a token in the URL: <strong>?token=1</strong></p>';
        }
        ?>

        <a href="../index.php" class="back">⬅ Back to Home</a>
    </div>
</body>
</html>