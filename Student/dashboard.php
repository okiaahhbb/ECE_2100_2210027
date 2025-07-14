<?php
// Session start and login info (dummy example)
session_start();
$_SESSION['username'] = $_SESSION['username'] ?? 'Student123'; // just for demo, replace with actual login session
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Library Dashboard</title>
<style>
  body {
    margin: 0; padding: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #e8f3e8;
    display: flex;
    height: 100vh;
  }

  /* Sidebar */
  .sidebar {
    background-color: #2a5934;
    width: 220px;
    display: flex;
    flex-direction: column;
    padding-top: 40px;
    color: white;
  }
  .sidebar h2 {
    text-align: center;
    margin-bottom: 40px;
    font-weight: 700;
  }
  .sidebar button {
    background: transparent;
    border: none;
    color: white;
    font-size: 18px;
    padding: 15px 30px;
    text-align: left;
    cursor: pointer;
    transition: background-color 0.3s;
    border-left: 5px solid transparent;
    width: 100%;
  }
  .sidebar button:hover, .sidebar button.active {
    background-color: #4a8c5e;
    border-left-color: #e8f3e8;
  }

  /* Main content */
  .main-content {
    flex-grow: 1;
    background: white;
    padding: 30px 40px;
    overflow-y: auto;
  }

  /* Topbar */
  .topbar {
    display: flex;
    justify-content: flex-end;
    padding-bottom: 20px;
    font-weight: 600;
    font-size: 16px;
    color: #2a5934;
  }

  /* Section content */
  .content-section {
    margin-top: 20px;
  }
  .content-section h3 {
    color: #2a5934;
    margin-bottom: 20px;
  }
  .info-box {
    background: #e8f3e8;
    border-radius: 10px;
    padding: 20px;
    max-width: 600px;
  }

  /* Simple table for borrow history */
  table {
    border-collapse: collapse;
    width: 100%;
  }
  th, td {
    border: 1px solid #ccc;
    padding: 10px 15px;
    text-align: left;
  }
  th {
    background-color: #2a5934;
    color: white;
  }
  td.status-approved {
    color: green;
    font-weight: 600;
  }
  td.status-pending {
    color: orange;
    font-weight: 600;
  }
  td.status-rejected {
    color: red;
    font-weight: 600;
  }
</style>
</head>
<body>

<div class="sidebar">
  <h2>Dashboard</h2>
  <button id="profileBtn" class="active">Profile</button>
  <button id="historyBtn">Borrow History</button>
  <button id="borrowBtn">Borrow Book</button>
</div>

<div class="main-content">
  <div class="topbar">
    Logged in as: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
  </div>

  <div id="profileSection" class="content-section">
    <h3>Profile Info</h3>
    <div class="info-box">
      <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
      <p><strong>Email:</strong> student@example.com</p>
      <p><strong>Member since:</strong> January 2023</p>
    </div>
  </div>

  <div id="historySection" class="content-section" style="display:none;">
    <h3>Borrow History</h3>
    <table>
      <thead>
        <tr>
          <th>Book Name</th>
          <th>Borrow Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr><td>Fundamentals of Electric Circuits</td><td>2025-06-10</td><td class="status-approved">Approved</td></tr>
        <tr><td>Thermodynamics Basics</td><td>2025-06-22</td><td class="status-pending">Pending</td></tr>
        <tr><td>Structural Analysis</td><td>2025-07-01</td><td class="status-rejected">Rejected</td></tr>
      </tbody>
    </table>
  </div>

  <div id="borrowSection" class="content-section" style="display:none;">
    <h3>Borrow Book</h3>
    <p>Select a book from the collection page and click "Borrow" to send a request.</p>
    <button id="sendRequestBtn" style="
      background-color: #2a5934;
      color: white;
      border: none;
      padding: 12px 25px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 20px;
    ">Send Borrow Request</button>
  </div>
</div>

<script>
  const profileBtn = document.getElementById('profileBtn');
  const historyBtn = document.getElementById('historyBtn');
  const borrowBtn = document.getElementById('borrowBtn');

  const profileSection = document.getElementById('profileSection');
  const historySection = document.getElementById('historySection');
  const borrowSection = document.getElementById('borrowSection');

  function clearActive() {
    profileBtn.classList.remove('active');
    historyBtn.classList.remove('active');
    borrowBtn.classList.remove('active');
  }

  profileBtn.addEventListener('click', () => {
    clearActive();
    profileBtn.classList.add('active');
    profileSection.style.display = 'block';
    historySection.style.display = 'none';
    borrowSection.style.display = 'none';
  });

  historyBtn.addEventListener('click', () => {
    clearActive();
    historyBtn.classList.add('active');
    profileSection.style.display = 'none';
    historySection.style.display = 'block';
    borrowSection.style.display = 'none';
  });

  borrowBtn.addEventListener('click', () => {
    clearActive();
    borrowBtn.classList.add('active');
    profileSection.style.display = 'none';
    historySection.style.display = 'none';
    borrowSection.style.display = 'block';
  });

  // Borrow request popup
  document.getElementById('sendRequestBtn').addEventListener('click', () => {
    alert('Request sent to admin. Please wait for approval.');
    // TODO: Actual backend request logic to notify admin can be added here
  });
</script>

</body>
</html>
