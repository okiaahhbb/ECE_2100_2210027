<?php
session_start();
require_once("config.php");

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

// Book Add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_book'])) {
    $book_name   = trim($_POST['book_name']);
    $author_name = trim($_POST['author_name']);
    $edition     = trim($_POST['edition']);
    $quantity    = (int) $_POST['quantity'];
    $status      = trim($_POST['status']);
    $department  = trim($_POST['department']);

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

    header("Location: BookManage.php?popup=added");
    exit();
}

// Book Delete
if (isset($_GET['delete'])) {
    $book_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM books WHERE book_id=?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $stmt->close();

    header("Location: BookManage.php?popup=deleted");
    exit();
}

// Book Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_book'])) {
    $book_id     = (int) $_POST['book_id'];
    $book_name   = trim($_POST['book_name']);
    $author_name = trim($_POST['author_name']);
    $edition     = trim($_POST['edition']);
    $quantity    = (int) $_POST['quantity'];
    $status      = trim($_POST['status']);
    $department  = trim($_POST['department']);

    $stmt = $conn->prepare("UPDATE books SET book_name=?, author_name=?, edition=?, quantity=?, status=?, department=? WHERE book_id=?");
    $stmt->bind_param("sssissi", $book_name, $author_name, $edition, $quantity, $status, $department, $book_id);
    $stmt->execute();
    $stmt->close();

    header("Location: BookManage.php?popup=edited");
    exit();
}

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
  padding: 30px;
  max-width: 600px;
  margin: 40px auto 0;
  border-radius: 12px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.15);
}
.form-section label {
  display: block;
  margin-bottom: 8px;
  font-weight: bold;
}
.form-section input, .form-section select {
  width: 100%;
  padding: 10px;
  margin-bottom: 16px;
  border-radius: 6px;
  border: 1px solid #ccc;
}
.form-section button {
  background: #2a5934;
  color: #fff;
  border: none;
  padding: 12px 20px;
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
.delete-btn, .edit-btn {
  display: inline-block;
  padding: 6px 12px;
  border-radius: 6px;
  font-weight: bold;
  margin-top: 6px;
  text-decoration: none;
  color: #fff;
}
.delete-btn {
  background: #e74c3c;
}
.delete-btn:hover {
  background: #c0392b;
}
.edit-btn {
  background: #3498db;
  margin-right: 5px;
  border: none;
  cursor: pointer;
}
.success-popup {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #27ae60;
  color: #fff;
  padding: 20px 30px;
  border-radius: 12px;
  font-size: 18px;
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
  <div>📚 Manage Books</div>
  <div>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="logout.php">Logout</a>
  </div>
</div>

<?php if(isset($_GET['popup'])): ?>
  <div class="success-popup">
    <?php
      $type = $_GET['popup'];
      if ($type === 'added') echo "✅ Book Added Successfully!";
      elseif ($type === 'deleted') echo "🗑️ Book Deleted Successfully!";
      elseif ($type === 'edited') echo "✏️ Book Edited Successfully!";
    ?>
  </div>
<?php endif; ?>

<div class="container">

  <h2>📖 Existing Books</h2>
  <div class="book-grid">
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="book-card">
        <img src="Images/<?php echo htmlspecialchars($row['book_pic']); ?>" alt="Book"
             onerror="this.onerror=null; this.src='Images/default.jpg';">
        <form method="POST" style="margin-top: 10px;">
          <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
          <input type="text" name="book_name" value="<?php echo htmlspecialchars($row['book_name']); ?>">
          <input type="text" name="author_name" value="<?php echo htmlspecialchars($row['author_name']); ?>">
          <input type="text" name="edition" value="<?php echo htmlspecialchars($row['edition']); ?>">
          <input type="number" name="quantity" value="<?php echo htmlspecialchars($row['quantity']); ?>">
          <select name="status">
            <option value="Available" <?php if($row['status']=='Available') echo 'selected'; ?>>Available</option>
            <option value="Borrowed" <?php if($row['status']=='Borrowed') echo 'selected'; ?>>Borrowed</option>
          </select>
          <input type="text" name="department" value="<?php echo htmlspecialchars($row['department']); ?>">
          <button type="submit" name="edit_book" class="edit-btn">Edit</button>
          <a class="delete-btn" href="?delete=<?php echo $row['book_id']; ?>" onclick="return confirm('Delete this book?');">Delete</a>
        </form>
      </div>
    <?php endwhile; ?>
  </div>

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

</div>
</body>
</html>
