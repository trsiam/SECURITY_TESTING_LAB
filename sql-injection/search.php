<?php
// sql-injection/search.php - UNION-Based (MySQL)
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
    <title>Test 2: UNION-Based</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f7fb; }
        .container { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
        input { width: 60%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        button { background: #0d47a1; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .back { margin-top: 20px; display: block; }
        .vuln-badge { background: #d32f2f; color: white; padding: 5px 10px; border-radius: 5px; display: inline-block; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #0d47a1; color: white; }
        .query-box { background: #f5f5f5; padding: 10px; border-radius: 5px; font-family: monospace; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Search Products</h1>
        <span class="vuln-badge">VULNERABLE: UNION-Based</span>
        <p style="color: #666; font-size: 14px;">
            Try: <strong>' UNION SELECT username, password, email, full_name FROM users --</strong>
        </p>

        <form method="GET">
            <input type="text" name="q" placeholder="Search for products..." required>
            <button type="submit">Search</button>
        </form>

        <?php
        if (isset($_GET['q'])) {
            $search = $_GET['q'];

            $query = "SELECT name, description, price, category FROM products WHERE name LIKE '%$search%'";
            echo '<div class="query-box">📝 Query: ' . htmlspecialchars($query) . '</div>';

            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                echo '<table>';
                echo '<tr><th>Name</th><th>Description</th><th>Price</th><th>Category</th></tr>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                    echo '<td>$' . htmlspecialchars($row['price']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['category']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p style="color: #999;">No products found.</p>';
            }
        }
        ?>

        <a href="../index.php" class="back">⬅ Back to Home</a>
    </div>
</body>
</html>