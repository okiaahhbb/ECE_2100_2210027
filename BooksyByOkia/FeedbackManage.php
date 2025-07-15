<?php
session_start();
require_once("config.php");

// Admin login check
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

// delete feedback if requested
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM feedbacks WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: FeedbackManage.php?removed=1");
    exit();
}

// fetch all feedbacks
$sql = "SELECT id, name, feedback, is_anonymous, created_at FROM feedbacks ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Feedback Manage</title>
<style>
body {
  margin:0; padding:0;
  font-family:'Segoe UI', sans-serif;
  background:#f6f8f9;
}
.navbar {
  background:#2a5934;
  color:#fff;
  padding:15px 25px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  position:sticky;
  top:0;
}
.navbar a {
  color:#fff;
  text-decoration:none;
  margin-left:20px;
  font-weight:bold;
}
.container {
  padding:30px;
}
h2 {
  color:#2a5934;
}
.feedback-grid {
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
  gap:20px;
  margin-top:20px;
}
.card {
  background:#fff;
  border-radius:12px;
  box-shadow:0 4px 12px rgba(0,0,0,0.08);
  padding:20px;
  position:relative;
  transition:transform 0.3s;
}
.card:hover {
  transform:scale(1.02);
}
.card .name {
  font-weight:bold;
  font-size:16px;
  margin-bottom:8px;
  color:#2a5934;
}
.card .feedback {
  font-size:14px;
  margin-bottom:12px;
  color:#444;
  line-height:1.4;
}
.card .time {
  font-size:12px;
  color:#777;
  margin-bottom:10px;
}
.delete-btn {
  background:#e74c3c;
  border:none;
  color:#fff;
  padding:6px 12px;
  border-radius:6px;
  font-weight:bold;
  cursor:pointer;
}
.delete-btn:hover {
  background:#c0392b;
}
.popup {
  position:fixed;
  top:20px;
  left:50%;
  transform:translateX(-50%);
  background:#2a5934;
  color:#fff;
  padding:10px 20px;
  border-radius:8px;
  font-weight:bold;
  display:none;
  z-index:9999;
}
</style>
</head>
<body>
<div class="navbar">
  <div>📝 Feedback Management</div>
  <div>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="logout.php">Logout</a>
  </div>
</div>

<div class="popup" id="popup">✅ Feedback deleted successfully!</div>

<div class="container">
  <h2>All Feedbacks</h2>
  <div class="feedback-grid">
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="card">
        <div class="name">
          <?php echo $row['is_anonymous'] ? "Anonymous" : htmlspecialchars($row['name']); ?>
        </div>
        <div class="feedback">
          <?php echo nl2br(htmlspecialchars($row['feedback'])); ?>
        </div>
        <div class="time">Submitted: <?php echo $row['created_at']; ?></div>
        <form method="GET" onsubmit="return confirm('Are you sure to delete this feedback?');">
          <input type="hidden" name="delete" value="<?php echo $row['id']; ?>">
          <button class="delete-btn" type="submit">Delete</button>
        </form>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<script>
  const popup = document.getElementById('popup');
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('removed') === '1') {
    popup.style.display = 'block';
    setTimeout(()=>{popup.style.display='none';}, 3000);
  }
</script>
</body>
</html>
