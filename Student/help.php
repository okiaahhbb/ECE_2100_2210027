<?php
require_once 'config2.php'; // session + db

// fetch admin list
$query = "SELECT id, username, email FROM admins"; // table name 'admins'
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Info</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4fff6;
      margin: 0;
      padding: 0;
      color: #1a2e22;
    }
    .container {
      max-width: 800px;
      margin: 60px auto;
      background: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(42, 89, 52, 0.1);
    }
    h2 {
      color: #2a5934;
      text-align: center;
      margin-bottom: 30px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 12px 15px;
      border-bottom: 1px solid #d4e9d6;
      text-align: left;
    }
    th {
      background-color: #2a5934;
      color: white;
    }
    tr:hover {
      background-color: #f0f8f1;
    }
    .back-btn {
      display: block;
      text-align: center;
      margin-top: 40px;
      background-color: #2a5934;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
    }
    .back-btn:hover {
      background-color: #4a8c5e;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>🛠️ Get help from our admins?</h2>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($admin = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= htmlspecialchars($admin['id']); ?></td>
            <td><?= htmlspecialchars($admin['username']); ?></td>
            <td><?= htmlspecialchars($admin['email']) ?? 'N/A'; ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p style="text-align: center; color: red;">No admin records found.</p>
  <?php endif; ?>

  <a href="dashboard.php" class="back-btn">⬅ Back to Dashboard</a>
</div>

</body>
</html>
