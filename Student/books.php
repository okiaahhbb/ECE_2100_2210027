<?php include 'header.php'; ?>
<?php
include('connection.php'); // adjust path if needed

$books = [];
$result = mysqli_query($db, "SELECT * FROM books");

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }
}
?>

<div class="books-container" style="flex: 1; padding: 40px 60px;">
  <div class="books-table" style="width: 100%; background-color: #e9f5e9; border-radius: 10px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; color: #05420f; margin-bottom: 20px;">Available Books</h2>

    <?php if (count($books) > 0): ?>
      <table style="width: 100%; border-collapse: collapse;">
        <thead>
          <tr style="background-color: #05420f; color: white;">
            <th style="padding: 12px; border-bottom: 1px solid #ccc;">ID</th>
            <th style="padding: 12px; border-bottom: 1px solid #ccc;">Book Name</th>
            <th style="padding: 12px; border-bottom: 1px solid #ccc;">Author</th>
            <th style="padding: 12px; border-bottom: 1px solid #ccc;">Edition</th>
            <th style="padding: 12px; border-bottom: 1px solid #ccc;">Status</th>
            <th style="padding: 12px; border-bottom: 1px solid #ccc;">Quantity</th>
            <th style="padding: 12px; border-bottom: 1px solid #ccc;">Department</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($books as $book): ?>
            <tr style="border-bottom: 1px solid #ccc;" onmouseover="this.style.background='#d0e4d0'" onmouseout="this.style.background='transparent'">
              <td style="padding: 12px;"><?= $book['Book_ID'] ?></td>
              <td style="padding: 12px;"><?= $book['Name_of_Book'] ?></td>
              <td style="padding: 12px;"><?= $book['Name_of_Author'] ?></td>
              <td style="padding: 12px;"><?= $book['Edition'] ?></td>
              <td style="padding: 12px;"><?= $book['Status'] ?></td>
              <td style="padding: 12px;"><?= $book['Quantity'] ?></td>
              <td style="padding: 12px;"><?= $book['Dept'] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p style="text-align: center;">No books available in the library right now.</p>
    <?php endif; ?>
  </div>
</div>

<?php include 'footer.php'; ?>

