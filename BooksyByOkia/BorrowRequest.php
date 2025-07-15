<?php
session_start();
include '../db_connect.php';


if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}


$sql = "
    SELECT br.request_id, br.student_id, br.book_id, br.status, br.requested_at, 
           b.book_name, b.author_name, b.edition, b.book_pic
    FROM borrow_requests br
    JOIN books b ON br.book_id = b.book_id
    WHERE br.status = 'pending'
    ORDER BY br.requested_at DESC
";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Borrow Requests</title>
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        background: #f4f6f9;
    }
    .navbar {
        background: #2a5934;
        color: #fff;
        padding: 15px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    .navbar a {
        color: #fff;
        text-decoration: none;
        margin-left: 15px;
        font-weight: bold;
    }
    h1 {
        text-align: center;
        margin: 30px 0;
        color: #2a5934;
    }
    .request-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        padding: 20px;
    }
    .request-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        padding: 15px;
        text-align: center;
        transition: transform 0.3s;
    }
    .request-card:hover {
        transform: scale(1.03);
    }
    .request-card img {
        width: 100%;
        height: 180px;
        object-fit: contain;
        border-radius: 8px;
        background: #f3f3f3;
        margin-bottom: 10px;
    }
    .book-info {
        font-size: 14px;
        margin-bottom: 10px;
    }
    .actions {
        display: flex;
        justify-content: center;
        gap: 10px;
    }
    .approve-btn, .decline-btn {
        padding: 6px 10px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
    }
    .approve-btn {
        background: #28a745;
        color: #fff;
    }
    .approve-btn:hover {
        background: #218838;
    }
    .decline-btn {
        background: #dc3545;
        color: #fff;
    }
    .decline-btn:hover {
        background: #c82333;
    }
</style>
</head>
<body>

<div class="navbar">
    <div>📚 Borrow Requests</div>
    <div>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<h1>Pending Borrow Requests</h1>

<div class="request-grid">
<?php while($row = mysqli_fetch_assoc($result)) { ?>
    <div class="request-card">
        <img src="Images/<?php echo htmlspecialchars($row['book_pic']); ?>"
             alt="Book"
             onerror="this.onerror=null;this.src='Images/default.jpg';">
        <div class="book-info">
            <strong><?php echo htmlspecialchars($row['book_name']); ?></strong><br>
            Author: <?php echo htmlspecialchars($row['author_name']); ?><br>
            Edition: <?php echo htmlspecialchars($row['edition']); ?><br>
            Student ID: <?php echo htmlspecialchars($row['student_id']); ?><br>
            Request ID: <?php echo htmlspecialchars($row['request_id']); ?><br>
            Date: <?php echo htmlspecialchars($row['requested_at']); ?>
        </div>
        <div class="actions">
            <form action="process_request.php" method="POST" style="display:inline;">
                <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                <input type="hidden" name="action" value="approve">
                <button type="submit" class="approve-btn">Approve</button>
            </form>
            <form action="process_request.php" method="POST" style="display:inline;">
                <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                <input type="hidden" name="action" value="decline">
                <button type="submit" class="decline-btn">Decline</button>
            </form>
        </div>
    </div>
<?php } ?>
</div>

</body>
</html>


