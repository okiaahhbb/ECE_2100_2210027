<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Library Management System - Registration</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #c5d5c5;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    header {
      height: 100px;
      background-color: #05420f;
      color: white;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 40px;
    }

    .logo {
      font-size: 20px;
      font-weight: bold;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 30px;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-weight: bold;
    }

    .register-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .register-box {
      background-color: #e9f5e9;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 400px;
      text-align: center;
    }

    .register-box h2 {
      color: #05420f;
      margin-bottom: 20px;
    }

    .register-box input {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .register-box button {
      width: 100%;
      padding: 10px;
      background-color: #05420f;
      color: white;
      border: none;
      border-radius: 5px;
      font-weight: bold;
    }

    .links {
      margin-top: 15px;
      font-size: 14px;
    }

    .links a {
      color: #05420f;
      text-decoration: none;
      margin: 0 5px;
    }

    footer {
      height: 100px;
      background-color: #05420f;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
    }
  </style>
</head>
<body>

<header>
  <div class="logo">ONLINE LIBRARY MANAGEMENT SYSTEM</div>
  <nav>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="#">Books</a></li>
      <li><a href="student_login.php">Student Login</a></li>
      <li><a href="feedback.php">Feedback</a></li>
    </ul>
  </nav>
</header>

<div class="register-container">
  <div class="register-box">
    <h2>User Registration</h2>
    <form action="registration.php" method="POST">
      <input type="text" name="first" placeholder="First Name" required>
      <input type="text" name="last" placeholder="Last Name" required>
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="text" name="roll" placeholder="Roll No" required>
      <input type="email" name="email" placeholder="Email" required>
      <button type="submit">Sign Up</button>
    </form>
    <div class="links">
      Already registered? <a href="student_login.php">Login</a>
    </div>
  </div>
</div>

<footer>
  <div>
    Email: online.library@gmail.com<br>
    Mobile: +88018XXXXXXXX
  </div>
</footer>

</body>
</html>
