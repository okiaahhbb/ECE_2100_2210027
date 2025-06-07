<?php
session_start();
include('connection.php');

// 1. Check login status
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// 2. Load student data
$username = $_SESSION['username'];
$student_query = "SELECT * FROM student WHERE username='$username'";
$user_data = $db->query($student_query)->fetch_assoc();

// 3. Get active loans
$active_loans = $db->query("
    SELECT b.Name_of_Book, bb.issue_date, bb.return_date, 
           DATEDIFF(bb.return_date, CURDATE()) AS days_remaining
    FROM borrowed_books bb
    JOIN books b ON bb.book_id = b.Book_ID
    WHERE bb.student_username='$username' AND bb.returned=FALSE
");

// 4. Count borrowed books
$borrowed_count = $db->query(
    "SELECT COUNT(*) FROM borrowed_books 
     WHERE student_username='$username' AND returned=FALSE"
)->fetch_row()[0];

// 5. Count overdue books
$overdue_count = $db->query(
    "SELECT COUNT(*) FROM borrowed_books 
     WHERE student_username='$username' AND returned=FALSE 
     AND return_date < CURDATE()"
)->fetch_row()[0];

// 6. Get recommended books
$recommended_books = $db->query("
    SELECT * FROM books 
    WHERE Status='Available'
    LIMIT 5
");

// 7. Get wishlist items
$wishlist_items = $db->query("
    SELECT b.* FROM wishlist w
    JOIN books b ON w.book_id = b.Book_ID
    WHERE w.student_username='$username'
    LIMIT 5
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        :root {
            --primary: #2e7d32;
            --secondary: #558b2f;
            --accent: #ffab00;
            --danger: #c62828;
            --light-bg: #f1f8e9;
            --card-bg: #ffffff;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--light-bg);
            color: #333;
        }
        
        .container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .profile-card {
            padding: 25px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 10px;
            margin-bottom: 25px;
            color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 25px 0;
        }
        
        .stat-card {
            padding: 20px;
            background: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            text-align: center;
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card h3 {
            color: var(--primary);
            margin-top: 0;
        }
        
        .stat-card p {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0 0;
        }
        
        .stat-card.warning {
            border-top: 4px solid var(--accent);
        }
        
        .stat-card.danger {
            border-top: 4px solid var(--danger);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        th {
            background: var(--primary);
            color: white;
            padding: 15px;
            text-align: left;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        tr:nth-child(even) {
            background-color: #f8f8f8;
        }
        
        tr.overdue {
            background-color: #ffebee;
        }
        
        tr:hover {
            background-color: #f1f8e9;
        }
        
        .search-section {
            margin: 30px 0;
            background: var(--card-bg);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        #book-search {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            transition: border 0.3s;
        }
        
        #book-search:focus {
            border-color: var(--primary);
            outline: none;
        }
        
        .wishlist-section {
            margin: 30px 0;
            background: var(--card-bg);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .book-carousel, .wishlist-carousel {
            display: flex;
            overflow-x: auto;
            gap: 20px;
            padding: 15px 0;
        }
        
        .book-card {
            min-width: 220px;
            background: var(--card-bg);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
            transition: transform 0.3s;
        }
        
        .book-card:hover {
            transform: translateY(-5px);
        }
        
        .book-card h4 {
            color: var(--primary);
            margin-top: 0;
        }
        
        button {
            padding: 10px 20px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 15px;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        button:hover {
            background: var(--secondary);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .logout-btn {
            display: block;
            width: 100px;
            text-align: center;
            margin: 30px auto;
            padding: 10px;
            background: var(--danger);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .logout-btn:hover {
            background: #8e0000;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            color: #666;
            border-top: 1px solid #e0e0e0;
        }
        
        /* Modern scrollbar */
        ::-webkit-scrollbar {
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .book-card {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        .book-card:nth-child(1) { animation-delay: 0.1s; }
        .book-card:nth-child(2) { animation-delay: 0.2s; }
        .book-card:nth-child(3) { animation-delay: 0.3s; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Profile Section -->
        <div class="profile-card">
            <h2>Welcome, <?php echo htmlspecialchars($user_data['name'] ?? 'User'); ?></h2>
            <p>Roll: <?php echo htmlspecialchars($user_data['roll'] ?? 'N/A'); ?></p>
            <p>Department: <?php echo htmlspecialchars($user_data['dept'] ?? 'Not specified'); ?></p>
        </div>
        
        <!-- Quick Stats -->
        <div class="stats-container">
            <div class="stat-card">
                <h3>Borrowed Books</h3>
                <p><?php echo $borrowed_count; ?></p>
            </div>
            <div class="stat-card warning">
                <h3>Overdue</h3>
                <p><?php echo $overdue_count; ?></p>
            </div>
            <div class="stat-card danger">
                <h3>Pending Fines</h3>
                <p>₹10</p>
            </div>
        </div>
        
        <!-- Borrowed Books Table -->
        <h2>Your Borrowed Books</h2>
        <?php if($borrowed_count > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Issue Date</th>
                    <th>Due Date</th>
                    <th>Days Remaining</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($loan = $active_loans->fetch_assoc()): ?>
                <tr class="<?php echo ($loan['days_remaining'] < 0) ? 'overdue' : ''; ?>">
                    <td><?php echo htmlspecialchars($loan['Name_of_Book']); ?></td>
                    <td><?php echo $loan['issue_date']; ?></td>
                    <td><?php echo $loan['return_date']; ?></td>
                    <td><?php echo $loan['days_remaining']; ?></td>
                    <td>
                        <?php if($loan['days_remaining'] >= 0): ?>
                            <button class="renew-btn">Renew</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>You haven't borrowed any books yet.</p>
        <?php endif; ?>
        
        <!-- Wishlist Section -->
        <div class="wishlist-section">
            <h2>Your Wishlist</h2>
            <?php if($wishlist_items->num_rows > 0): ?>
            <div class="wishlist-carousel">
                <?php while($book = $wishlist_items->fetch_assoc()): ?>
                <div class="book-card">
                    <h4><?php echo htmlspecialchars($book['Name_of_Book']); ?></h4>
                    <p>By <?php echo htmlspecialchars($book['Name_of_Author']); ?></p>
                    <button class="borrow-btn" data-book-id="<?php echo $book['Book_ID']; ?>">Borrow</button>
                    <button class="remove-wishlist-btn" data-book-id="<?php echo $book['Book_ID']; ?>" style="background: var(--danger); margin-top: 5px;">Remove</button>
                </div>
                <?php endwhile; ?>
            </div>
            <?php else: ?>
            <p>Your wishlist is empty. Add books from the recommendations!</p>
            <?php endif; ?>
        </div>
        
        <!-- Book Search -->
        <div class="search-section">
            <h2>Search Books</h2>
            <input type="text" id="book-search" placeholder="Search by book name, author...">
            <div id="search-results"></div>
        </div>
        
        <!-- Recommended Books -->
        <h2>Recommended For You</h2>
        <div class="book-carousel">
            <?php while($book = $recommended_books->fetch_assoc()): ?>
            <div class="book-card">
                <h4><?php echo htmlspecialchars($book['Name_of_Book']); ?></h4>
                <p>By <?php echo htmlspecialchars($book['Name_of_Author']); ?></p>
                <button class="borrow-btn" data-book-id="<?php echo $book['Book_ID']; ?>">Borrow</button>
                <button class="add-wishlist-btn" data-book-id="<?php echo $book['Book_ID']; ?>" style="background: var(--accent); margin-top: 5px;">Add to Wishlist</button>
            </div>
            <?php endwhile; ?>
        </div>
        
        <!-- Logout Button -->
        <a href="logout.php" class="logout-btn">Logout</a>
        
        <div class="footer">
            <p>© <?php echo date('Y'); ?> RUET Library. All rights reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Book search functionality
        $('#book-search').keyup(function() {
            const query = $(this).val();
            if(query.length > 2) {
                $.post('search_books.php', {query: query}, function(data) {
                    $('#search-results').html(data);
                });
            }
        });
        
        // Borrow book functionality
        $(document).on('click', '.borrow-btn', function() {
            const bookId = $(this).data('book-id');
            if(confirm('Are you sure you want to borrow this book?')) {
                $.post('borrow_book.php', {book_id: bookId}, function(response) {
                    alert(response.message);
                    location.reload();
                }).fail(function() {
                    alert('Error processing your request');
                });
            }
        });
        
        // Renew book functionality
        $(document).on('click', '.renew-btn', function() {
            if(confirm('Renew this book for another 14 days?')) {
                const row = $(this).closest('tr');
                const bookTitle = row.find('td:first').text();
                
                $.post('renew_loan.php', {book_title: bookTitle}, function(response) {
                    alert(response.message);
                    location.reload();
                }).fail(function() {
                    alert('Error processing renewal');
                });
            }
        });
        
        // Add to wishlist
        $(document).on('click', '.add-wishlist-btn', function() {
            const bookId = $(this).data('book-id');
            $.post('add_wishlist.php', {book_id: bookId}, function(response) {
                alert(response.message);
                location.reload();
            });
        });
        
        // Remove from wishlist
        $(document).on('click', '.remove-wishlist-btn', function() {
            const bookId = $(this).data('book-id');
            if(confirm('Remove this book from your wishlist?')) {
                $.post('remove_wishlist.php', {book_id: bookId}, function(response) {
                    alert(response.message);
                    location.reload();
                });
            }
        });
    });
    </script>
</body>
</html>