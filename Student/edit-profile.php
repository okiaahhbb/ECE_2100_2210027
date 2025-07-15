<?php
require_once 'config2.php'; // login check + db connection

// fetch current user from session
$user = getCurrentUser($conn);

// Handle update
$successMsg = "";
$errorMsg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $phone     = trim($_POST['phone']);
    $email     = trim($_POST['email']);
    $department = trim($_POST['department']);

    if ($full_name && $phone && $email && $department) {
        $stmt = $conn->prepare("UPDATE students SET full_name=?, phone=?, email=?, department=?, updated_at=NOW() WHERE student_id=?");
        $stmt->bind_param("ssssi", $full_name, $phone, $email, $department, $_SESSION['student_id']);
        if ($stmt->execute()) {
            $successMsg = "✅ Profile updated successfully!";
            // refresh $user
            $user = getCurrentUser($conn);
        } else {
            $errorMsg = "❌ Something went wrong. Try again.";
        }
    } else {
        $errorMsg = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profile</title>
<style>
:root {
  --primary-green: #2a5934;
  --primary-light: #e8f3e8;
  --primary-dark: #1c3d24;
  --accent-color: #4a8c5e;
  --text-dark: #1a2e22;
  --text-light: #5a7260;
  --white: #ffffff;
  --shadow-md: 0 4px 12px rgba(42, 89, 52, 0.15);
}

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
  background: var(--primary-light);
  color: var(--text-dark);
}

.container {
  max-width: 600px;
  background: var(--white);
  margin: 50px auto;
  padding: 30px 40px;
  border-radius: 12px;
  box-shadow: var(--shadow-md);
}

h1 {
  text-align: center;
  color: var(--primary-green);
  margin-bottom: 30px;
}

form label {
  display: block;
  margin-top: 20px;
  font-weight: bold;
  color: var(--primary-dark);
}

form input, form select {
  width: 100%;
  padding: 10px;
  margin-top: 8px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 15px;
}

button {
  margin-top: 30px;
  width: 100%;
  padding: 12px;
  background: var(--primary-green);
  color: var(--white);
  font-size: 16px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s ease;
}
button:hover {
  background: var(--accent-color);
}

.msg {
  margin-top: 20px;
  text-align: center;
  font-weight: bold;
}
.msg.success { color: green; }
.msg.error { color: red; }

.back-link {
  display: block;
  margin-top: 20px;
  text-align: center;
  color: var(--accent-color);
  text-decoration: none;
  font-weight: bold;
}
.back-link:hover {
  text-decoration: underline;
}
</style>
</head>
<body>
<div class="container">
  <h1>Edit Your Profile</h1>

  <?php if ($successMsg): ?>
    <div class="msg success"><?= $successMsg ?></div>
  <?php elseif ($errorMsg): ?>
    <div class="msg error"><?= $errorMsg ?></div>
  <?php endif; ?>

  <form method="POST">
    <label>Full Name:</label>
    <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']); ?>" required>

    <label>Phone:</label>
    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']); ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>

    <label>Department:</label>
    <select name="department" required>
      <option value="CSE" <?= ($user['department']=='CSE'?'selected':''); ?>>CSE</option>
      <option value="ECE" <?= ($user['department']=='ECE'?'selected':''); ?>>ECE</option>
      <option value="CIVIL" <?= ($user['department']=='CIVIL'?'selected':''); ?>>CIVIL</option>
      <option value="ME" <?= ($user['department']=='ME'?'selected':''); ?>>ME</option>
    </select>

    <button type="submit">Update</button>
  </form>

  <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
</div>
</body>
</html>


