<?php
require_once 'config2.php';
$user = getCurrentUser($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Booksy</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --primary-green: #2a5934;
      --light-green: #e8f3e8;
      --accent: #4a8c5e;
      --white: #ffffff;
      --dark-text: #1a2e22;
      --shadow: 0 4px 12px rgba(42, 89, 52, 0.1);
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f9fffb;
      margin: 0;
      padding: 0;
      color: var(--dark-text);
    }

    .header {
      background-color: var(--primary-green);
      padding: 60px 20px;
      color: white;
      text-align: center;
      clip-path: ellipse(100% 100% at 50% 0%);
    }

    .header h1 {
      margin-bottom: 10px;
      font-size: 36px;
    }

    .header p {
      font-size: 18px;
      color: rgba(255, 255, 255, 0.85);
    }

    .section {
      max-width: 900px;
      margin: 40px auto;
      padding: 0 20px;
    }

    .section h2 {
      color: var(--primary-green);
      font-size: 24px;
      margin-bottom: 15px;
    }

    .section p, .section ul {
      font-size: 16px;
      line-height: 1.6;
    }

    ul {
      padding-left: 20px;
    }

    .highlight {
      background-color: var(--light-green);
      padding: 12px 16px;
      border-left: 5px solid var(--primary-green);
      margin: 20px 0;
      border-radius: 6px;
    }

    .footer {
      text-align: center;
      margin: 60px auto 30px;
    }

    .back-btn {
      text-decoration: none;
      background-color: var(--primary-green);
      color: white;
      padding: 12px 24px;
      border-radius: 8px;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    .back-btn:hover {
      background-color: var(--accent);
    }
  </style>
</head>
<body>

<div class="header">
  <h1>📚 About Booksy</h1>
  <p>Not just a website — a complete library experience</p>
</div>

<div class="section">
  <h2>🎓 Students Section</h2>
  <ul>
    <li>✅ Anyone can explore the collection — no login needed.</li>
    <li>🔐 To borrow books, you must log in with your student account.</li>
    <li>📖 Once logged in, you can request books from any department — not just your own.</li>
    <li>📚 You can borrow any books from any department, and get admin info anytime if you need help — we're always eager to assist!</li>
    <li>👤 Your personal dashboard shows:
      <ul>
        <li>Your profile details (editable anytime)</li>
        <li>Suggestions based on your department</li>
        <li>Borrowed books history, with return option</li>
      </ul>
    </li>
  </ul>
</div>


<div class="section">
  <h2>💬 Reviews & Feedback</h2>
  <ul>
    <li>✍ Anyone can leave a review — even without logging in!</li>
    <li>🙈 You choose whether to show your name or stay Anonymous.</li>
    <li>📢 All feedback is shown in a clean review section for everyone to see.</li>
  </ul>
</div>

<div class="section">
  <h2>🏠 Home Page Extras</h2>
  <ul>
    <li>🌟 See the most popular books by department — even before you log in.</li>
    <li>🚀 Quick links to different departments for fast browsing.</li>
  </ul>
</div>


<div class="footer">
  <a href="<?= $user ? 'dashboard.php' : 'index.php' ?>" class="back-btn">⬅ Back to <?= $user ? 'Dashboard' : 'Home' ?></a>
</div>

</body>
</html>
