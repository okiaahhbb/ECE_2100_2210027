<?php
session_start();
require_once("config.php");

$alert_message = "";
$alert_type = "";
$username = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if (!$username || !$password) {
    $alert_message = "Please enter both username and password.";
    $alert_type = "fail";
  } else {
    
    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($admin_id, $stored_password);
    $user_exists = $stmt->fetch();
    $stmt->close();

    if ($user_exists && $password === $stored_password) {
      
      $_SESSION['admin_id'] = $admin_id;
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
  <style>
    /* modal popup basic style */
    #modalOverlay {
      display: none;
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
      z-index: 999;
    }
    #modalBox {
      background: #fff;
      padding: 20px 30px;
      border-radius: 8px;
      text-align: center;
      min-width: 250px;
      position: relative;
      animation: pop 0.3s ease;
    }
    #modalBox.fail {
      border: 2px solid #e74c3c;
      color: #e74c3c;
    }
    #modalCloseBtn {
      position: absolute;
      top: 8px;
      right: 12px;
      cursor: pointer;
      font-size: 20px;
      font-weight: bold;
    }
    @keyframes pop {
      from { transform: scale(0.8); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }
  </style>
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

  <!-- modal -->
  <div id="modalOverlay">
    <div id="modalBox" class="<?php echo htmlspecialchars($alert_type); ?>">
      <div id="modalCloseBtn">&times;</div>
      <p><?php echo htmlspecialchars($alert_message); ?></p>
    </div>
  </div>

  <script>
    // Modal show/hide logic
    const modalOverlay = document.getElementById('modalOverlay');
    const modalCloseBtn = document.getElementById('modalCloseBtn');
    <?php if (!empty($alert_message)) : ?>
      modalOverlay.style.display = 'flex';
    <?php endif; ?>

    modalCloseBtn.addEventListener('click', () => {
      modalOverlay.style.display = 'none';
    });
  </script>
</body>
</html>

