<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'], $_POST['action'])) {
    $request_id = (int)$_POST['request_id'];
    $action = $_POST['action'];

    // Fetch request info
    $stmt = $conn->prepare("SELECT student_id, book_id, status FROM borrow_requests WHERE request_id = ?");
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) {
        header("Location: BorrowRequest.php?msg=error");
        exit();
    }
    $request = $res->fetch_assoc();
    $stmt->close();

    if ($request['status'] !== 'pending') {
        header("Location: BorrowRequest.php?msg=error");
        exit();
    }

    if ($action === 'approve') {
        $processed_at = date('Y-m-d H:i:s');
        $due_date = date('Y-m-d', strtotime('+14 days'));

        // Update borrow_requests
        $stmt = $conn->prepare("UPDATE borrow_requests SET status = 'approved', processed_at = ?, due_date = ? WHERE request_id = ?");
        $stmt->bind_param("ssi", $processed_at, $due_date, $request_id);
        $stmt->execute();
        $stmt->close();

        // Decrement quantity
        $stmt = $conn->prepare("UPDATE books SET quantity = quantity - 1 WHERE book_id = ?");
        $stmt->bind_param("i", $request['book_id']);
        $stmt->execute();
        $stmt->close();

        // Check if quantity zero to update book status
        $stmt = $conn->prepare("SELECT quantity FROM books WHERE book_id = ?");
        $stmt->bind_param("i", $request['book_id']);
        $stmt->execute();
        $res = $stmt->get_result();
        $book = $res->fetch_assoc();
        $stmt->close();

        if ($book['quantity'] <= 0) {
            $new_status = 'Borrowed';
            $stmt = $conn->prepare("UPDATE books SET status = ? WHERE book_id = ?");
            $stmt->bind_param("si", $new_status, $request['book_id']);
            $stmt->execute();
            $stmt->close();
        }

        header("Location: BorrowRequest.php?msg=approved");
        exit();
    }

    if ($action === 'decline') {
        $processed_at = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("UPDATE borrow_requests SET status = 'declined', processed_at = ? WHERE request_id = ?");
        $stmt->bind_param("si", $processed_at, $request_id);
        $stmt->execute();
        $stmt->close();

        header("Location: BorrowRequest.php?msg=declined");
        exit();
    }
}

header("Location: BorrowRequest.php?msg=error");
exit();



