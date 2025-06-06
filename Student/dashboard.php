<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include('Header.php');
include('connection.php');

// Get student information
$username = $_SESSION['username'];
$query = "SELECT * FROM student WHERE id = $username";
$result = mysqli_query($db, $query);
$student = mysqli_fetch_assoc($result);

// Get currently borrowed books
$current_query = "SELECT b.*, bb.issue_date, bb.return_date 
                FROM books b
                JOIN borrowed_books bb ON b.Book_ID = bb.book_id
                WHERE bb.student_id = $student_id AND bb.returned = 0
                LIMIT 3";
$current_result = mysqli_query($db, $current_query);
$current_books = [];
if ($current_result) {
    while ($row = mysqli_fetch_assoc($current_result)) {
        $current_books[] = $row;
    }
}

// Get borrow history count
$history_query = "SELECT COUNT(*) as total FROM borrowed_books 
                 WHERE student_id = $student_id";
$history_result = mysqli_query($db, $history_query);
$history_count = mysqli_fetch_assoc($history_result)['total'];

// Sample announcements (replace with database query if needed)
$announcements = [
    "Library will be closed next Monday for maintenance",
    "New computer science books added this week",
    "Due date extended for all books until semester end"
];
?>

<style>
    body {
        background-color: #f5f9f5;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .dashboard-container {
        flex: 1;
        padding: 30px;
        max-width: 1200px;
        margin: 0 auto;
        width: 100%;
    }
    
    .welcome-banner {
        background-color: #05420f;
        color: white;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(5, 66, 15, 0.1);
    }
    
    .welcome-banner h1 {
        margin-bottom: 10px;
        font-size: 28px;
    }
    
    .quick-actions {
        display: flex;
        gap: 15px;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    
    .quick-action {
        background-color: white;
        color: #05420f;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        transition: all 0.3s;
        border: 1px solid #05420f;
        font-weight: 500;
    }
    
    .quick-action:hover {
        background-color: #05420f;
        color: white;
    }
    
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }
    
    .dashboard-card {
        background-color: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .card-header {
        color: #05420f;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e0e0e0;
        font-size: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .view-all {
        font-size: 14px;
        color: #05420f;
        text-decoration: none;
    }
    
    .book-list {
        margin-top: 15px;
    }
    
    .book-item {
        padding: 12px 0;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
    }
    
    .book-title {
        font-weight: 500;
    }
    
    .book-meta {
        color: #666;
        font-size: 14px;
    }
    
    .return-btn {
        color: #e74c3c;
        text-decoration: none;
        font-size: 14px;
    }
    
    .announcement-item {
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }
    
    .announcement-item:last-child {
        border-bottom: none;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .stat-card {
        background-color: #e9f5e9;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
    }
    
    .stat-number {
        font-size: 24px;
        font-weight: bold;
        color: #05420f;
    }
    
    .stat-label {
        font-size: 14px;
        color: #666;
    }
    
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 20px 15px;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .quick-actions {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>

<div class="dashboard-container">
    <div class="welcome-banner">
        <h1>Welcome, <?php echo htmlspecialchars($student['name']); ?></h1>
        <p>Student ID: <?php echo htmlspecialchars($student['roll']); ?></p>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo count($current_books); ?></div>
                <div class="stat-label">Books Borrowed</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $history_count; ?></div>
                <div class="stat-label">Total Reads</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Wishlisted</div>
            </div>
        </div>
        
        <div class="quick-actions">
            <a href="books.php" class="quick-action">Browse Books</a>
            <a href="profile.php" class="quick-action">My Profile</a>
            <a href="logout.php" class="quick-action">Logout</a>
        </div>
    </div>
    
    <div class="dashboard-grid">
        <div class="dashboard-card">
            <div class="card-header">
                <span>Currently Reading</span>
                <a href="currently_reading.php" class="view-all">View All</a>
            </div>
            <div class="book-list">
                <?php if (count($current_books) > 0): ?>
                    <?php foreach ($current_books as $book): ?>
                        <div class="book-item">
                            <div>
                                <div class="book-title"><?php echo htmlspecialchars($book['Name_of_Book']); ?></div>
                                <div class="book-meta">
                                    Due: <?php echo date('M d, Y', strtotime($book['return_date'])); ?>
                                </div>
                            </div>
                            <a href="return_book.php?id=<?php echo $book['Book_ID']; ?>" class="return-btn">Return</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; color: #666;">No books currently borrowed</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="dashboard-card">
            <div class="card-header">
                <span>Borrowed History</span>
                <a href="borrow_history.php" class="view-all">View All</a>
            </div>
            <div style="text-align: center; padding: 40px 0;">
                <div style="font-size: 48px; color: #05420f;"><?php echo $history_count; ?></div>
                <p>Total books borrowed</p>
                <a href="borrow_history.php" style="color: #05420f;">View full history →</a>
            </div>
        </div>
        
        <div class="dashboard-card">
            <div class="card-header">
                <span>Library Announcements</span>
            </div>
            <div>
                <?php foreach ($announcements as $announcement): ?>
                    <div class="announcement-item">• <?php echo $announcement; ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include('Footer.php'); ?>