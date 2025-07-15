<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "booksy";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optionally you can set UTF-8 charset
$conn->set_charset("utf8mb4");

// --- Helper function (optional) to check login quickly ---
function requireLoginStudent() {
    if (!isset($_SESSION['student_id'])) {
        header("Location: login.php");
        exit();
    }
}
?>
