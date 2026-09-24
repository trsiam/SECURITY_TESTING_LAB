<?php
// sql-injection/export.php - Stacked Queries (MySQL)
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../config/database.php';

if (!isset($conn) || !$conn) {
    die('Database connection failed.');
}

$message = '';
$data = [];
$query = '';

if (isset($_GET['file'])) {
    $file = $_GET['file'];

    $query = "SELECT * FROM products WHERE id=$file";
    
    echo '<div style="background: #f5f5f5; padding: 10px; font-family: monospace; margin: 10px 0;">📝 Query: ' . htmlspecialchars($query) . '</div>';

    if (mysqli_multi_query($conn, $query)) {
        do {
            if ($result = mysqli_store_result($conn)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
                mysqli_free_result($result);
            }
        } while (mysqli_next_result($conn));
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test 7: Stacked Queries</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f7fb; }
        .container { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
        .back { display: block; margin-top: 20px; color: #4f46e5; }
        .vuln-badge { background: #d32f2f; color: white; padding: 5px 10px; border-radius: 5px; display: inline-block; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #0d47a1; color: white; }
        .message { padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { background: #ffcdd2; color: #c62828; }
        .danger { background: #fff3cd; padding: 15px; border-left: 5px solid #ff9800; margin: 20px 0; }
        .query-box { background: #f5f5f5; padding: 10px; border-radius: 5px; font-family: monospace; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📄 Export Data</h1>
        <span class="vuln-badge">VULNERABLE: Stacked Queries</span>
        <p style="color: #666; font-size: 14px;">
            Try: <strong>file=1; DROP TABLE users --</strong>
        </p>

        <div class="danger">
            <strong>⚠️ DANGER:</strong> Stacked queries allow multiple SQL statements. 
            This can <strong>DROP TABLES</strong> or modify the database!
        </div>

        <?php if ($message): ?>
            <div class="message error"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php
        if (isset($_GET['file'])) {
            echo '<div class="query-box">📝 Query: ' . htmlspecialchars($query) . '</div>';

            if (!empty($data)) {
                echo '<h3>Product Data:</h3>';
                echo '<table>';
                echo '<tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th></tr>';
                foreach ($data as $row) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                    echo '<td>$' . htmlspecialchars($row['price']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p style="color: #999;">No data found.</p>';
            }
        } else {
            echo '<p style="color: #999;">Enter a file ID in the URL: <strong>?file=1</strong></p>';
        }
        ?>

        <a href="../index.php" class="back">⬅ Back to Home</a>
    </div>
</body>
</html>