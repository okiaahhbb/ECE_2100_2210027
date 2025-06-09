<?php
session_start();
include('Header.php');
include('connection.php');

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $db->prepare("SELECT * FROM admin WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        
        // Plain-text password check
        if($password === $admin['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            header("Location: admin_dashboard.php");
            exit();
        }
    }

    $message = "Invalid username or password";
}
?>

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }

    .content-wrapper {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .login-container {
        width: 400px;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin: 20px 0;
    }

    .login-container h1 {
        font-size: 24px;
        margin-bottom: 15px;
        color: #05420f;
        font-weight: bold;
    }

    .login-container h2 {
        font-size: 18px;
        margin-bottom: 25px;
        color: #555;
    }

    .form-control {
        height: 40px;
        margin-bottom: 15px;
        font-size: 14px;
        width: 100%;
        padding: 0 10px;
    }

    .btn-login {
        width: 100%;
        padding: 8px;
        font-size: 14px;
        background-color: #05420f;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .login-links {
        margin-top: 15px;
        font-size: 14px;
    }

    .login-links a {
        color: #2e7d32;
        text-decoration: none;
        font-weight: 500;
    }

    .login-links a:hover {
        text-decoration: underline;
    }

    .alert-message {
        padding: 10px;
        margin-bottom: 20px;
        font-size: 14px;
        background-color: #f8d7da;
        color: #721c24;
        border-radius: 4px;
    }
</style>

<div class="content-wrapper">
  <div class="login-container">
    <h1>Library Management System</h1>
    <h2>Admin Login Form</h2>

    <?php if (!empty($message)): ?>
      <div class="alert-message">
        <?php echo $message; ?>
      </div>
    <?php endif; ?>

    <form name="login" action="" method="POST">
      <div class="form-group">
        <input class="form-control" type="text" name="username" placeholder="Username" required>
        <input class="form-control" type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login" class="btn btn-login">Login</button>
      </div>
    </form>

    <div class="login-links">
      <a href="#">Forgot password?</a> | <a href="registration.php">Sign Up</a>
    </div>
  </div>
</div>

<?php include('Footer.php'); ?>
