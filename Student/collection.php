<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "booksy");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get search and department from URL (GET)
$search = strtolower(trim($_GET['search'] ?? ''));
$department = strtoupper(trim($_GET['department'] ?? ''));

// Load all books from database
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
$allBooks = [];
while ($row = $result->fetch_assoc()) {
  $allBooks[] = $row;
}

// Filter books based on simple partial search
$books = [];
foreach ($allBooks as $book) {
  // Department filter
  if ($department && strtoupper($book['department']) !== $department) {
    continue;
  }

  // Search filter (simple case-insensitive partial match)
  if ($search) {
    $found = false;
    $fields = ['book_name', 'author_name', 'book_id', 'department'];
    foreach ($fields as $field) {
      if (strpos(strtolower($book[$field]), $search) !== false) {
        $found = true;
        break;
      }
    }
    if (!$found) continue;
  }

  $books[] = $book;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Collection</title>
<style>
  body {
    font-family: 'Segoe UI', sans-serif;
    background: #e8f3e8;
    margin: 0; padding: 0;
  }
  .navbar {
    background: #2a5934;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: white;
  }
  .nav-links a {
    color: white;
    text-decoration: none;
    margin-left: 20px;
    font-weight: 500;
  }
  .search-bar {
    padding: 20px;
    text-align: center;
  }
  .search-bar input[type="text"] {
    width: 60%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #aaa;
    border-radius: 8px;
  }
  .search-bar button {
    padding: 10px 20px;
    background-color: #2a5934;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    margin-left: 10px;
  }
  .departments {
    display: flex;
    justify-content: center;
    gap: 80px;
    padding: 60px 0;
  }
  .dept-card {
    background: white;
    border-radius: 20px;
    text-decoration: none;
    font-size: 24px;
    font-weight: bold;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 40px 30px;
    width: 220px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    color: #2a5934;
    transition: box-shadow 0.3s;
  }
  .dept-card:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
  }
  .dept-card.active {
    background-color: #2a5934;
    color: white;
  }
  .dept-card img {
    width: 120px;
    height: 120px;
    margin-bottom: 20px;
  }
  .section-header {
    text-align: center;
    font-size: 28px;
    font-weight: bold;
    color: #2a5934;
    margin: 20px auto 10px;
  }
  .book-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 30px;
    padding: 30px;
    max-width: 1200px;
    margin: auto;
  }
  .book-card {
    background: white;
    padding: 15px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    height: 340px;
  }
  .book-card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 8px;
  }
  .book-title {
    font-weight: bold;
    margin: 10px 0 5px;
  }
  .book-author {
    font-size: 14px;
    color: #444;
  }
  .empty-slot {
    height: 340px;
    background: transparent;
  }
  #topBtn {
    display: none;
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 99;
    font-size: 18px;
    border: none;
    outline: none;
    background-color: #2a5934;
    color: white;
    cursor: pointer;
    padding: 12px 18px;
    border-radius: 10px;
  }
</style>
</head>
<body>

<div class="navbar">
  <div class="logo">📘 Booksy</div>
  <div class="nav-links">
    <a href="index.php">Home</a>
    <a href="collection.php">Collection</a>
    <a href="feedback.php">Feedback</a>
  </div>
</div>

<div class="search-bar">
  <form method="GET" action="collection.php">
    <input type="text" name="search" placeholder="Search by title, author, ID, or dept..." value="<?php echo htmlspecialchars($_GET['search'] ?? '') ?>">
    <input type="hidden" name="department" id="departmentInput" value="<?php echo htmlspecialchars($department); ?>">
    <button type="submit">Search</button>
  </form>
</div>

<div class="departments">
  <?php
  $departments = [
    ['name' => 'ECE', 'img' => 'Images/electrical.svg'],
    ['name' => 'ME', 'img' => 'Images/mechanical.svg'],
    ['name' => 'CIVIL', 'img' => 'Images/civil.svg'],
  ];
  foreach ($departments as $dept):
    $isActive = ($department === $dept['name']) ? 'active' : '';
  ?>
    <a class="dept-card <?php echo $isActive; ?>" href="collection.php?department=<?php echo $dept['name']; ?>">
      <img src="<?php echo $dept['img']; ?>" alt="<?php echo $dept['name']; ?>">
      <div><?php echo $dept['name']; ?></div>
    </a>
  <?php endforeach; ?>
</div>

<div class="section-header">📚 Look at our Collection</div>

<div class="book-grid">
  <?php
  $count = 0;
  foreach ($books as $book):
  ?>
    <div class="book-card">
      <img src="Images/books/<?php echo htmlspecialchars($book['book_pic']); ?>" alt="<?php echo htmlspecialchars($book['book_name']); ?>">
      <div class="book-title"><?php echo htmlspecialchars($book['book_name']); ?></div>
      <div class="book-author"><?php echo htmlspecialchars($book['author_name']); ?></div>
    </div>
  <?php
    $count++;
  endforeach;

  // Fill remaining slots in last row to keep grid consistent
  $remainder = $count % 5;
  if ($remainder > 0) {
    for ($i = 0; $i < 5 - $remainder; $i++) {
      echo '<div class="book-card" style="background: transparent; box-shadow: none;"></div>';
    }
  }

  if ($count === 0) {
    echo "<p style='text-align:center; color:#666;'>No books found matching your search.</p>";
  }
  ?>
</div>

<button onclick="topFunction()" id="topBtn" title="Go to top">⬆️ Top</button>

<script>
  const topButton = document.getElementById("topBtn");
  window.onscroll = function () {
    topButton.style.display = (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) ? "block" : "none";
  };
  function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
  }
</script>

</body>
</html>
