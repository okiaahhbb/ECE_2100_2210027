<?php include 'Header.php'; ?>
<?php include 'connection.php'; ?>

<link rel="stylesheet" href="style.css">

<div class="feedback-container">
  <div class="feedback-box">
    <h2>📢 Admin Feedback Panel</h2>

    <?php
      if (isset($_POST['reply_submit'])) {
        $id = $_POST['feedback_id'];
        $reply = mysqli_real_escape_string($db, $_POST['reply']);
        $update = "UPDATE feedback SET reply='$reply' WHERE id=$id";
        mysqli_query($db, $update);
      }

      $res = mysqli_query($db, "SELECT * FROM feedback ORDER BY id DESC");

      while ($row = mysqli_fetch_assoc($res)) {
        echo "<div class='comment-row'>";
        echo "<strong>📌 " . htmlspecialchars($row['comment']) . "</strong><br>";

        if (!empty($row['reply'])) {
          echo "<span style='color:green; margin-left:20px;'>↪ Admin: " . htmlspecialchars($row['reply']) . "</span><br>";
        } else {
          echo "
            <form method='post'>
              <input type='hidden' name='feedback_id' value='{$row['id']}'>
              <input class='form-control' type='text' name='reply' placeholder='Write reply...' required>
              <button class='btn-submit' type='submit' name='reply_submit'>Reply</button>
            </form>
          ";
        }

        echo "</div>";
      }
    ?>
  </div>
</div>

<?php include 'Footer.php'; ?>

