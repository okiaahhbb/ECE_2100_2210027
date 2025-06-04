<?php
include('header.php');
include('connection.php');


$message = "";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM student WHERE username='$username' AND password='$password'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        header("Location: student_dashboard.php");
        exit();
    } else {
        $message = "Invalid username or password.";
    }
}
?>

<div class="log_img">
  <div class="box1">
    <h1>Library Management System</h1>
    <h3>User Login Form</h3>

    <?php if (!empty($message)): ?>
      <div class="alert alert-danger" style="text-align: center;">
        <?php echo $message; ?>
      </div>
    <?php endif; ?>

    <form name="login" action="" method="POST">
      <div class="login form-group">
        <input class="form-control" type="text" name="username" placeholder="Username" required>
        <input class="form-control" type="password" name="password" placeholder="Password" required>
        <input class="btn btn-success" type="submit" name="submit" value="Login">
      </div>
    </form>

    <div class="links">
      <a href="#">Forgot password?</a> | <a href="registration.php">Sign Up</a>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>
