<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'booksy');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Redirect if not logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

// Get current user
function getCurrentUser($conn) {
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("i", $_SESSION['student_id']);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    return null;
}

$user = getCurrentUser($conn);

// If user not found, destroy session and redirect
if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
