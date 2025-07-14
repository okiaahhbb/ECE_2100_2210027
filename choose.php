<?php
// Homepage.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Booksy - Select User Type</title>
<style>
  body {
    font-family: 'Segoe UI', sans-serif;
    background: #e8f3e8;
    margin: 0; padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }
  .container {
    display: flex;
    gap: 80px;
  }
  .choice-card {
    background: white;
    width: 250px;
    border-radius: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    text-align: center;
    padding: 30px 20px;
    cursor: pointer;
    transition: box-shadow 0.3s, transform 0.2s;
    text-decoration: none;
    color: #2a5934;
    font-weight: 600;
    font-size: 20px;
  }
  .choice-card:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    transform: translateY(-5px);
  }
  .choice-card img {
    width: 120px;
    height: 120px;
    margin-bottom: 25px;
  }
</style>
</head>
<body>

<div class="container">
  <a href="admin.php" class="choice-card">
    <img src="Images/admin.svg" alt="Admin" />
    Admin
  </a>

  <a href="student/index.php" class="choice-card">
    <img src="Images/student.svg" alt="Student" />
    Student
  </a>
</div>

</body>
</html>
