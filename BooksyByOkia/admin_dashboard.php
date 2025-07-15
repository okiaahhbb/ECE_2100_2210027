<?php
session_start();
require_once("config.php");

// Login check
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

// Admin info
$user = [
    'username' => $_SESSION['admin_username'],
    'email' => 'admin@example.com',
    'phone' => '0123456789'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard - <?php echo htmlspecialchars($user['username']); ?></title>
  <style>
    :root {
      --primary-green: #2a5934;
      --white: #ffffff;
      --login-light: #c7e8cd;
      --shadow-sm: 0 2px 4px rgba(0,0,0,0.1);
    }
    body {
      font-family: Arial, sans-serif;
      background-color: #e8f3e8;
      margin: 0;
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      background: var(--primary-green);
      color: white;
      width: 220px;
      height: 100vh;
      padding: 20px;
      position: fixed;
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    }
    .sidebar img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background: white;
      padding: 5px;
      margin: 0 auto 20px auto;
    }
    .sidebar ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .sidebar ul li {
      margin: 12px 0;
    }
    .sidebar ul li a {
      color: white;
      text-decoration: none;
      padding: 12px;
      display: block;
      border-radius: 6px;
      transition: all 0.3s ease;
    }
    .sidebar ul li a:hover {
      background-color: #1e4720;
      transform: translateX(5px);
    }
    .sidebar-divider {
      border-top: 1px solid rgba(255,255,255,0.3);
      margin: 25px 0 15px 0;
    }
    .sidebar-section-title {
      font-size: 14px;
      text-transform: uppercase;
      color: #cfcfcf;
      margin: 10px 0 5px 15px;
    }
    .main {
      margin-left: 240px;
      padding: 30px;
      width: calc(100% - 240px);
      max-width: 1400px;
    }
    .topbar {
      background: white;
      padding: 12px 25px;
      margin-bottom: 25px;
      border-radius: 8px;
      box-shadow: var(--shadow-sm);
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 14px;
    }
    .topbar span {
      font-weight: bold;
      color: var(--primary-green);
    }
    .about-curve-section {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 35px 5% 45px;
      background-color: var(--primary-green);
      color: white;
      position: relative;
      overflow: hidden;
      clip-path: ellipse(120% 100% at 50% 0%);
      margin-bottom: 35px;
      border-radius: 12px;
    }
    .about-left {
      flex: 1;
      padding-right: 40px;
      animation: fadeInLeft 1s ease-in-out;
    }
    .about-left h2 {
      font-size: 24px;
      margin-bottom: 10px;
    }
    .about-left .intro {
      margin-bottom: 18px;
      font-size: 14px;
      color: rgba(255, 255, 255, 0.9);
      line-height: 1.4;
    }
    .about-left p {
      font-size: 14px;
      margin: 5px 0;
      color: rgba(255, 255, 255, 0.95);
    }
    .edit-btn {
      display: inline-block;
      margin-top: 20px;
      background-color: white;
      color: var(--primary-green);
      padding: 10px 18px;
      border-radius: 6px;
      font-weight: bold;
      text-decoration: none;
      transition: all 0.3s ease;
      box-shadow: var(--shadow-sm);
      border: none;
      cursor: pointer;
      font-size: 14px;
    }
    .edit-btn:hover {
      background-color: var(--login-light);
      transform: scale(1.03) translateY(-2px);
      box-shadow: 0 3px 6px rgba(0,0,0,0.15);
    }
    .about-right {
      flex: 1;
      display: flex;
      justify-content: center;
      animation: fadeInRight 1s ease-in-out;
    }
    .about-right img {
      max-width: 200px;
      width: 100%;
      animation: floatImage 4s ease-in-out infinite;
    }
    @keyframes floatImage {
      0% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0); }
    }
    @keyframes fadeInLeft {
      from { opacity: 0; transform: translateX(-30px); }
      to { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeInRight {
      from { opacity: 0; transform: translateX(30px); }
      to { opacity: 1; transform: translateX(0); }
    }

    /* Manage Section Updated */
    .manage-section {
      margin-top: 50px;
      text-align: center;
    }
    .manage-title {
      font-size: 22px;
      margin-bottom: 30px;
      color: #2a5934;
      font-weight: bold;
    }
    .manage-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 25px;
      justify-items: center;
    }
    .manage-card {
      background: #ffffff;
      border-radius: 12px;
      padding: 30px 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      cursor: pointer;
      transition: all 0.3s ease;
      width: 100%;
      max-width: 260px;
      text-align: center;
      text-decoration: none;
    }
    .manage-card:hover {
      background: #e6f4e6; /* hover background */
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      transform: translateY(-5px);
    }
    .manage-card img {
      max-width: 80px;
      margin-bottom: 15px;
    }
    .manage-card h3 {
      margin: 0;
      font-size: 18px;
      color: #2a5934;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <img src="Images/cat.svg" alt="Profile Icon">
    <ul>
      <li><a href="#">About You</a></li>
      <li><a href="BookManage.php">Manage Books</a></li>
      <li><a href="UserManage.php">Manage Users</a></li>
      <li><a href="FeedbackManage.php">Manage Feedback</a></li>
      <li><a href="#">Report</a></li>
    </ul>
    <div class="sidebar-divider"></div>
    <div class="sidebar-section-title">More</div>
    <ul>
      <li><a href="#">Settings</a></li>
      <li><a href="#">Help</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main">
    <div class="topbar">
      <div>Welcome back!</div>
      <div>Logged in as: <span><?php echo htmlspecialchars($user['username']); ?></span></div>
    </div>

    <!-- About Section -->
    <section class="about-curve-section">
      <div class="about-left">
        <h2>About Me</h2>
        <p class="intro">Here’s your admin profile overview.</p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        <a href="edit-profile.php" class="edit-btn">✏️ Edit Profile</a>
      </div>
      <div class="about-right">
        <img src="Images/cat.svg" alt="Profile Illustration" />
      </div>
    </section>

    <!-- Manage Section -->
    <section class="manage-section">
      <h2 class="manage-title">📌 Explore by Category</h2>
      <div class="manage-grid">
        <a href="BookManage.php" class="manage-card">
          <img src="Images/BookManage.svg" alt="Manage Books">
          <h3>Manage Books</h3>
        </a>
        <a href="BorrowRequest.php" class="manage-card">
          <img src="Images/BorrowRequest.svg" alt="Approve Requests">
          <h3>Approve Borrow</h3>
        </a>
        <a href="UserManage.php" class="manage-card">
          <img src="Images/UserManage.svg" alt="Manage Users">
          <h3>Manage Users</h3>
        </a>
        <a href="FeedbackManage.php" class="manage-card">
          <img src="Images/FeedbackManage.svg" alt="Manage Feedback">
          <h3>Manage Feedback</h3>
        </a>
      </div>
    </section>
  </div>
</body>
</html>