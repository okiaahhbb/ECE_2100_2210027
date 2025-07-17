<?php
require_once "config3.php";
$student_id = 1;

$sql_current = "SELECT b.book_id, b.book_name, b.book_pic, br.requested_at, br.due_date, br.request_id
                FROM borrow_requests br
                JOIN books b ON br.book_id = b.book_id
                WHERE br.student_id = ? AND br.status = 'approved' AND br.returned_at IS NULL";
$stmt = $conn->prepare($sql_current);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$currentBooks = $stmt->get_result();

$sql_history = "SELECT b.book_name, b.book_pic, br.requested_at, br.returned_at
                FROM borrow_requests br
                JOIN books b ON br.book_id = b.book_id
                WHERE br.student_id = ? AND br.status = 'approved' AND br.returned_at IS NOT NULL
                ORDER BY br.returned_at DESC";
$stmt2 = $conn->prepare($sql_history);
$stmt2->bind_param("i", $student_id);
$stmt2->execute();
$historyBooks = $stmt2->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return_id'])) {
    $rid = intval($_POST['return_id']);
    $today = date('Y-m-d');

    $update = $conn->prepare("UPDATE borrow_requests SET returned_at=? WHERE request_id=?");
    $update->bind_param("si", $today, $rid);

    if ($update->execute()) {
        // quantity বাড়ানোর জন্য borrow_requests থেকে book_id বের কর
        $getBookId = $conn->prepare("SELECT book_id FROM borrow_requests WHERE request_id=?");
        $getBookId->bind_param("i", $rid);
        $getBookId->execute();
        $result = $getBookId->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $book_id = $row['book_id'];
            $incQuantity = $conn->prepare("UPDATE books SET quantity = quantity + 1 WHERE book_id = ?");
            $incQuantity->bind_param("i", $book_id);
            $incQuantity->execute();
        }

        header("Location: borrow_history.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Borrow History</title>
  <style>
    :root {
      --green:#2a5934;
      --light:#f1f8f2;
      --white:#fff;
      --shadow:0 4px 10px rgba(0,0,0,0.1);
    }
    body {
      margin: 0;
      font-family: Segoe UI, Arial, sans-serif;
      background: #f8f8f8;
      color: #333;
    }
    nav {
      background: var(--green);
      color: var(--white);
      padding: 15px 25px;
      font-size: 20px;
      font-weight: bold;
      text-align: center;
    }
    h2 {
      text-align: center;
      margin: 40px 0 20px;
      font-size: 26px;
      color: var(--green);
    }
    .section {
      padding: 20px 5%;
    }
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
      gap: 25px;
    }
    .history-card {
      background: #fff8e1;
      padding: 15px;
      border-radius: 10px;
      box-shadow: var(--shadow);
      text-align: center;
    }
    .history-card img {
      height: 100px;
      margin-bottom: 10px;
    }
    .return-btn {
      background: var(--green);
      color: var(--white);
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s;
    }
    .return-btn:hover {
      background: #3d8051;
    }
    .bottom-bar {
      display: flex;
      justify-content: flex-end;
      padding: 20px;
    }
    .back-btn {
      background: #555;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      box-shadow: var(--shadow);
      transition: background 0.3s;
    }
    .back-btn:hover {
      background: #333;
    }
    .info {
      font-size: 14px;
      margin-top: 8px;
      color: #555;
    }
    .due-soon {
      color: #c62828;
      font-weight: bold;
    }
  </style>
</head>
<body>
<nav>Borrow History</nav>

<section class="section">
  <h2>Currently Borrowed Books</h2>
  <div class="grid">
    <?php if ($currentBooks->num_rows > 0): ?>
      <?php while ($row = $currentBooks->fetch_assoc()): ?>
        <?php
          $due = new DateTime($row['due_date']);
          $today = new DateTime();
          $interval = $today->diff($due);
          $daysLeft = (int)$interval->format('%r%a');

          if ($daysLeft > 1) {
              $dueText = "$daysLeft days left";
              $dueClass = "";
          } elseif ($daysLeft == 1) {
              $dueText = "Due tomorrow";
              $dueClass = "due-soon";
          } elseif ($daysLeft == 0) {
              $dueText = "Due today";
              $dueClass = "due-soon";
          } else {
              $dueText = "Overdue by " . abs($daysLeft) . " day(s)";
              $dueClass = "due-soon";
          }
        ?>
        <div class="history-card">
          <img src="Images/<?php echo htmlspecialchars($row['book_pic']); ?>" alt="book">
          <div><?php echo htmlspecialchars($row['book_name']); ?></div>
          <div class="info <?php echo $dueClass; ?>">
            Due: <?php echo date('d M Y', strtotime($row['due_date'])); ?><br>
            <strong><?php echo $dueText; ?></strong>
          </div>
          <form method="post" style="margin-top:10px;">
            <input type="hidden" name="return_id" value="<?php echo $row['request_id']; ?>">
            <button class="return-btn">Return Now</button>
          </form>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="grid-column:1/-1;text-align:center;">No books currently borrowed.</p>
    <?php endif; ?>
  </div>
</section>

<section class="section">
  <h2>Previous Borrow History</h2>
  <div class="grid">
    <?php if ($historyBooks->num_rows > 0): ?>
      <?php while ($row = $historyBooks->fetch_assoc()): ?>
        <div class="history-card">
          <img src="Images/<?php echo htmlspecialchars($row['book_pic']); ?>" alt="book">
          <div><?php echo htmlspecialchars($row['book_name']); ?></div>
          <small>Taken: <?php echo date('d M Y', strtotime($row['requested_at'])); ?></small><br>
          <small>Returned: <?php echo date('d M Y', strtotime($row['returned_at'])); ?></small>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="grid-column:1/-1;text-align:center;">No borrow history found.</p>
    <?php endif; ?>
  </div>
</section>

<div class="bottom-bar">
  <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
</div>

</body>
</html>
