<?php
// check_error_log.php
echo "<h2>PHP Error Log Information</h2>";

// Cek lokasi error log
$error_log = ini_get('error_log');
echo "<p><strong>Error Log Location:</strong> " . ($error_log ?: 'Not set') . "</p>";

// Cek apakah error logging aktif
$log_errors = ini_get('log_errors');
echo "<p><strong>Log Errors:</strong> " . ($log_errors ? 'ON' : 'OFF') . "</p>";

// Cek level error reporting
$error_reporting = ini_get('error_reporting');
echo "<p><strong>Error Reporting Level:</strong> " . $error_reporting . "</p>";

// Cek display errors
$display_errors = ini_get('display_errors');
echo "<p><strong>Display Errors:</strong> " . ($display_errors ? 'ON' : 'OFF') . "</p>";

// Test: generate error untuk testing
echo "<h3>Testing Error Log</h3>";
error_log("=== TEST ERROR LOG - " . date('Y-m-d H:i:s') . " ===");

// Coba akses file yang tidak ada (akan generate error)
if (!file_exists('nonexistent_file.php')) {
    error_log("Test: File tidak ditemukan - nonexistent_file.php");
}

echo "<p>Test error telah dikirim ke log file.</p>";

// Coba baca error log jika bisa
if ($error_log && file_exists($error_log)) {
    echo "<h3>Last 10 lines from error log:</h3>";
    echo "<pre>";
    $lines = shell_exec('tail -n 10 "' . $error_log . '" 2>&1');
    echo htmlspecialchars($lines ?: 'Cannot read error log');
    echo "</pre>";
} else {
    echo "<p>Cannot access error log file.</p>";
}
?>