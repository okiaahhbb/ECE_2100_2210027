<?php
session_start();

// Make sure user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'booksy');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user's department
$stmt = $conn->prepare("SELECT department FROM students WHERE student_id = ?");
$stmt->bind_param("i", $_SESSION['student_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    $dept = strtoupper($user['department']); // ECE / CIVIL / ME
    if ($dept == 'ECE') {
        header("Location: ECE.php");
        exit();
    } elseif ($dept == 'CIVIL') {
        header("Location: CIVIL.php");
        exit();
    } elseif ($dept == 'ME' || $dept == 'MECHANICAL') {
        header("Location: ME.php");
        exit();
    } else {
        // fallback page if department is unknown
        header("Location: index.php");
        exit();
    }
} else {
    // if no user found, force login
    header("Location: login.php");
    exit();
}
?>
