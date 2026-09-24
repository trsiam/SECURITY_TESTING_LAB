<?php
// pages/register.php - Second-Order Vulnerability
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../config/database.php';

if (!isset($conn) || !$conn) {
    die('Database connection is not available.');
}

session_start();

$message = '';
$users = [];
$show_users = isset($_GET['view_all']);

// Handle registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 🔥 VULNERABLE CODE - Direct concatenation
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    
    // Debug: Show the query
    echo '<div style="background: #f5f5f5; padding: 10px; font-family: monospace; margin: 10px 0; border-left: 4px solid #d32f2f;">📝 Query: ' . htmlspecialchars($query) . '</div>';
    
    if (mysqli_multi_query($conn, $query)) {
        $message = "✅ Registration successful! <a href='login.php'>Login here</a>";
    } else {
        $message = "❌ Registration failed: " . mysqli_error($conn);
    }
}

// Handle view all users (Second-Order trigger)
if ($show_users) {
    // 🔥 VULNERABLE CODE - Direct concatenation
    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Test 6: Second-Order</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f4f4f4; }
        .container { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
        input { width: 100%; padding: 10px; margin: 5px 0 15px; border: 1px solid #ccc; border-radius: 5px; }
        button { background: #0d47a1; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .back { margin-top: 20px; display: block; }
        .vuln-badge { background: #d32f2f; color: white; padding: 5px 10px; border-radius: 5px; display: inline-block; }
        .message { padding: 10px; border-radius: 5px; margin: 10px 0; }
        .success { background: #c8e6c9; color: #2e7d32; }
        .error { background: #ffcdd2; color: #c62828; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #0d47a1; color: white; }
        .trigger-box { background: #fff3cd; padding: 15px; border-left: 5px solid #ff9800; margin: 20px 0; }
        .warning { background: #ffcdd2; padding: 15px; border-left: 5px solid #c62828; color: #c62828; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📝 Register Page</h1>
        <span class="vuln-badge">VULNERABLE: Second-Order</span>
        
        <div class="warning">
            <strong>🔴 SECOND-ORDER INJECTION:</strong><br>
            The payload is <strong>stored</strong> in the database during registration,<br>
            then <strong>triggered</strong> when viewing all users!
        </div>

        <p style="color: #666; font-size: 14px;">
            <strong>Step 1:</strong> Register with username: <strong>test' OR '1'='1</strong><br>
            <strong>Step 2:</strong> Click "View All Users" below → Payload triggers!
        </p>

        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'successful') ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" placeholder="Choose a username" required>

            <label>Email:</label>
            <input type="email" name="email" placeholder="Enter email" required>

            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter password" required>

            <button type="submit">Register</button>
        </form>

        <hr>

        <div class="trigger-box">
            <strong>⚠️ SECOND-ORDER TRIGGER:</strong><br>
            Click below to view all users — this will execute any stored payloads from registration.
        </div>

        <a href="?view_all=1" style="display: inline-block; background: #ff9800; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            👥 View All Users (Trigger Payload)
        </a>

        <?php if ($show_users && !empty($users)): ?>
            <h3>User List:</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Admin</th>
                </tr>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo $user['is_admin'] ? '✅' : '❌'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <a href="../index.php" class="back">⬅ Back to Home</a>
    </div>
</body>
</html>