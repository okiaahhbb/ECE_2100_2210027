<?php
include 'header.php';
include('connection.php');

$message = "";
$alertClass = "";
$showPopup = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $roll = $_POST['roll'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $check_query = "SELECT * FROM student WHERE username='$username' OR roll='$roll' OR email='$email'";
    $check_result = mysqli_query($db, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $row = mysqli_fetch_assoc($check_result);
        if ($row['username'] === $username) {
            $message = "Username already exists!";
        } elseif ($row['roll'] === $roll) {
            $message = "Roll number already exists!";
        } elseif ($row['email'] === $email) {
            $message = "Email already exists!";
        }
        $alertClass = "danger";
        $showPopup = true;
    } else {
        $insert_query = "INSERT INTO student (name, username, password, roll, email, phone) 
                       VALUES ('$name', '$username', '$password', '$roll', '$email', '$phone')";
        
        if (mysqli_query($db, $insert_query)) {
            $message = "Registration successful!";
            $alertClass = "success";
            $showPopup = true;
            $_POST = array(); // Clear form
        } else {
            $message = "Error: " . mysqli_error($db);
            $alertClass = "danger";
            $showPopup = true;
        }
    }
}
?>

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        background-color: #c5d5c5;
        overflow-y: hidden;
        font-family: Arial, sans-serif;
    }
    
    .register-container {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    
    .register-box {
        width: 400px;
        padding: 30px;
        background-color: #e9f5e9;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    
    .register-box h2 {
        color: #05420f;
        margin-bottom: 20px;
    }
    
    .register-box input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    
    .register-box button {
        width: 100%;
        padding: 10px;
        background-color: #05420f;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    
    .links {
        margin-top: 15px;
        text-align: center;
    }
    
    .links a {
        color: #05420f;
        text-decoration: none;
        font-weight: bold;
    }
    
    /* Popup Styles - Only changed the red line to green */
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    
    .popup-content {
        background: white;
        padding: 25px;
        border-radius: 8px;
        width: 300px;
        text-align: center;
        box-shadow: 0 0 20px rgba(0,0,0,0.2);
    }
    
    .popup-success {
        border-top: 4px solid #4CAF50;
    }
    
    .popup-error {
        border-top: 4px solid #4CAF50; /* Changed from red to green */
    }
    
    .popup-btn {
        margin-top: 15px;
        padding: 8px 20px;
        background: #05420f;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

<div class="register-container">
  <div class="register-box">
    <h2>User Registration</h2>
    <form action="" method="POST">
      <input type="text" name="name" placeholder="Name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" required>
      <input type="text" name="username" placeholder="Username" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="text" name="roll" placeholder="Roll No" value="<?= isset($_POST['roll']) ? htmlspecialchars($_POST['roll']) : '' ?>" required>
      <input type="email" name="email" placeholder="Email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
      <input type="text" name="phone" placeholder="Phone No" value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>" required>
      <button type="submit" name="submit">Sign Up</button>
    </form>
    <div class="links">
      Already registered? <a href="student_login.php">Login</a>
    </div>
  </div>
</div>

<?php if ($showPopup): ?>
<div class="popup-overlay">
  <div class="popup-content <?= $alertClass === 'success' ? 'popup-success' : 'popup-error' ?>">
    <h3><?= $message ?></h3>
    <button class="popup-btn" onclick="this.parentElement.parentElement.style.display='none'">OK</button>
  </div>
</div>
<script>
    <?php if ($alertClass === 'success'): ?>
    setTimeout(function(){
        document.querySelector('.popup-overlay').style.display = 'none';
    }, 3000);
    <?php endif; ?>
</script>
<?php endif; ?>

<?php include 'footer.php'; ?>