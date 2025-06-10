<?php
session_start();
include('connection.php');

// Check if admin is logged in
if(!isset($_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
    exit();
}

// Get admin info
$admin_id = $_SESSION['admin_id'];
$stmt = $db->prepare("SELECT name, email FROM admin WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        :root {
            --primary-color: #05420f;
            --secondary-color: #e9f5e9;
            --accent-color: #2e7d32;
            --text-color: #333;
            --light-gray: #f5f5f5;
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            color: var(--text-color);
        }
        
        .dashboard-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            background-color: var(--primary-color);
            color: white;
            padding: 20px 0;
        }
        
        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-nav {
            margin-top: 20px;
        }
        
        .nav-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .nav-item:hover, .nav-item.active {
            background-color: rgba(255,255,255,0.1);
        }
        
        .nav-item i {
            margin-right: 10px;
        }
        
        /* Main Content Styles */
        .main-content {
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        /* Cards Layout */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .card.stat-card {
            text-align: center;
        }
        
        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: var(--primary-color);
            margin: 10px 0;
        }
        
        .stat-label {
            color: #666;
        }
        
        /* Recent Activity */
        .activity-list {
            margin-top: 20px;
        }
        
        .activity-item {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            align-items: center;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            background-color: var(--secondary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary-color);
        }
        
        .activity-details {
            flex: 1;
        }
        
        .activity-time {
            color: #999;
            font-size: 13px;
        }
        
        /* Button Styles */
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 13px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                display: none;
            }
        }
    </style>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Library Admin</h2>
                <p>Welcome, <?php echo htmlspecialchars($admin['name']); ?></p>
            </div>
            
            <div class="sidebar-nav">
                <div class="nav-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </div>
                <div class="nav-item">
                    <i class="fas fa-book"></i>
                    <span>Books Management</span>
                </div>
                <div class="nav-item">
                    <i class="fas fa-users"></i>
                    <span>Students</span>
                </div>
                <div class="nav-item">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transactions</span>
                </div>
                <div class="nav-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Bookings</span>
                </div>
                <div class="nav-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </div>
                <div class="nav-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h3>Dashboard Overview</h3>
                <div class="user-info">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($admin['name']); ?>&background=random" alt="Admin">
                    <span><?php echo htmlspecialchars($admin['name']); ?></span>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="cards-container">
                <div class="card stat-card">
                    <i class="fas fa-book fa-2x" style="color: var(--primary-color);"></i>
                    <div class="stat-number">
                        <?php 
                        $stmt = $db->query("SELECT COUNT(*) FROM books");
                        echo $stmt->fetch_row()[0]; 
                        ?>
                    </div>
                    <div class="stat-label">Total Books</div>
                </div>
                
                <div class="card stat-card">
                    <i class="fas fa-users fa-2x" style="color: var(--primary-color);"></i>
                    <div class="stat-number">
                        <?php 
                        $stmt = $db->query("SELECT COUNT(*) FROM students");
                        echo $stmt->fetch_row()[0]; 
                        ?>
                    </div>
                    <div class="stat-label">Registered Students</div>
                </div>
                
                <div class="card stat-card">
                    <i class="fas fa-exchange-alt fa-2x" style="color: var(--primary-color);"></i>
                    <div class="stat-number">
                        <?php 
                        $stmt = $db->query("SELECT COUNT(*) FROM transactions WHERE return_date IS NULL");
                        echo $stmt->fetch_row()[0]; 
                        ?>
                    </div>
                    <div class="stat-label">Books Checked Out</div>
                </div>
                
                <div class="card stat-card">
                    <i class="fas fa-exclamation-circle fa-2x" style="color: var(--primary-color);"></i>
                    <div class="stat-number">
                        <?php 
                        $stmt = $db->query("SELECT COUNT(*) FROM transactions WHERE return_date < NOW() AND is_returned = 0");
                        echo $stmt->fetch_row()[0]; 
                        ?>
                    </div>
                    <div class="stat-label">Overdue Books</div>
                </div>
            </div>
            
            <!-- Recent Activity and Quick Actions -->
            <div class="cards-container">
                <div class="card" style="grid-column: span 2;">
                    <h3>Recent Activity</h3>
                    <div class="activity-list">
                        <?php
                        $stmt = $db->query("SELECT * FROM activity_log ORDER BY created_at DESC LIMIT 5");
                        while($activity = $stmt->fetch_assoc()):
                        ?>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-<?php 
                                    switch($activity['activity_type']) {
                                        case 'book_add': echo 'book'; break;
                                        case 'checkout': echo 'arrow-right'; break;
                                        case 'return': echo 'arrow-left'; break;
                                        default: echo 'info-circle';
                                    }
                                ?>"></i>
                            </div>
                            <div class="activity-details">
                                <div><?php echo htmlspecialchars($activity['description']); ?></div>
                                <div class="activity-time">
                                    <?php echo date('M j, Y g:i A', strtotime($activity['created_at'])); ?>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                
                <div class="card">
                    <h3>Quick Actions</h3>
                    <div style="margin-top: 15px;">
                        <button class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">
                            <i class="fas fa-plus"></i> Add New Book
                        </button>
                        <button class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">
                            <i class="fas fa-user-plus"></i> Register Student
                        </button>
                        <button class="btn btn-primary" style="width: 100%; margin-bottom: 10px;">
                            <i class="fas fa-book-reader"></i> Checkout Book
                        </button>
                        <button class="btn btn-primary" style="width: 100%;">
                            <i class="fas fa-calendar-check"></i> Manage Bookings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Simple JavaScript for sidebar navigation
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all items
                document.querySelectorAll('.nav-item').forEach(i => {
                    i.classList.remove('active');
                });
                
                // Add active class to clicked item
                this.classList.add('active');
                
                // In a real application, you would load content here
                if(this.querySelector('span').textContent === 'Logout') {
                    window.location.href = 'logout.php';
                }
            });
        });
    </script>
</body>
</html>