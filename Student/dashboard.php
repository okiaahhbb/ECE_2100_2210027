<?php include 'header.php'; ?>

<style>
  body {
    background-color: #c5d5c5;
  }

  .dashboard-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 80px 20px;
    flex-grow: 1;
  }

  .dashboard-box {
    background-color: #e9f5e9;
    padding: 40px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .dashboard-box h2 {
    color: #05420f;
    margin-bottom: 30px;
  }

  .dashboard-buttons {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .dashboard-buttons a {
    background-color: #05420f;
    color: white;
    padding: 12px 20px;
    text-decoration: none;
    border-radius: 8px;
    font-size: 16px;
    transition: background-color 0.3s ease;
  }

  .dashboard-buttons a:hover {
    background-color: #063d11;
  }
</style>

<div class="dashboard-container">
  <div class="dashboard-box">
    <h2>Student Dashboard</h2>
    <div class="dashboard-buttons">
      <a href="currently_reading.php">📖 Currently Reading</a>
      <a href="borrow_history.php">📚 Borrowed History</a>
      <a href="wishlist.php">🕘 Wishlist</a>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
