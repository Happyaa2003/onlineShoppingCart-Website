<?php
// Configuration for database connection
$serverName = "localhost"; // Server name
$dBUsername = "root";      // Database username
$dBPassword = "";          // Database password
$dBName = "db_ecommerce";  // Database name

// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create a new MySQLi connection
    $conn = new mysqli($serverName, $dBUsername, $dBPassword, $dBName);

    // Set the charset to utf8mb4 (optional but recommended)
    $conn->set_charset("utf8mb4");

    // Check if the connection was successful
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Optional: Display a success message (for debugging purposes)
    // echo "Connected successfully!";
} catch (Exception $e) {
    // Handle connection errors
    die("Database connection error: " . $e->getMessage());
}
?>