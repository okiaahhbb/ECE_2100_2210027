<?php
include('connection.php'); // adjust path if needed

$books = [];
$result = mysqli_query($db, "SELECT * FROM books");

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Library Management System - Books</title>
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
      background-color: #05420f;
      color: white;
      padding: 15px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 20px;
      font-weight: bold;
    }

    .menu {
      display: flex;
      gap: 20px;
    }

    .menu a {
      color: white;
      text-decoration: none;
      font-weight: bold;
    }

    .menu a:hover {
      text-decoration: underline;
    }

    .books-container {
      flex: 1;
      padding: 40px 60px;
    }

    .books-table {
      width: 100%;
      background-color: #e9f5e9;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table th, table td {
      padding: 12px;
      border-bottom: 1px solid #ccc;
      text-align: left;
    }

    table th {
      background-color: #05420f;
      color: white;
    }

    table tr:hover {
      background-color: #d0e4d0;
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
  <div class="menu">
    <a href="index.php">Home</a>
    <a href="books.php">Books</a>
    <a href="student_login.php">Login</a>
    <a href="feedback.php">Feedback</a>
  </div>
</header>

<div class="books-container">
  <div class="books-table">
    <h2 style="text-align: center; color: #05420f; margin-bottom: 20px;">Available Books</h2>

    <?php if (count($books) > 0): ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Book Name</th>
            <th>Author</th>
            <th>Edition</th>
            <th>Status</th>
            <th>Quantity</th>
            <th>Department</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($books as $book): ?>
            <tr>
              <td><?= $book['Book_ID'] ?></td>
              <td><?= $book['Name_of_Book'] ?></td>
              <td><?= $book['Name_of_Author'] ?></td>
              <td><?= $book['Edition'] ?></td>
              <td><?= $book['Status'] ?></td>
              <td><?= $book['Quantity'] ?></td>
              <td><?= $book['Dept'] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p style="text-align: center;">No books available in the library right now.</p>
    <?php endif; ?>
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
