<?php
require_once 'config2.php'; // session + db

// get logged in user
$user = getCurrentUser($conn);

// if no user, redirect
if (!$user) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About Me</title>
<style>
:root {
  --primary-green: #2a5934;
  --primary-light: #e8f3e8;
  --primary-dark: #1c3d24;
  --accent-color: #4a8c5e;
  --text-dark: #1a2e22;
  --text-light: #5a7260;
  --white: #ffffff;
  --login-light: #c2efca;
  --shadow-sm: 0 2px 8px rgba(42, 89, 52, 0.1);
  --shadow-md: 0 4px 12px rgba(42, 89, 52, 0.15);
}

/* hero section */
.hero-green {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 60px 5% 80px;
  background-color: var(--primary-green);
  color: var(--white);
  position: relative;
  overflow: hidden;
  clip-path: ellipse(100% 100% at 50% 0%);
  flex-wrap: wrap;
}

.hero-text {
  flex: 1;
  max-width: 50%;
  animation: fadeInLeft 1s ease-in-out;
}

.hero-text h1 {
  font-size: 32px;
  margin-bottom: 12px;
}

.hero-text p {
  font-size: 16px;
  margin-bottom: 25px;
  color: rgba(255,255,255,0.9);
}

.hero-buttons {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
}

.hero-animate-btn {
  background-color: var(--white);
  color: var(--primary-green);
  font-weight: 600;
  padding: 10px 18px;
  border-radius: 10px;
  transition: all 0.3s ease;
  box-shadow: var(--shadow-sm);
  text-decoration: none;
}

.hero-animate-btn:hover {
  background-color: var(--login-light);
  transform: scale(1.05) translateY(-2px);
}

.hero-float-image {
  flex: 1;
  display: flex;
  justify-content: center;
  animation: fadeInRight 1s ease-in-out;
}

.hero-float-image img {
  max-width: 300px;
  width: 100%;
  animation: floatBook 4s ease-in-out infinite;
}

/* keyframes */
@keyframes fadeInLeft {
  from { opacity: 0; transform: translateX(-40px); }
  to { opacity: 1; transform: translateX(0); }
}
@keyframes fadeInRight {
  from { opacity: 0; transform: translateX(40px); }
  to { opacity: 1; transform: translateX(0); }
}
@keyframes floatBook {
  0% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
  100% { transform: translateY(0px); }
}

/* user info section */
.user-info {
  margin: 40px auto;
  max-width: 600px;
  background: var(--white);
  padding: 30px 40px;
  border-radius: 12px;
  box-shadow: var(--shadow-md);
}

.user-info h2 {
  margin-bottom: 20px;
  color: var(--primary-green);
  text-align: center;
}

.user-info p {
  margin: 10px 0;
  font-size: 16px;
  color: var(--text-dark);
}

.edit-btn {
  display: block;
  margin: 30px auto 0;
  width: 200px;
  text-align: center;
  background-color: var(--primary-green);
  color: var(--white);
  font-weight: 600;
  padding: 12px 20px;
  border-radius: 8px;
  text-decoration: none;
  transition: background 0.3s ease;
}
.edit-btn:hover {
  background-color: var(--accent-color);
}
</style>
</head>
<body>

<!-- Hero Section -->
<section class="hero-green">
  <div class="hero-text">
    <h1>Welcome, <?= htmlspecialchars($user['full_name']); ?>!</h1>
    <p>Here’s a quick look at your profile details. You can always update your info anytime.</p>
  </div>
  <div class="hero-float-image">
    <img src="Images/cat.svg" alt="Profile Illustration">
  </div>
</section>

<!-- User info card -->
<div class="user-info">
  <h2>Your Information</h2>
  <p><strong>Full Name:</strong> <?= htmlspecialchars($user['full_name']); ?></p>
  <p><strong>Roll:</strong> <?= htmlspecialchars($user['roll']); ?></p>
  <p><strong>Username:</strong> <?= htmlspecialchars($user['username']); ?></p>
  <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
  <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']); ?></p>
  <p><strong>Department:</strong> <?= htmlspecialchars($user['department']); ?></p>
  <p><strong>Account Status:</strong> <?= htmlspecialchars($user['account_status']); ?></p>

  <a href="edit-profile.php" class="edit-btn">Edit Profile</a> <!-- Go Back to Dashboard button -->
<a href="dashboard.php" class="edit-btn" style="margin-top: 15px;">⬅ Go Back to Dashboard</a>

 

</div>

</body>
</html>
