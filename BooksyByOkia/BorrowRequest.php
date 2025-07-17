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
<meta charset="UTF-8" />
<title>Borrow Requests - Admin</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
        grid-template-columns: repeat(auto-fill,minmax(220px,1fr));
        gap: 20px;
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto 50px;
    }
    .request-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        padding: 15px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.3s ease;
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
        margin-bottom: 12px;
    }
    .book-info {
        font-size: 14px;
        margin-bottom: 12px;
        color: #333;
    }
    .actions {
        display: flex;
        justify-content: center;
        gap: 12px;
    }
    .approve-btn, .decline-btn {
        padding: 8px 14px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        font-size: 14px;
        flex: 1;
        transition: background-color 0.3s ease;
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

    /* Success popup */
    .success-popup {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #27ae60;
        color: #fff;
        padding: 15px 25px;
        border-radius: 12px;
        font-size: 16px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        z-index: 9999;
        animation: fadeOut 3s ease-in-out forwards;
    }
    @keyframes fadeOut {
        0% {opacity: 1;}
        80% {opacity: 1;}
        100% {opacity: 0; display: none;}
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
            Requested at: <?php echo htmlspecialchars($row['requested_at']); ?>
        </div>
        <div class="actions">
            <form action="process_request.php" method="POST" style="margin:0; flex:1;">
                <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                <input type="hidden" name="action" value="approve">
                <button type="submit" class="approve-btn">Approve</button>
            </form>
            <form action="process_request.php" method="POST" style="margin:0; flex:1;">
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




