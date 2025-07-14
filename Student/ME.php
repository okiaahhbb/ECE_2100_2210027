<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$sql = "SELECT * FROM books WHERE department = 'ME'";
$result = mysqli_query($conn, $sql);

$showPopup = isset($_GET['request']) && $_GET['request'] == 'success';
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

    .popup-msg {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      background: #2a5934;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
      font-weight: bold;
      display: none;
      z-index: 9999;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <div>📘 ME Book Collection</div>
    <a href="dashboard.php">Go to Dashboard</a>
  </div>

  <div class="popup-msg" id="popup">📨 Request sent. Please wait a little...</div>

  <div class="container">
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
          <form action="request_book.php" method="POST">
            <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
            <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
            <button type="submit" class="borrow-btn">Borrow</button>
          </form>
        </div>
      <?php } ?>
    </div>
  </div>

  <script>
    const show = <?php echo $showPopup ? 'true' : 'false'; ?>;
    if (show) {
      const popup = document.getElementById('popup');
      popup.style.display = 'block';
      setTimeout(() => {
        popup.style.display = 'none';
      }, 3000);
    }
  </script>

</body>
</html>
