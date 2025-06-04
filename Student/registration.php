<?php
include 'header.php';
include('connection.php');

$message = "";
$alertClass = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $roll = $_POST['roll'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $check = mysqli_query($db, "SELECT * FROM student WHERE username='$username' OR roll='$roll' OR email='$email'");

    if (mysqli_num_rows($check) > 0) {
        $row = mysqli_fetch_assoc($check);
        if ($row['username'] == $username) {
            $message = "Username already exists. Please choose another one.";
        } elseif ($row['roll'] == $roll) {
            $message = "Roll number already exists. Please check again.";
        } elseif ($row['email'] == $email) {
            $message = "Email already exists. Please use another email.";
        }
        $alertClass = "danger";
    } else {
        $sql = "INSERT INTO student (name, username, password, roll, email, phone)
                VALUES ('$name', '$username', '$password', '$roll', '$email', '$phone')";

        if (mysqli_query($db, $sql)) {
            $message = "Registration successful!";
            $alertClass = "success";
        } else {
            $message = "Registration failed: " . mysqli_error($db);
            $alertClass = "danger";
        }
    }
}
?>



<div class="register-container">
  <div class="register-box">
    <h2>User Registration</h2>

    <?php if (!empty($message)) : ?>
      <div class="alert alert-<?php echo $alertClass; ?>">
        <?php echo $message; ?>
      </div>
    <?php endif; ?>

    <form action="" method="POST">
      <input type="text" name="name" placeholder="Name" required>
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="text" name="roll" placeholder="Roll No" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="phone" placeholder="Phone No" required>
      <button type="submit" name="submit">Sign Up</button>
    </form>

    <div class="links">
      Already registered? <a href="student_login.php">Login</a>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
