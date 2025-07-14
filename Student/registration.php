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
    $full_name = trim($_POST['full_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $roll = trim($_POST['roll'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$full_name || !$username || !$email || !$roll || !$password) {
        $alert_message = "Please fill all required fields.";
        $alert_type = "fail";
    } else {
        $check_stmt = $conn->prepare("SELECT COUNT(*) FROM students WHERE username=? OR roll=? OR email=?");
        $check_stmt->bind_param("sss", $username, $roll, $email);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($count > 0) {
            $alert_message = "Username, Roll, or Email already exists. Please try another.";
            $alert_type = "fail";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_stmt = $conn->prepare("INSERT INTO students (full_name, roll, username, password, department, phone, email) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("sssssss", $full_name, $roll, $username, $hashed_password, $department, $phone, $email);

            if ($insert_stmt->execute()) {
                $alert_message = "Registration successful! You can now login.";
                $alert_type = "success";
                // Clear form values after success
                $full_name = $username = $email = $phone = $department = $roll = '';
            } else {
                $alert_message = "Error during registration: " . $conn->error;
                $alert_type = "fail";
            }
            $insert_stmt->close();
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
  <title>Register</title>
  <style>
    /* Root colors */
    :root {
      --primary-green: #2a5934;
      --primary-light: #e8f3e8;
      --primary-dark: #1c3d24;
      --accent-color: #4a8c5e;
      --text-dark: #1a2e22;
      --text-light: #5a7260;
      --white: #ffffff;
      --shadow-sm: 0 2px 8px rgba(42, 89, 52, 0.1);
      --shadow-md: 0 4px 12px rgba(42, 89, 52, 0.15);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", sans-serif;
    }

    body {
      background: var(--primary-dark);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    /* Navbar */
    .navbar {
      position: fixed;
      top: 0; left: 0; right: 0;
      background: var(--primary-green);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 30px;
      color: var(--white);
      font-weight: 600;
      z-index: 999;
    }
    .navbar .logo {
      font-size: 24px;
    }
    .nav-links a {
      color: var(--white);
      text-decoration: none;
      margin-left: 20px;
      font-weight: 500;
      transition: color 0.3s ease;
    }
    .nav-links a:hover {
      color: var(--accent-color);
    }

    /* Container */
    .container {
      margin-top: 70px; /* for navbar space */
      display: flex;
      width: 90%;
      max-width: 1000px;
      height: 600px;
      background: var(--primary-green);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: var(--shadow-md);
    }

    /* Left Panel (SVG) */
    .left-panel {
      flex: 1;
      background: var(--primary-light);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      position: relative;
    }
    .svg-placeholder img {
      width: 80%;
      max-width: 350px;
    }
    .credit {
      position: absolute;
      bottom: 15px;
      font-size: 12px;
      color: var(--text-light);
    }

    /* Right Panel (Form) */
    .right-panel {
      flex: 1;
      background: var(--primary-dark);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-box {
      width: 80%;
      max-width: 370px;
      padding: 20px;
      color: var(--white);
    }

    .login-box h2.centered {
      margin-bottom: 20px;
      text-align: center;
      color: var(--primary-light);
    }

    .login-box label {
      display: block;
      margin-top: 15px;
      font-weight: 500;
      color: var(--text-light);
    }

    .login-box input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 8px;
      border: 1px solid var(--accent-color);
      background: var(--primary-green);
      color: var(--white);
    }

    .login-box input::placeholder {
      color: #cbe5d1;
    }

    .login-box button {
      width: 100%;
      padding: 12px;
      background: var(--accent-color);
      border: none;
      color: white;
      border-radius: 8px;
      margin-top: 20px;
      font-size: 16px;
      cursor: pointer;
      box-shadow: var(--shadow-sm);
      transition: background 0.3s ease;
    }

    .login-box button:hover {
      background: #3c7c52;
    }

    .register,
    .contact {
      margin-top: 15px;
      font-size: 13px;
      color: var(--primary-light);
      text-align: center;
    }

    .register a,
    .contact a {
      color: #afffd2;
      text-decoration: none;
    }


    /* Modal styles */
    #modalOverlay {
      display: none;
      position: fixed;
      z-index: 10000;
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
      font-family: Arial, sans-serif;
      position: relative;
      color: #222; /* dark text */
    }
    #modalBox.success {
      border-left: 6px solid #4CAF50;
      color: #2a5934; /* dark green */
    }
    #modalBox.fail {
      border-left: 6px solid #f44336;
      color: #a80000; /* dark red */
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

  <!-- Navbar -->
  <div class="navbar">
    <div class="logo">📘 Booksy</div>
    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="collection.php">Collections</a>
      <a href="login.php">Login</a>
      <a href="feedback.php">Feedback</a>
    </div>
  </div>

  <div class="container">
    <div class="right-panel">
      <div class="login-box">
        <h2 class="centered">Create Account</h2>

        <form action="" method="POST" id="registrationForm">

          <label for="name">Full Name</label>
          <input type="text" id="name" name="full_name" placeholder="Enter your full name" required
            value="<?php echo htmlspecialchars($full_name ?? '') ?>" />

          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Choose a username" required
            value="<?php echo htmlspecialchars($username ?? '') ?>" />

          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" required
            value="<?php echo htmlspecialchars($email ?? '') ?>" />

          <label for="phone">Phone Number</label>
          <input type="tel" id="phone" name="phone" placeholder="Enter your phone number"
            value="<?php echo htmlspecialchars($phone ?? '') ?>" />

          <label for="dept">Department</label>
          <input type="text" id="dept" name="department" placeholder="e.g., CSE, EEE, ME"
            value="<?php echo htmlspecialchars($department ?? '') ?>" />

          <label for="roll">Roll Number</label>
          <input type="text" id="roll" name="roll" placeholder="Enter your roll number" required
            value="<?php echo htmlspecialchars($roll ?? '') ?>" />

          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Create a password" required />

          <button type="submit">Register</button>
        </form>

        <p class="register">Already have an account? <a href="login.php">Login Here</a></p>
        <p class="contact">
          Need help? <br />
          <a href="mailto:support@ruet.edu.bd">support@ruet.edu.bd</a>
        </p>
      </div>
    </div>

    <div class="left-panel">
      <div class="svg-placeholder">
        <img src="Images/registration.svg" alt="Illustration" />
      </div>
      <p class="credit">© 2025 RUET Library</p>
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
      // Show modal
      modalOverlay.style.display = 'flex';

      // Close modal on clicking X
      modalCloseBtn.addEventListener('click', () => {
        modalOverlay.style.display = 'none';
      });

      // Also close modal on clicking outside modalBox
      modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) {
          modalOverlay.style.display = 'none';
        }
      });
    <?php endif; ?>
  </script>

</body>
</html>










