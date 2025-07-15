<?php
session_start();
require_once("config.php");

// ✅ যদি admin লগিন না করা থাকে, login.php তে পাঠাবে
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

// ✅ নতুন বই যোগ করা
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_book'])) {
    $book_name   = trim($_POST['book_name']);
    $author_name = trim($_POST['author_name']);
    $edition     = trim($_POST['edition']);
    $quantity    = (int) $_POST['quantity'];
    $status      = trim($_POST['status']);
    $department  = trim($_POST['department']);

    // ছবি আপলোড
    $book_pic = "";
    if (!empty($_FILES['book_pic']['name'])) {
        $target_dir = "Images/";
        $filename = time() . "_" . basename($_FILES["book_pic"]["name"]);
        $target_file = $target_dir . $filename;
        if (move_uploaded_file($_FILES["book_pic"]["tmp_name"], $target_file)) {
            $book_pic = $filename;
        }
    }

    $stmt = $conn->prepare("INSERT INTO books(book_name, author_name, status, quantity, department, edition, book_pic) VALUES(?,?,?,?,?,?,?)");
    $stmt->bind_param("sssisss", $book_name, $author_name, $status, $quantity, $department, $edition, $book_pic);
    $stmt->execute();
    $stmt->close();

    header("Location: BookManage.php?added=1");
    exit();
}

// ✅ কোনো বই delete করা
if (isset($_GET['delete'])) {
    $book_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM books WHERE book_id=?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $stmt->close();

    header("Location: BookManage.php?deleted=1");
    exit();
}

// ✅ সব বই দেখানো
$result = $conn->query("SELECT * FROM books ORDER BY book_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Books</title>
<style>
body {
  font-family: 'Segoe UI', sans-serif;
  background: #eef3f2;
  margin: 0;
}
.navbar {
  background-color: #2a5934;
  color: #fff;
  padding: 15px 25px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.navbar a {
  color: #fff;
  text-decoration: none;
  font-weight: bold;
  margin-left: 15px;
}
.container {
  padding: 20px;
}
h2 {
  color: #2a5934;
  margin-top: 0;
}
.form-section {
  background: #fff;
  padding: 20px;
  margin-bottom: 30px;
  border-radius: 10px;
  box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}
.form-section label {
  display: block;
  margin-bottom: 6px;
  font-weight: bold;
}
.form-section input, .form-section select {
  width: 100%;
  padding: 8px;
  margin-bottom: 12px;
  border-radius: 6px;
  border: 1px solid #ccc;
}
.form-section button {
  background: #2a5934;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 6px;
  font-weight: bold;
  cursor: pointer;
}
.book-grid {
  display: grid;
  grid-template-columns: repeat(5,1fr);
  gap: 20px;
}
.book-card {
  background: #fff;
  padding: 15px;
  border-radius: 8px;
  box-shadow: 0 3px 8px rgba(0,0,0,0.1);
  text-align: center;
}
.book-card img {
  width: 100%;
  height: 160px;
  object-fit: contain;
  background: #f3f3f3;
  border-radius: 6px;
  margin-bottom: 8px;
}
.delete-btn {
  display: inline-block;
  background: #e74c3c;
  color: #fff;
  padding: 6px 12px;
  border-radius: 6px;
  text-decoration: none;
  font-weight: bold;
}
.delete-btn:hover {
  background: #c0392b;
}
.success-msg {
  background: #27ae60;
  color: #fff;
  padding: 10px;
  margin-bottom: 15px;
  border-radius: 6px;
  font-weight: bold;
}
</style>
</head>
<body>
<div class="navbar">
  <div>📚 Manage Books</div>
  <div>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="logout.php">Logout</a>
  </div>
</div>

<div class="container">
  <?php if(isset($_GET['added'])): ?>
    <div class="success-msg">✅ Book Added Successfully!</div>
  <?php endif; ?>
  <?php if(isset($_GET['deleted'])): ?>
    <div class="success-msg" style="background:#e74c3c;">🗑️ Book Deleted Successfully!</div>
  <?php endif; ?>

  <div class="form-section">
    <h2>Add New Book</h2>
    <form method="POST" enctype="multipart/form-data">
      <label>Book Name</label>
      <input type="text" name="book_name" required>
      
      <label>Author Name</label>
      <input type="text" name="author_name">
      
      <label>Edition</label>
      <input type="text" name="edition">
      
      <label>Quantity</label>
      <input type="number" name="quantity" required>
      
      <label>Status</label>
      <select name="status">
        <option value="Available">Available</option>
        <option value="Borrowed">Borrowed</option>
      </select>
      
      <label>Department</label>
      <input type="text" name="department" placeholder="e.g. CSE, ECE">
      
      <label>Book Picture</label>
      <input type="file" name="book_pic">
      
      <button type="submit" name="add_book">➕ Add Book</button>
    </form>
  </div>

  <h2>📖 Existing Books</h2>
  <div class="book-grid">
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="book-card">
        <img src="Images/<?php echo htmlspecialchars($row['book_pic']); ?>" alt="Book"
             onerror="this.onerror=null; this.src='Images/default.jpg';">
        <strong><?php echo htmlspecialchars($row['book_name']); ?></strong><br>
        <small><?php echo htmlspecialchars($row['author_name']); ?></small><br>
        <small>Edition: <?php echo htmlspecialchars($row['edition']); ?></small><br>
        <small>Qty: <?php echo htmlspecialchars($row['quantity']); ?></small><br>
        <small>Dept: <?php echo htmlspecialchars($row['department']); ?></small><br>
        <a class="delete-btn" href="?delete=<?php echo $row['book_id']; ?>" onclick="return confirm('Delete this book?');">Delete</a>
      </div>
    <?php endwhile; ?>
  </div>
</div>
</body>
</html>
