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
    $stmt = $conn->prepare("SELECT password FROM students WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    if ($stmt->fetch()) {
      if (password_verify($password, $hashed_password)) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit;
      } else {
        $alert_message = "Incorrect password.";
        $alert_type = "fail";
      }
    } else {
      $alert_message = "Username not found.";
      $alert_type = "fail";
    }
    $stmt->close();
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link rel="stylesheet" href="logincss.css" />
  <style>
    #modalOverlay {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
    }

    #modalBox {
      background-color: #fff;
      padding: 25px 30px;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.25);
      max-width: 400px;
      text-align: center;
      color: #222;
      position: relative;
    }

    #modalBox.success {
      border-left: 6px solid #4CAF50;
      color: #2a5934;
    }

    #modalBox.fail {
      border-left: 6px solid #f44336;
      color: #a80000;
    }

    #modalCloseBtn {
      position: absolute;
      top: 8px; right: 12px;
      font-size: 22px;
      font-weight: bold;
      color: #333;
      cursor: pointer;
      user-select: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Left Side with SVG -->
    <div class="left-panel">
      <div class="svg-placeholder">
        <img src="Images/loginsvg.svg" alt="Illustration" />
      </div>
      <p class="credit">© 2025 RUET Library</p>
    </div>

    <!-- Right Side with Login Form -->
    <div class="right-panel">
      <div class="login-box">
        <h2 class="centered">Login</h2>

        <form method="POST" action="">
          <label for="username">Username</label>
          <input type="text" name="username" id="username" placeholder="Enter your username" required
            value="<?php echo htmlspecialchars($username ?? '') ?>" />

          <label for="password">Password</label>
          <input type="password" name="password" id="password" placeholder="Enter your password" required />

          <div class="link-row">
            <a href="#">Forgot Password?</a>
            <a href="#">Terms and Conditions</a>
          </div>

          <button type="submit">Login</button>
        </form>

        <p class="register">Don't have an account? <a href="registration.php">Register Now</a></p>
        <p class="contact">
          Need help? <br />
          <a href="mailto:support@ruet.edu.bd">support@ruet.edu.bd</a>
        </p>
      </div>
    </div>
  </div>

  <!-- Modal Popup -->
  <div id="modalOverlay">
    <div id="modalBox" class="<?php echo htmlspecialchars($alert_type); ?>">
      <div id="modalCloseBtn">&times;</div>
      <p><?php echo htmlspecialchars($alert_message); ?></p>
    </div>
  </div>

  <script>
    const modalOverlay = document.getElementById('modalOverlay');
    const modalCloseBtn = document.getElementById('modalCloseBtn');

    <?php if ($alert_message): ?>
      modalOverlay.style.display = 'flex';

      modalCloseBtn.addEventListener('click', () => {
        modalOverlay.style.display = 'none';
      });

      modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) {
          modalOverlay.style.display = 'none';
        }
      });
    <?php endif; ?>
  </script>
</body>
</html>
