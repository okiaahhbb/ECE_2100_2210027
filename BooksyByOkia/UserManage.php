<?php
session_start();
require_once("config.php");

// admin logged in check
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

// delete student if remove clicked
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: UserManage.php?removed=1");
    exit();
}

// fetch all students
$sql = "SELECT student_id, full_name, roll, username, department, phone, email FROM students ORDER BY created_at DESC";
$result = $conn->query($sql);

// random profile images
$profilePics = ["Images/Person1.svg", "Images/Person2.svg", "Images/Person3.svg"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Manage</title>
<style>
body {
  margin:0; padding:0;
  font-family: 'Segoe UI', sans-serif;
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
  z-index:1000;
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
.user-grid {
  display:grid;
  grid-template-columns:repeat(auto-fit, minmax(250px,1fr));
  gap:25px;
  margin-top:20px;
}
.user-card {
  background:#fff;
  border-radius:12px;
  box-shadow:0 4px 12px rgba(0,0,0,0.08);
  padding:20px;
  text-align:center;
  transition:transform 0.3s;
}
.user-card:hover {
  transform:scale(1.03);
}
.user-card img {
  width:80px;
  height:80px;
  border-radius:50%;
  margin-bottom:10px;
  object-fit:cover;
  background:#eee;
}
.user-info {
  font-size:14px;
  line-height:1.5;
  margin-bottom:10px;
}
.remove-btn {
  background:#e74c3c;
  border:none;
  color:#fff;
  padding:8px 12px;
  border-radius:6px;
  font-weight:bold;
  cursor:pointer;
}
.remove-btn:hover {
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
  <div>👤 User Management</div>
  <div>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="logout.php">Logout</a>
  </div>
</div>

<div class="popup" id="popup">✅ Student removed successfully!</div>

<div class="container">
  <h2>All Registered Students</h2>
  <div class="user-grid">
    <?php while($row = $result->fetch_assoc()): ?>
      <?php 
        // choose random profile pic
        $pic = $profilePics[array_rand($profilePics)];
      ?>
      <div class="user-card">
        <img src="<?php echo $pic; ?>" alt="Profile">
        <div class="user-info">
          <strong>Name:</strong> <?php echo htmlspecialchars($row['full_name']); ?><br>
          <strong>Roll:</strong> <?php echo htmlspecialchars($row['roll']); ?><br>
          <strong>Username:</strong> <?php echo htmlspecialchars($row['username']); ?><br>
          <strong>Dept:</strong> <?php echo htmlspecialchars($row['department']); ?><br>
          <strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?><br>
          <strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?>
        </div>
        <form method="GET" onsubmit="return confirm('Are you sure to remove this student?');">
          <input type="hidden" name="delete" value="<?php echo $row['student_id']; ?>">
          <button class="remove-btn" type="submit">Remove</button>
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

