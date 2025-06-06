<?php include 'header.php'; ?>
<?php
session_start();
include('connection.php'); 

$student_id = $_SESSION['login_user'] ?? null;

if (!$student_id) {
    echo "<p style='color: red; text-align: center;'>Please login to view your currently reading books.</p>";
    include 'footer.php';
    exit;
}

$sql = "SELECT b.Book_ID, b.Name_of_Book, b.Name_of_Author, b.Edition, bb.borrow_date, bb.due_date 
        FROM borrowed_books bb 
        JOIN books b ON bb.book_id = b.Book_ID 
        WHERE bb.student_id = '$student_id' AND bb.return_date IS NULL";

$result = mysqli_query($db, $sql);
?>

<style>
  body {
    background-color: #c5d5c5;
  }

  .reading-container {
    max-width: 800px;
    margin: 60px auto;
    background-color: #e9f5e9;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
  }

  .reading-container h2 {
    color: #05420f;
    text-align: center;
    margin-bottom: 25px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  th, td {
    padding: 12px;
    border: 1px solid #ccc;
    text-align: center;
  }

  th {
    background-color: #05420f;
    color: white;
  }

  td {
    background-color: #f9fff9;
  }

  .no-data {
    text-align: center;
    font-size: 18px;
    color: #777;
    margin-top: 20px;
  }
</style>

<div class="reading-container">
  <h2>📖 Currently Reading</h2>

  <?php if ($result && mysqli_num_rows($result) > 0): ?>
    <table>
      <tr>
        <th>Book Title</th>
        <th>Author</th>
        <th>Edition</th>
        <th>Borrow Date</th>
        <th>Due Date</th>
      </tr>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= htmlspecialchars($row['Name_of_Book']) ?></td>
          <td><?= htmlspecialchars($row['Name_of_Author']) ?></td>
          <td><?= $row['Edition'] ?></td>
          <td><?= $row['borrow_date'] ?></td>
          <td><?= $row['due_date'] ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>
    <div class="no-data">No books currently being read.</div>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
