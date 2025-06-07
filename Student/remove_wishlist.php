<?php
session_start();
include('connection.php');

if(!isset($_SESSION['username'])) {
    die(json_encode(['success' => false, 'message' => 'Not logged in']));
}

$book_id = $_POST['book_id'];
$username = $_SESSION['username'];

$db->query("DELETE FROM wishlist WHERE student_username='$username' AND book_id=$book_id");
echo json_encode(['success' => true, 'message' => 'Removed from wishlist']);
?>