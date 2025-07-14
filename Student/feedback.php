<?php
session_start();
include '../db_connect.php';

// Check login status (just to allow feedback form for logged-in users)
$isLoggedIn = isset($_SESSION['student_id']);

$submitMsg = '';

// Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isLoggedIn) {
    $feedback = trim($_POST['feedback'] ?? '');
    $is_anonymous = isset($_POST['anonymous']) ? 1 : 0;
    $name = trim($_POST['name'] ?? '');

    if ($is_anonymous) {
        $name = "Anonymous";
    }

    if ($feedback !== '' && $name !== '') {
        $stmt = $conn->prepare("INSERT INTO feedbacks (name, feedback, is_anonymous) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $name, $feedback, $is_anonymous);
        if ($stmt->execute()) {
            $submitMsg = "Thank you for your feedback!";
        } else {
            $submitMsg = "Failed to submit feedback. Please try again.";
        }
        $stmt->close();
    } else {
        $submitMsg = "Please fill in all required fields.";
    }
}

// Fetch feedbacks
$sql = "SELECT name, feedback FROM feedbacks ORDER BY created_at DESC";
$result = $conn->query($sql);

$svgImages = ['Images/Person1.svg', 'Images/Person2.svg', 'Images/Person3.svg'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Feedback | Booksy</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet" />
  <style>
    :root {
      --primary-green: #2a5934;
      --primary-light: #e8f3e8;
      --primary-dark: #1c3d24;
      --accent-color: #4a8c5e;
      --text-dark: #1a2e22;
      --text-light: #5a7260;
      --white: #ffffff;
      --shadow-sm: 0 2px 8px rgba(42, 89, 52, 0.1);
      --shadow-md: 0 4px 12px rgba(42, 89, 52, 0.15);
    }
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Inter", sans-serif;
    }
    body {
      background: var(--primary-light);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 15px 5%;
      background-color: var(--white);
      box-shadow: var(--shadow-sm);
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    .logo {
      font-size: 28px;
      font-weight: 800;
      color: var(--primary-green);
      user-select: none;
    }
    .nav-links {
      display: flex;
      gap: 20px;
    }
    .nav-links a {
      text-decoration: none;
      font-weight: 600;
      color: var(--primary-green);
      padding: 8px 15px;
      border-radius: 12px;
      transition: all 0.3s ease;
    }
    .nav-links a:hover,
    .nav-links a.active {
      background-color: var(--primary-green);
      color: var(--white);
      box-shadow: var(--shadow-md);
    }
    .feedback-hero {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: var(--primary-green);
      padding: 80px 5% 120px;
      clip-path: ellipse(100% 100% at 50% 0%);
      color: white;
      gap: 20px;
      flex-wrap: wrap;
    }
    .feedback-left {
      max-width: 600px;
      flex: 1 1 400px;
    }
    .feedback-left h1 {
      font-size: 32px;
      margin-bottom: 20px;
    }
    .feedback-left p {
      font-size: 16px;
      margin-bottom: 25px;
    }
    .feedback-left form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    .feedback-left input[type="text"] {
      padding: 12px;
      border-radius: 10px;
      border: none;
      font-size: 15px;
    }
    .feedback-left textarea {
      padding: 12px;
      border-radius: 10px;
      border: none;
      resize: vertical;
      min-height: 100px;
      font-size: 15px;
      max-length: 200;
    }
    .feedback-left button {
      padding: 12px;
      border: none;
      border-radius: 10px;
      background-color: var(--white);
      color: var(--primary-green);
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      width: 150px;
      align-self: flex-start;
    }
    .feedback-left button:hover {
      background-color: #c2efca;
      transform: scale(1.05);
    }
    .feedback-left .message {
      margin-bottom: 15px;
      font-weight: 600;
      color: var(--white);
      text-shadow: 0 0 6px rgba(0,0,0,0.7);
    }
    .feedback-right {
      flex: 1 1 300px;
      text-align: center;
    }
    .feedback-right img {
      width: 300px;
      max-width: 100%;
    }
    .reviews-section {
      background-color: var(--primary-light);
      padding: 60px 5%;
      text-align: center;
      flex-grow: 1;
    }
    .reviews-heading {
      font-size: 28px;
      color: var(--primary-green);
      margin-bottom: 40px;
    }
    .reviews-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
      justify-items: center;
    }
    .review-card {
      background-color: var(--white);
      padding: 25px 20px;
      border-radius: 16px;
      box-shadow: var(--shadow-sm);
      max-width: 350px;
      text-align: left;
      transition: 0.3s;
      border: 1px solid var(--primary-light);
      display: flex;
      gap: 15px;
      align-items: center;
    }
    .review-card img {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      object-fit: cover;
      flex-shrink: 0;
      border: 2px solid var(--primary-green);
      background-color: var(--white);
      max-width: 100%;
      max-height: 100%;
    }
    .review-text {
      flex-grow: 1;
    }
    .review-card h4 {
      margin: 0 0 8px 0;
      font-size: 16px;
      color: var(--primary-green);
    }
    .review-card p {
      font-size: 15px;
      color: var(--text-light);
      line-height: 1.6;
      margin: 0;
      word-break: break-word;
      overflow-wrap: break-word;
      white-space: normal;
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 6;
      -webkit-box-orient: vertical;
      height: 150px;
    }
    .footer-svg {
      text-align: center;
      margin-top: 60px;
      padding-bottom: 30px;
    }
    .footer-svg img {
      width: 250px;
      max-width: 100%;
    }
    #topBtn {
      display: none;
      position: fixed;
      bottom: 30px;
      right: 30px;
      z-index: 99;
      font-size: 18px;
      border: none;
      outline: none;
      background-color: var(--primary-green);
      color: white;
      cursor: pointer;
      padding: 12px 18px;
      border-radius: 10px;
      user-select: none;
    }
  </style>
</head>
<body>

<header class="navbar">
  <div class="logo">📚 Booksy</div>
  <nav class="nav-links">
    <a href="../Student/index.php">Home</a>
    <a href="../Student/collection.php">Collection</a>
    <a href="feedback.php" class="active">Feedback</a>
  </nav>
</header>

<section class="feedback-hero">
  <div class="feedback-left">
    <h1>We appreciate your feedback 📝</h1>
    <p>Your thoughts help us improve and grow. Feel free to share anything!</p>

    <?php if (!$isLoggedIn): ?>
      <p style="color:#c2efca; font-weight:600; background:#1c3d24; padding:12px; border-radius:8px;">
        Please <a href="../Student/login.php" style="color:#e8f3e8; text-decoration:underline;">login</a> to give feedback.
      </p>
    <?php else: ?>
      <?php if ($submitMsg): ?>
        <p class="message"><?php echo htmlspecialchars($submitMsg); ?></p>
      <?php endif; ?>
      <form method="POST" action="feedback.php">
        <input type="text" name="name" placeholder="Enter your name" required />
        <label><input type="checkbox" name="anonymous" value="1" onchange="toggleNameInput(this)" /> Submit as anonymous</label>
        <textarea name="feedback" maxlength="200" placeholder="Write your feedback here..." required></textarea>
        <button type="submit">Send Feedback</button>
      </form>
    <?php endif; ?>
  </div>

  <div class="feedback-right">
    <img src="Images/feedback.svg" alt="Feedback SVG" />
  </div>
</section>

<section class="reviews-section">
  <h2 class="reviews-heading">🙌 Thank you for trusting us!</h2>
  <div class="reviews-grid">
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <?php $svg = $svgImages[array_rand($svgImages)]; ?>
        <div class="review-card">
          <img src="<?php echo $svg; ?>" alt="User" />
          <div class="review-text">
            <h4><?php echo htmlspecialchars($row['name']); ?></h4>
            <p>“<?php echo htmlspecialchars($row['feedback']); ?>”</p>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="color: var(--primary-dark); font-weight:600;">No feedback yet. Be the first to share your thoughts!</p>
    <?php endif; ?>
  </div>
</section>

<div class="footer-svg">
  <img src="Images/cat.svg" alt="Books Footer" />
</div>

<button onclick="topFunction()" id="topBtn" title="Go to top">⬆️ Top</button>

<script>
function toggleNameInput(checkbox) {
  const input = document.querySelector('input[name="name"]');
  if (checkbox.checked) {
    input.disabled = true;
    input.value = 'Anonymous';
  } else {
    input.disabled = false;
    input.value = '';
  }
}

const topButton = document.getElementById("topBtn");
window.onscroll = function () {
  topButton.style.display = (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) ? "block" : "none";
};
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>

</body>
</html>
