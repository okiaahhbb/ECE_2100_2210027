<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard - <?php echo htmlspecialchars($user['username']); ?></title>
  <style>
    :root {
      --primary-green: #2a5934;
      --white: #ffffff;
      --login-light: #c7e8cd;
      --shadow-sm: 0 2px 4px rgba(0,0,0,0.1);
      --category-hover: #3a7d4a;
      --card-hover: #f0f7f0;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #e8f3e8;
      margin: 0;
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar */
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

    /* Main Content */
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
      justify-content: flex-end;
      align-items: center;
      font-size: 14px;
    }

    /* Compact About Me Section */
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

    /* Recommendations Section */
    .recommend-section {
      margin-top: 50px;
      padding: 0 15px;
    }

    .recommend-section h2 {
      font-size: 22px;
      margin-bottom: 20px;
      color: var(--primary-green);
      text-align: center;
    }

    .book-row {
      display: flex;
      justify-content: center;
      gap: 25px;
      flex-wrap: wrap;
      margin: 0 auto;
      max-width: 1200px;
    }

    .book-card {
      background: white;
      border-radius: 10px;
      box-shadow: var(--shadow-sm);
      width: 180px;
      padding: 15px;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: all 0.3s ease;
      border: 1px solid #e0e0e0;
    }

    .book-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0,0,0,0.1);
      background-color: var(--card-hover);
    }

    .book-card img {
      max-height: 140px;
      margin-bottom: 12px;
      border-radius: 4px;
    }

    .book-title {
      font-weight: bold;
      font-size: 14px;
      margin-bottom: 5px;
      color: var(--primary-green);
    }

    .book-author {
      font-size: 12px;
      color: #555;
      margin-bottom: 8px;
    }

    .book-status {
      font-size: 11px;
      color: #666;
      padding: 4px;
      border-radius: 3px;
      background: #f5f5f5;
    }

    .no-books {
      width: 100%;
      text-align: center;
      color: #666;
      font-style: italic;
      padding: 25px;
      font-size: 14px;
    }

    /* Explore by Category Section */
    .category-section {
      margin-top: 60px;
      padding: 0 15px;
    }

    .category-section h2 {
      font-size: 22px;
      margin-bottom: 25px;
      color: var(--primary-green);
      text-align: center;
    }

    .category-row {
      display: flex;
      justify-content: center;
      gap: 30px;
      flex-wrap: wrap;
      margin: 0 auto;
      max-width: 1200px;
    }

    .category-card {
      background: white;
      border-radius: 12px;
      box-shadow: var(--shadow-sm);
      width: 220px;
      padding: 25px;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: all 0.3s ease;
      text-decoration: none;
      color: var(--primary-green);
      border: 2px solid #e0e0e0;
    }

    .category-card:hover {
      transform: translateY(-6px) scale(1.02);
      box-shadow: 0 10px 18px rgba(0,0,0,0.15);
      background-color: var(--primary-green);
      color: white;
      border-color: var(--category-hover);
    }

    .category-card:hover .category-name {
      color: white;
    }

    .category-card img {
      width: 90px;
      height: 90px;
      margin-bottom: 20px;
      transition: transform 0.3s ease;
    }

    .category-card:hover img {
      transform: scale(1.1);
      filter: brightness(0) invert(1);
    }

    .category-name {
      font-weight: bold;
      font-size: 18px;
      transition: color 0.3s ease;
    }

    /* Animations */
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

    /* Responsive Adjustments */
    @media (max-width: 1200px) {
      .category-card {
        width: 200px;
      }
    }

    @media (max-width: 992px) {
      .about-curve-section {
        flex-direction: column;
        padding: 30px 5% 40px;
      }
      .about-left {
        padding-right: 0;
        margin-bottom: 25px;
        text-align: center;
      }
      .about-right img {
        max-width: 180px;
      }
      .category-card {
        width: 180px;
        padding: 20px;
      }
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 180px;
        padding: 15px;
      }
      .main {
        margin-left: 200px;
        padding: 25px;
        width: calc(100% - 200px);
      }
      .book-card {
        width: 150px;
        padding: 12px;
      }
      .category-card {
        width: 150px;
        padding: 18px;
      }
      .category-card img {
        width: 70px;
        height: 70px;
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <img src="Images/cat.svg" alt="Profile Icon">
    <ul>
      <li><a href="aboutme.php">About You</a></li>
      <li><a href="category.php">Category</a></li>
      <li><a href="recommendations.php">Recommendations</a></li>
      <li><a href="borrow_history.php">Borrow History</a></li>
      
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
      Logged in as <strong>&nbsp;<?php echo htmlspecialchars($user['username']); ?></strong>
    </div>

    <!-- Compact About Me Section -->
    <section class="about-curve-section">
      <div class="about-left">
        <h2>About Me</h2>
        <p class="intro">Welcome to your dashboard! Here's a quick look at your profile details.</p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
        <p><strong>Department:</strong> <?php echo htmlspecialchars($user['department']); ?></p>
        <p><strong>Roll:</strong> <?php echo htmlspecialchars($user['roll']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        <a href="edit-profile.php" class="edit-btn">✏️ Edit Profile</a>
      </div>
      <div class="about-right">
        <img src="Images/cat.svg" alt="Profile Illustration" />
      </div>
    </section>

    <!-- Recommendations Section -->
    <section class="recommend-section">
      <h2>Recommended Books for You</h2>
      <div class="book-row">
        <?php
        $dept = $user['department'];
        $stmt = $conn->prepare("SELECT * FROM books WHERE department = ? LIMIT 5");
        $stmt->bind_param("s", $dept);
        $stmt->execute();
        $books_result = $stmt->get_result();

        if ($books_result->num_rows > 0) {
          while ($book = $books_result->fetch_assoc()) {
            echo '<div class="book-card">';
            echo '<img src="Images/' . htmlspecialchars($book['book_pic']) . '" alt="Book Cover">';
            echo '<div class="book-title">' . htmlspecialchars($book['book_name']) . '</div>';
            echo '<div class="book-author">By ' . htmlspecialchars($book['author_name']) . '</div>';
            echo '<div class="book-status">' . htmlspecialchars($book['status']) . '</div>';
            echo '</div>';
          }
        } else {
          echo '<p class="no-books">No recommended books found for your department.</p>';
        }
        ?>
      </div>
    </section>

    <!-- Explore by Category Section -->
    <section class="category-section">
      <h2>Explore by Category</h2>
      <div class="category-row">
        <a href="ECE.php" class="category-card">
          <img src="Images/electrical.svg" alt="Electrical Engineering">
          <div class="category-name">Electrical</div>
        </a>
        <a href="ME.php" class="category-card">
          <img src="Images/mechanical.svg" alt="Mechanical Engineering">
          <div class="category-name">Mechanical</div>
        </a>
        <a href="CIVIL.php" class="category-card">
          <img src="Images/civil.svg" alt="Civil Engineering">
          <div class="category-name">Civil</div>
        </a>
      </div>
    </section>
  </div>
</body>
</html>