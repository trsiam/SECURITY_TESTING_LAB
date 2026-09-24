<?php

// config/database.php - Aiven MySQL

$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: 24369;
$username = getenv('DB_USER') ?: 'avnadmin';
$password = getenv('DB_PASS');
$database = getenv('DB_NAME') ?: 'defaultdb';

// Aiven CA certificate
$ca_cert = __DIR__ . '/ca.pem';

$conn = mysqli_init();

mysqli_ssl_set(
    $conn,
    NULL,
    NULL,
    $ca_cert,
    NULL,
    NULL
);

mysqli_real_connect(
    $conn,
    $host,
    $username,
    $password,
    $database,
    $port,
    NULL,
    MYSQLI_CLIENT_SSL
);

if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

?>