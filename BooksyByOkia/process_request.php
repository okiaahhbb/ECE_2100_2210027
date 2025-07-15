<?php
session_start();
include '../db_connect.php';

// ✅ Admin check
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = intval($_POST['request_id']);
    $action = $_POST['action'];

    if ($request_id > 0 && ($action === 'approve' || $action === 'decline')) {
        $status = ($action === 'approve') ? 'approved' : 'declined';

        // update query
        $stmt = $conn->prepare("UPDATE borrow_requests SET status = ?, processed_at = NOW() WHERE request_id = ?");
        $stmt->bind_param("si", $status, $request_id);

        if ($stmt->execute()) {
            header("Location: BorrowRequest.php?msg=$status");
            exit();
        } else {
            header("Location: BorrowRequest.php?msg=fail");
            exit();
        }
    } else {
        header("Location: BorrowRequest.php?msg=invalid");
        exit();
    }
} else {
    header("Location: BorrowRequest.php");
    exit();
}

