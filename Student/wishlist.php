<?php
include 'header.php';
include('connection.php');

// Replace with session ID
$student_id = 1;

$sql = "SELECT b.title, w.added_on 
        FROM wishlist w
        JOIN books b ON w.book_id = b.id
        WHERE w.student_id = $student_id";

$result = mysqli_query($db, $sql);
?>

<style>
  body {
    background-color: #c5d5c5;
  }

  .wishlist-container {
    max-width: 800px;
    margin: 60px auto;
    background-color: #e9f5e9;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
  }

  .wishlist-container h2 {
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

<div class="wishlist-container">
  <h2>🌟 Wishlist</h2>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <table>
      <tr>
        <th>Book Title</th>
        <th>Added On</th>
      </tr>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['title']); ?></td>
          <td><?php echo $row['added_on']; ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>
    <div class="no-data">Your wishlist is empty.</div>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
