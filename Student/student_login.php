<!DOCTYPE html>
<html>
<head>
  <title>User Login</title>
  <link rel="stylesheet" href="style.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CDN -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <style>
    body {
      background-color: #c5d5c5;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    header {
      height: 90px;
      background-color: #05420f;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 30px;
    }

    .logo h1 {
      color: white;
      font-size: 25px;
      word-spacing: 10px;
      margin: 0;
      line-height: 90px;
    }

    nav ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      display: flex;
      gap: 20px;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      font-size: 16px;
    }

    .log_img {
      background-color: #c5d5c5;
      padding: 50px 0;
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .box1 {
      background-color: #e9f5e9;
      padding: 30px 40px;
      border-radius: 10px;
      width: 350px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .box1 h1 {
      font-family: 'Lucida Console', monospace;
      font-size: 25px;
      margin-bottom: 10px;
      color: #05420f;
    }

    .box1 h3 {
      text-align: center;
      font-size: 20px;
      margin-bottom: 20px;
    }

    .login input {
      margin-bottom: 15px;
    }

    .login input[type="submit"] {
      width: 100%;
    }

    .links {
      text-align: center;
      margin-top: 15px;
    }

    .links a {
      color: #05420f;
      text-decoration: none;
      font-weight: bold;
    }

    footer {
      height: 90px;
      background-color: #05420f;
      color: white;
      text-align: center;
      line-height: 90px;
      font-size: 14px;
    }
  </style>
</head>
<body>

<header>
  <div class="logo">
    <h1>ONLINE LIBRARY MANAGEMENT SYSTEM</h1>
  </div>
  <nav>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="#">Books</a></li>
      <li><a href="student_login.php">Student Login</a></li>
      <li><a href="#">Feedback</a></li>
    </ul>
  </nav>
</header>

<section>
  <div class="log_img">
    <div class="box1">
      <h1 style="text-align: center;">Library Management System</h1>
      <h3>User Login Form</h3>
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
</section>

<footer>
  Email: online.library@gmail.com | Mobile: +88018XXXXXXXX
</footer>

</body>
</html>
