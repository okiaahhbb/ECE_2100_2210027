<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Online Library Management System</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .wrapper {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    header {
      background-color: #034026;
      color: white;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    .logo h1 {
      margin: 0;
      font-size: 26px;
    }

    nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      gap: 20px;
    }

    nav ul li a {
      text-decoration: none;
      color: white;
      font-weight: bold;
      transition: color 0.3s;
    }

    nav ul li a:hover {
      color: #a8f0cf;
    }

    .sec_img {
      background: url('library.jpg') no-repeat center center/cover;
      flex-grow: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px 20px;
    }

    .box {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 40px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }

    .box h1 {
      margin: 15px 0;
      font-size: 24px;
      color: #034026;
    }

    footer {
      background-color: #034026;
      color: white;
      text-align: center;
      padding: 20px;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <header>
      <div class="logo">
        <h1>Online Library Management System</h1>
      </div>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="books.php">Books</a></li>
          <li><a href="student_login.php">Student Login</a></li>
          <li><a href="feedback.php">Feedback</a></li>
        </ul>
      </nav>
    </header>

    <section class="sec_img">
      <div class="box">
        <h1>Welcome to the Library</h1>
        <h1>Opens at: 09:00</h1>
        <h1>Closes at: 15:00</h1>
      </div>
    </section>

    <footer>
      <p>
        Email: online.library@gmail.com<br>
        Mobile: +88018********
      </p>
    </footer>
  </div>
</body>
</html>
