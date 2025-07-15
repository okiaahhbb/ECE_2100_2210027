<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "booksy";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// Fetch current user
function getCurrentUser($conn) {
    if (!isset($_SESSION['student_id'])) {
        return null;
    }
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("i", $_SESSION['student_id']);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
    }
    return null;
}

// ✅ Login check here:
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}
