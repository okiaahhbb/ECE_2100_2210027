<?php
session_start();
include('connection.php');

if(!isset($_SESSION['username'])) {
    die(json_encode(['success' => false, 'message' => 'Not logged in']));
}

$book_id = $_POST['book_id'];
$username = $_SESSION['username'];

// Check if already in wishlist
$check = $db->query("SELECT * FROM wishlist WHERE student_username='$username' AND book_id=$book_id");

if($check->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Book already in wishlist']);
} else {
    $db->query("INSERT INTO wishlist (student_username, book_id) VALUES ('$username', $book_id)");
    echo json_encode(['success' => true, 'message' => 'Added to wishlist']);
}
?>