<?php
// pages/product.php - Error-Based Vulnerability
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';

if (!isset($conn) || !$conn) {
    die('Database connection is not available.');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Test 3: Error-Based</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f4f4f4; }
        .container { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
        .back { margin-top: 20px; display: block; }
        .vuln-badge { background: #d32f2f; color: white; padding: 5px 10px; border-radius: 5px; display: inline-block; }
        .product { background: #e3f2fd; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error-box { background: #ffcdd2; padding: 15px; border-left: 5px solid #c62828; color: #c62828; font-family: monospace; white-space: pre-wrap; }
        .query-box { background: #f5f5f5; padding: 10px; border-radius: 5px; font-family: monospace; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📦 Product Details</h1>
        <span class="vuln-badge">VULNERABLE: Error-Based</span>
        <p style="color: #666; font-size: 14px;">
            Try: <strong>id=1' AND 1=CONVERT(int, @@version) -- </strong>
        </p>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // 🔥 VULNERABLE CODE - Direct concatenation + error display
            $query = "SELECT * FROM products WHERE id=$id";
            echo '<div class="query-box">📝 Query: ' . htmlspecialchars($query) . '</div>';

            $result = mysqli_query($conn, $query);

            if ($result) {
                $product = mysqli_fetch_assoc($result);
                if ($product) {
                    echo '<div class="product">';
                    echo '<h2>' . htmlspecialchars($product['name']) . '</h2>';
                    echo '<p>' . htmlspecialchars($product['description']) . '</p>';
                    echo '<p><strong>Price:</strong> $' . htmlspecialchars($product['price']) . '</p>';
                    echo '<p><strong>Category:</strong> ' . htmlspecialchars($product['category']) . '</p>';
                    echo '</div>';
                } else {
                    echo '<p style="color: #999;">Product not found.</p>';
                }
            } else {
                // 🔥 VULNERABLE - Shows full error to user
                echo '<div class="error-box">';
                echo '<strong>❌ Database Error:</strong><br>';
                echo mysqli_error($conn);
                echo '</div>';
            }
        } else {
            echo '<p style="color: #999;">Enter a product ID in the URL: <strong>?id=1</strong></p>';
        }
        ?>

        <a href="../index.php" class="back">⬅ Back to Home</a>
    </div>
</body>
</html>