<?php

$host = 'localhost';
$port = 3306;
$username = 'root';
$password = 'password';
$database = 'sqli_lab';

// Connect to MySQL server first
$conn = mysqli_connect(
    $host,
    $username,
    $password,
    null,
    $port
);

if (!$conn) {
    die("MySQL connection failed: " . mysqli_connect_error());
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS `$database`";

if (!mysqli_query($conn, $sql)) {
    die("Database creation failed: " . mysqli_error($conn));
}

// Select the database
mysqli_select_db($conn, $database);

mysqli_set_charset($conn, "utf8mb4");

// Automatically create tables and insert sample data
$sql = file_get_contents(__DIR__ . '/../db.sql');

if (!mysqli_multi_query($conn, $sql)) {
    die("Database setup failed: " . mysqli_error($conn));
}

// Clear all remaining query results
while (mysqli_more_results($conn)) {
    mysqli_next_result($conn);
}

?>

