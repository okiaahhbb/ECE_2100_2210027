<?php
session_start();
include '../db_connect.php';


if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = intval($_POST['student_id'] ?? 0);
    $book_id = intval($_POST['book_id'] ?? 0);


    if ($student_id <= 0 || $book_id <= 0) {
        header("Location: civil.php?request=fail");
        exit();
    }

    
    $bookCheck = $conn->prepare("SELECT quantity, status FROM books WHERE book_id = ?");
    $bookCheck->bind_param("i", $book_id);
    $bookCheck->execute();
    $result = $bookCheck->get_result();
    if ($result->num_rows === 0) {
     
        header("Location: civil.php?request=fail");
        exit();
    }
    $book = $result->fetch_assoc();

    
    if ($book['quantity'] <= 0 || strtolower($book['status']) === 'borrowed') {
      
        header("Location: civil.php?request=unavailable");
        exit();
    }

    $stmtCheck = $conn->prepare("SELECT request_id FROM borrow_requests WHERE student_id = ? AND book_id = ? AND status = 'pending'");
    $stmtCheck->bind_param("ii", $student_id, $book_id);
    $stmtCheck->execute();
    $resCheck = $stmtCheck->get_result();
    if ($resCheck->num_rows > 0) {
       
        header("Location: civil.php?request=already");
        exit();
    }

    
    $stmt = $conn->prepare("INSERT INTO borrow_requests (student_id, book_id, status, requested_at) VALUES (?, ?, 'pending', NOW())");
    $stmt->bind_param("ii", $student_id, $book_id);

    if ($stmt->execute()) {
        
        header("Location: civil.php?request=success");
        exit();
    } else {
        
        header("Location: civil.php?request=fail");
        exit();
    }
} else {
    
    header("Location: dashboard.php");
    exit();
}

