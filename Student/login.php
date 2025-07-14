<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "booksy";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$alert_message = "";
$alert_type = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $alert_message = "Please enter both username and password.";
        $alert_type = "fail";
    } else {
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT student_id, username, full_name, roll, department, password FROM students WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['student_id'] = $user['student_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['roll'] = $user['roll'];
                $_SESSION['department'] = $user['department'];
                
                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();
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
  <title>Login - Booksy</title>
  <style>
    :root {
      --primary-green: #2a5934;
      --primary-light: #e8f3e8;
      --primary-dark: #1c3d24;
      --accent-color: #4a8c5e;
      --text-dark: #1a2e22;
      --white: #ffffff;
      --shadow-sm: 0 2px 8px rgba(42, 89, 52, 0.1);
      --radius: 8px;
    }
    
    body {
      background-color: var(--primary-dark);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
    }
    
    .container {
      display: flex;
      width: 90%;
      max-width: 1000px;
      background-color: var(--primary-green);
      border-radius: var(--radius);
      overflow: hidden;
      box-shadow: var(--shadow-sm);
    }
    
    .left-panel {
      flex: 1;
      background-color: var(--primary-light);
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }
    
    .left-panel img {
      max-width: 100%;
      height: auto;
    }
    
    .right-panel {
      flex: 1;
      padding: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    
    .login-box {
      width: 100%;
      max-width: 350px;
      color: var(--white);
    }
    
    .login-box h2 {
      text-align: center;
      margin-bottom: 30px;
      color: var(--primary-light);
    }
    
    .login-box input {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border-radius: var(--radius);
      border: 1px solid var(--accent-color);
      background-color: var(--primary-dark);
      color: var(--white);
    }
    
    .login-box button {
      width: 100%;
      padding: 12px;
      background-color: var(--accent-color);
      color: var(--white);
      border: none;
      border-radius: var(--radius);
      cursor: pointer;
      font-weight: 600;
      margin-top: 10px;
    }
    
    .login-box button:hover {
      background-color: #3c7c52;
    }
    
    .link-row {
      display: flex;
      justify-content: space-between;
      margin: 15px 0;
      font-size: 14px;
    }
    
    .link-row a {
      color: var(--primary-light);
      text-decoration: none;
    }
    
    .register {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
    }
    
    .register a {
      color: #afffd2;
      text-decoration: none;
    }
    
    /* Modal Styles */
    #modalOverlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }
    
    #modalBox {
      background-color: var(--white);
      padding: 25px 30px;
      border-radius: 12px;
      max-width: 400px;
      text-align: center;
      position: relative;
    }
    
    #modalBox.success {
      border-left: 6px solid #4CAF50;
    }
    
    #modalBox.fail {
      border-left: 6px solid #f44336;
    }
    
    #modalCloseBtn {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 24px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="left-panel">
      <img src="Images/loginsvg.svg" alt="Login Illustration">
    </div>
    
    <div class="right-panel">
      <div class="login-box">
        <h2>Login to Booksy</h2>
        
        <form method="POST" action="">
          <input type="text" name="username" placeholder="Username" required>
          <input type="password" name="password" placeholder="Password" required>
          
          <div class="link-row">
            <a href="#">Forgot Password?</a>
            <a href="#">Terms & Conditions</a>
          </div>
          
          <button type="submit">Login</button>
        </form>
        
        <p class="register">Don't have an account? <a href="registration.php">Register Now</a></p>
      </div>
    </div>
  </div>

  <!-- Modal for Alerts -->
  <div id="modalOverlay">
    <div id="modalBox" class="<?php echo htmlspecialchars($alert_type); ?>">
      <div id="modalCloseBtn">&times;</div>
      <p><?php echo htmlspecialchars($alert_message); ?></p>
    </div>
  </div>

  <script>
    // Show modal if there's an alert message
    <?php if ($alert_message): ?>
      document.getElementById('modalOverlay').style.display = 'flex';
      
      // Close modal when clicking X or outside
      document.getElementById('modalCloseBtn').addEventListener('click', function() {
        document.getElementById('modalOverlay').style.display = 'none';
      });
      
      document.getElementById('modalOverlay').addEventListener('click', function(e) {
        if (e.target === this) {
          this.style.display = 'none';
        }
      });
    <?php endif; ?>
  </script>
</body>
</html>