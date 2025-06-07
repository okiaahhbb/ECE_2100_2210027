<?php include 'header.php'; ?>
<?php
include('connection.php');


$search_query = "";
$books = [];

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = mysqli_real_escape_string($db, $_GET['search']);
    $sql = "SELECT * FROM books WHERE 
            Book_ID LIKE '%$search_query%' OR 
            Name_of_Book LIKE '%$search_query%' OR 
            Name_of_Author LIKE '%$search_query%' OR 
            Dept LIKE '%$search_query%'";
} else {
    $sql = "SELECT * FROM books";
}

$result = mysqli_query($db, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }
}
?>

<style>
    .books-container {
        flex: 1;
        padding: 40px 60px;
    }
    
    .books-table {
        width: 100%;
        background-color: #e9f5e9;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    
    .search-container {
        margin-bottom: 25px;
        display: flex;
        justify-content: center;
    }
    
    .search-box {
        width: 60%;
        padding: 12px 20px;
        border: 2px solid #05420f;
        border-radius: 30px;
        font-size: 16px;
        outline: none;
        transition: all 0.3s;
    }
    
    .search-box:focus {
        border-color: #04320a;
        box-shadow: 0 0 10px rgba(5, 66, 15, 0.2);
    }
    
    .search-btn {
        margin-left: 10px;
        padding: 12px 25px;
        background-color: #05420f;
        color: white;
        border: none;
        border-radius: 30px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s;
    }
    
    .search-btn:hover {
        background-color: #04320a;
        transform: translateY(-2px);
    }
    
    h2 {
        text-align: center;
        color: #05420f;
        margin-bottom: 20px;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    th {
        background-color: #05420f;
        color: white;
        padding: 12px;
        text-align: left;
    }
    
    td {
        padding: 12px;
        border-bottom: 1px solid #ccc;
    }
    
    tr:hover {
        background-color: #d0e4d0;
    }
    
    .no-books {
        text-align: center;
        padding: 20px;
        color: #666;
    }
</style>

<div class="books-container">
  <div class="books-table">
    <h2>Available Books</h2>
    
    <!-- Search Form -->
    <div class="search-container">
      <form method="GET" action="" style="width: 100%; display: flex; justify-content: center;">
        <input type="text" name="search" class="search-box" placeholder="Search by ID, Book Name, Author or Department..." 
               value="<?= htmlspecialchars($search_query) ?>">
        <button type="submit" class="search-btn">Search</button>
      </form>
    </div>

    <?php if (count($books) > 0): ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Book Name</th>
            <th>Author</th>
            <th>Edition</th>
            <th>Status</th>
            <th>Quantity</th>
            <th>Department</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($books as $book): ?>
            <tr>
              <td><?= htmlspecialchars($book['Book_ID']) ?></td>
              <td><?= htmlspecialchars($book['Name_of_Book']) ?></td>
              <td><?= htmlspecialchars($book['Name_of_Author']) ?></td>
              <td><?= htmlspecialchars($book['Edition']) ?></td>
              <td><?= htmlspecialchars($book['Status']) ?></td>
              <td><?= htmlspecialchars($book['Quantity']) ?></td>
              <td><?= htmlspecialchars($book['Dept']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="no-books">No books found matching your search criteria.</p>
    <?php endif; ?>
  </div>
</div>

<?php include 'footer.php'; ?>