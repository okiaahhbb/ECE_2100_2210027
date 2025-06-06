<?php include 'Header.php'; ?>
<?php include 'connection.php'; ?>

<link rel="stylesheet" href="style.css"> 

<div class="feedback-container">
  <div class="feedback-box">
    <h2>📝 Feedback</h2>
    <p>If you have any suggestions or questions, please comment below.</p>

    <form action="" method="post">
      <input class="form-control" type="text" name="comment" placeholder="Write something..." required><br>
      <button class="btn btn-submit btn-block" type="submit" name="submit">Comment</button>
    </form>

    <div class="scroll">
      <?php
        if (isset($_POST['submit'])) {
          $comment = mysqli_real_escape_string($db, $_POST['comment']);
          $sql = "INSERT INTO `feedback` (comment) VALUES ('$comment')";
          mysqli_query($db, $sql);
        }

        $q = "SELECT * FROM `feedback` ORDER BY id DESC"; // This assumes `id` exists in the table
        $res = mysqli_query($db, $q);

        while ($row = mysqli_fetch_assoc($res)) {
          echo "<div class='comment-row'>📌 " . htmlspecialchars($row['comment']) . "</div>";
        }
      ?>
    </div>
  </div>
</div>

<?php include 'Footer.php'; ?>
