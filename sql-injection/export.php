<?php
// sql-injection/export.php - Stacked Queries Vulnerability
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/../config/database.php';

if (!isset($conn) || !$conn) {
    die('Database connection is not available.');
}

$message = '';
$data = [];
$query = '';

if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // 🔥 VULNERABLE CODE - Direct concatenation
    $query = "SELECT * FROM products WHERE id=$file";
    
    echo '<div style="background: #f1f5f9; padding: 12px 16px; border-radius: 8px; font-family: monospace; margin: 16px 0; border-left: 4px solid #ef4444; font-size: 0.9rem;">📝 Query: ' . htmlspecialchars($query) . '</div>';

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
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Test 7: Stacked Queries</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fb;
            color: #1e293b;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }
        .container {
            max-width: 820px;
            width: 100%;
            background: #ffffff;
            padding: 40px 44px;
            border-radius: 28px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.05);
        }
        h1 { font-size: 1.8rem; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
        .vuln-badge {
            display: inline-block;
            background: #ef4444;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 4px 14px;
            border-radius: 100px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin: 6px 0 12px 0;
        }
        .desc {
            color: #475569;
            font-size: 0.9rem;
            margin-bottom: 6px;
        }
        .danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 14px 18px;
            border-radius: 14px;
            font-weight: 500;
            margin: 16px 0 20px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .danger i { font-size: 1.2rem; color: #dc2626; }
        .back {
            display: inline-block;
            margin-top: 24px;
            color: #4f46e5;
            font-weight: 500;
            text-decoration: none;
        }
        .back:hover { text-decoration: underline; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
            font-size: 0.9rem;
        }
        th {
            background: #f1f5f9;
            text-align: left;
            padding: 10px 14px;
            font-weight: 600;
            color: #0f172a;
        }
        td {
            padding: 10px 14px;
            border-bottom: 1px solid #e9edf2;
        }
        .message {
            padding: 12px 16px;
            border-radius: 10px;
            margin: 12px 0;
            font-weight: 500;
        }
        .error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .deleted-box {
            background: #fef2f2;
            border: 2px solid #dc2626;
            color: #991b1b;
            padding: 20px;
            border-radius: 16px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: 600;
            margin: 20px 0;
        }
        .query-box {
            background: #f1f5f9;
            padding: 12px 16px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 0.85rem;
            border-left: 4px solid #ef4444;
            margin: 12px 0 16px 0;
            word-break: break-all;
        }
        .no-data {
            color: #94a3b8;
            margin-top: 12px;
        }
        .footer-note {
            margin-top: 24px;
            color: #94a3b8;
            font-size: 0.85rem;
            border-top: 1px solid #e9edf2;
            padding-top: 20px;
        }
        .inline-code {
            background: #f1f5f9;
            padding: 2px 10px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 0.85rem;
            color: #0f172a;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>📄 Export Data</h1>
    <div class="vuln-badge">VULNERABLE: Stacked Queries</div>
    <p class="desc">Try: <span class="inline-code">file=1; DROP TABLE users --</span></p>

    <div class="danger">
        <span>⚠️ <strong>DANGER:</strong> Stacked queries allow multiple SQL statements. This can <strong>DROP TABLES</strong> or modify the database!</span>
    </div>

    <?php if ($message): ?>
        <div class="message error"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['file'])): ?>
        <div class="query-box">📝 Query: <?php echo htmlspecialchars($query); ?></div>

        <?php
        // Check if users table still exists
        $table_check = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
        if (mysqli_num_rows($table_check) == 0): ?>
            <div class="deleted-box">
                🗑️ <strong>THE USERS TABLE HAS BEEN DELETED!</strong><br>
                <span style="font-size: 0.9rem; font-weight: 400;">Try going to the login page to see the error.</span>
            </div>
        <?php endif; ?>

        <?php if (!empty($data)): ?>
            <table>
                <thead>
                    <tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td>$<?php echo htmlspecialchars($row['price']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">No data found.</p>
        <?php endif; ?>
    <?php else: ?>
        <p style="color: #64748b; margin-top: 12px;">Enter a file ID in the URL: <span class="inline-code">?file=1</span></p>
    <?php endif; ?>

    <a href="../index.php" class="back">⬅ Back to Home</a>
    <div class="footer-note">🔐 Educational use only — all vulnerabilities are intentional.</div>
</div>
</body>
</html>