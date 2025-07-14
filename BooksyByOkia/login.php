<?php
session_start();

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "booksy";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$alert_message = "";
$alert_type = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if (!$username || !$password) {
    $alert_message = "Please enter both username and password.";
    $alert_type = "fail";
  } else {
    $stmt = $conn->prepare("SELECT password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($stored_password);
    $user_exists = $stmt->fetch();
    $stmt->close();

    if ($user_exists && $password === $stored_password) {
      $_SESSION['admin_username'] = $username;
      header("Location: admin_dashboard.php");
      exit;
    } else {
      $alert_message = "Incorrect username or password.";
      $alert_type = "fail";
    }
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Login</title>
  <link rel="stylesheet" href="admin_login.css" />
</head>
<body>
  <div class="container">
    <div class="left-panel">
      <div class="svg-placeholder">
        <img src="Images/loginsvg.svg" alt="Illustration" />
      </div>
      <p class="credit">© 2025 RUET Library</p>
    </div>

    <div class="right-panel">
      <div class="login-box">
        <h2 class="centered">Admin Login</h2>

        <form method="POST" action="">
          <label for="username">Username</label>
          <input type="text" name="username" id="username" placeholder="Enter your username" required value="<?php echo htmlspecialchars($username ?? '') ?>" />

          <label for="password">Password</label>
          <input type="password" name="password" id="password" placeholder="Enter your password" required />

          <div class="link-row">
            <a href="#">Forgot Password?</a>
            <a href="#">Terms and Conditions</a>
          </div>

          <p style="color: var(--accent-color); font-size: 14px; margin-bottom: 10px; text-align: center;">
            Only authorized admin users may login here.
          </p>

          <button type="submit">Login</button>
        </form>

        <p class="contact">
          Need help? <br />
          <a href="mailto:support@ruet.edu.bd">support@ruet.edu.bd</a>
        </p>
      </div>
    </div>
  </div>

  <div id="modalOverlay">
    <div id="modalBox" class="<?php echo htmlspecialchars($alert_type); ?>">
      <div id="modalCloseBtn">&times;</div>
      <p><?php echo htmlspecialchars($alert_message); ?></p>
    </div>
  </div>
</body>
</html>


