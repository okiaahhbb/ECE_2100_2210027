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
          $sql = "INSERT INTO feedback (comment) VALUES ('$comment')";
          mysqli_query($db, $sql);
        }

        $res = mysqli_query($db, "SELECT * FROM feedback ORDER BY id DESC");

        while ($row = mysqli_fetch_assoc($res)) {
          echo "<div class='comment-row'>";
          echo "📌 <strong>" . htmlspecialchars($row['comment']) . "</strong><br>";
          if (!empty($row['reply'])) {
            echo "<span style='color:green; margin-left:20px;'>↪ Admin: " . htmlspecialchars($row['reply']) . "</span>";
          }
          echo "</div>";
        }
      ?>
    </div>
  </div>
</div>

<?php include 'Footer.php'; ?>

