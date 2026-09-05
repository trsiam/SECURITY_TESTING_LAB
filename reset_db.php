<?php
// reset_db.php - Reset Database
include 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the SQL file
    $sql = file_get_contents('db.sql');

    if (!isset($conn) || !$conn) {
        $message = "❌ Reset failed: Database connection is unavailable.";
    } else {
        // Execute multi-query
        if (mysqli_multi_query($conn, $sql)) {
            do {
                if ($result = mysqli_store_result($conn)) {
                    mysqli_free_result($result);
                }
            } while (mysqli_next_result($conn));
            $message = "✅ Database reset successfully!";
        } else {
            $message = "❌ Reset failed: " . mysqli_error($conn);
        }
    }

    // Redirect back to index with message
    header("Location: index.php?reset=" . urlencode($message));
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>