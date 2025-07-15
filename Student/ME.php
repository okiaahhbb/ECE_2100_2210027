<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Search handle
$searchQuery = "";
if (isset($_GET['search']) && $_GET['search'] !== "") {
    $q = mysqli_real_escape_string($conn, $_GET['search']);
    $searchQuery = " AND (book_name LIKE '%$q%' OR author_name LIKE '%$q%')";
}

$sql = "SELECT * FROM books WHERE department = 'ME' $searchQuery";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ME Books</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #eef3f2;
      margin: 0;
    }

    .navbar {
      background-color: #2a5934;
      color: white;
      padding: 15px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .navbar a {
      color: white;
      text-decoration: none;
      font-weight: bold;
    }

    .container {
      padding: 30px;
    }

    /* Search bar */
    .search-bar {
      margin-bottom: 25px;
      display: flex;
      justify-content: center;
    }
    .search-bar input[type="text"] {
      padding: 10px 15px;
      border: 1px solid #ccc;
      border-radius: 8px 0 0 8px;
      font-size: 16px;
      width: 300px;
      outline: none;
    }
    .search-bar button {
      padding: 10px 20px;
      border: none;
      background-color: #2a5934;
      color: white;
      font-size: 16px;
      border-radius: 0 8px 8px 0;
      cursor: pointer;
      transition: background 0.3s;
    }
    .search-bar button:hover {
      background-color: #3e7b50;
    }

    .book-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 25px;
    }

    .book-card {
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      padding: 15px;
      transition: transform 0.3s;
      position: relative;
    }

    .book-card:hover {
      transform: scale(1.03);
    }

    .book-card img {
      width: 100%;
      height: 240px;
      object-fit: contain;
      border-radius: 8px;
      margin-bottom: 10px;
      background: #f3f3f3;
    }

    .book-info {
      font-size: 14px;
      line-height: 1.5;
    }

    .book-info strong {
      color: #2a5934;
    }

    .borrow-btn {
      margin-top: 10px;
      display: block;
      width: 100%;
      padding: 8px;
      border: none;
      border-radius: 6px;
      background-color: #2a5934;
      color: white;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.3s;
    }

    .borrow-btn:hover {
      background-color: #3e7b50;
    }

    /* ===== Popup Modal ===== */
    .modal-overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.6);
      z-index: 9999;
      justify-content: center;
      align-items: center;
    }

    .modal-box {
      background: #ffffff;
      padding: 30px 25px;
      border-radius: 12px;
      text-align: center;
      max-width: 350px;
      width: 90%;
      box-shadow: 0 6px 20px rgba(0,0,0,0.3);
      animation: pop 0.3s ease;
    }

    .modal-box h3 {
      margin-bottom: 15px;
      color: #2a5934;
      font-size: 20px;
    }

    .modal-box p {
      font-size: 16px;
      margin-bottom: 20px;
    }

    .modal-buttons {
      display: flex;
      justify-content: center;
      gap: 10px;
    }

    .modal-buttons button {
      background: #2a5934;
      color: #fff;
      border: none;
      padding: 10px 18px;
      border-radius: 8px;
      font-size: 15px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
    }

    .modal-buttons button:hover {
      background: #3e7b50;
    }

    .close-btn {
      background: #888;
    }

    .close-btn:hover {
      background: #555;
    }

    @keyframes pop {
      from { transform: scale(0.8); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }
  </style>
</head>
<body>

  <div class="navbar">
    <div>📘 ME Book Collection</div>
    <a href="dashboard.php">Go to Dashboard</a>
  </div>

  <div class="container">
    <!-- Search Bar -->
    <form class="search-bar" method="GET">
      <input type="text" name="search" placeholder="Search by name or author..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
      <button type="submit">🔍 Search</button>
    </form>

    <div class="book-grid">
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="book-card">
          <img src="Images/<?php echo htmlspecialchars($row['book_pic']); ?>"
               alt="Book Image"
               onerror="this.onerror=null; this.src='Images/default.jpg';">
          <div class="book-info">
            <strong>ID:</strong> <?php echo $row['book_id']; ?><br>
            <strong>Name:</strong> <?php echo $row['book_name']; ?><br>
            <strong>Author:</strong> <?php echo $row['author_name']; ?><br>
            <strong>Edition:</strong> <?php echo $row['edition']; ?><br>
            <strong>Quantity:</strong> <?php echo $row['quantity']; ?><br>
            <strong>Status:</strong> <?php echo $row['status']; ?><br>
          </div>
          <form action="borrow_request.php" method="POST">
            <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
            <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
            <button type="submit" class="borrow-btn">Borrow</button>
          </form>
        </div>
      <?php } ?>
    </div>
  </div>

  <!-- ===== Center Screen Modal ===== -->
  <div class="modal-overlay" id="statusModal">
    <div class="modal-box">
      <h3 id="modalTitle">📨 Request Status</h3>
      <p id="modalMessage">Please wait a little…</p>
      <div class="modal-buttons">
        <button onclick="window.location.href='dashboard.php'">Go to Dashboard</button>
        <button class="close-btn" onclick="document.getElementById('statusModal').style.display='none'">Close</button>
      </div>
    </div>
  </div>

  <script>
    const params = new URLSearchParams(window.location.search);
    const status = params.get('request');
    if (status) {
      const modal = document.getElementById('statusModal');
      const title = document.getElementById('modalTitle');
      const message = document.getElementById('modalMessage');

      if (status === 'success') {
        title.textContent = '✅ Request Sent!';
        message.textContent = 'Please wait a little…';
      } else if (status === 'fail') {
        title.textContent = '❌ Failed!';
        message.textContent = 'Something went wrong. Please try again.';
      } else if (status === 'unavailable') {
        title.textContent = '📚 Not Available!';
        message.textContent = 'This book is not currently available.';
      } else if (status === 'already') {
        title.textContent = '⚠️ Already Requested!';
        message.textContent = 'You already have a pending request for this book.';
      }

      modal.style.display = 'flex';
    }
  </script>

</body>
</html>

