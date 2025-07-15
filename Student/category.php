<?php
// category.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Select Department</title>
<style>
:root {
  --primary-green: #1c3d24;
  --primary-light: #e8f3e8;
  --white: #ffffff;
  --shadow-md: 0 6px 16px rgba(28,61,36,0.2);
}

body {
  margin: 0;
  font-family: "Segoe UI", Tahoma, sans-serif;
  background: var(--primary-light);
  color: #1a2e22;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

/* Top Navigation */
.navbar {
  background: var(--primary-green);
  color: var(--white);
  padding: 15px 40px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: var(--shadow-md);
}
.navbar h2 {
  margin: 0;
  font-size: 22px;
  letter-spacing: 0.5px;
}
.navbar a {
  color: var(--white);
  text-decoration: none;
  font-weight: 600;
  margin-left: 25px;
  transition: opacity 0.3s ease;
}
.navbar a:hover {
  opacity: 0.8;
}

/* Main container */
.container {
  flex: 1;
  text-align: center;
  padding: 80px 20px 140px; /* increased top and bottom padding */
}

h1 {
  font-size: 38px;
  margin-bottom: 60px; /* more space before buttons */
  color: var(--primary-green);
}

.category-buttons {
  display: flex;
  gap: 50px;
  justify-content: center;
  flex-wrap: wrap;
  margin-top: 40px; /* buttons pushed down further */
}

.cat-btn {
  background: var(--white);
  border: none;
  border-radius: 16px;
  box-shadow: var(--shadow-md);
  padding: 35px 40px;
  width: 220px;
  cursor: pointer;
  text-align: center;
  transition: all 0.3s ease;
  text-decoration: none;
  color: var(--primary-green);
  font-weight: 600;
  font-size: 20px;
}

.cat-btn:hover {
  transform: translateY(-4px);
  background: #d5e8d6;
}

.cat-btn img {
  max-width: 110px; /* bigger SVG icons */
  margin-bottom: 20px;
  display: block;
  margin-left: auto;
  margin-right: auto;
}

@media (max-width: 768px) {
  .cat-btn {
    width: 180px;
    padding: 25px 20px;
    font-size: 18px;
  }
  .cat-btn img {
    max-width: 90px;
  }
}

/* Bottom floating image */
.bottom-animation {
  position: fixed;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  animation: floatCat 4s ease-in-out infinite;
  pointer-events: none;
}

.bottom-animation img {
  max-width: 200px;
  opacity: 0.9;
}

@keyframes floatCat {
  0% { transform: translate(-50%,0px); }
  50% { transform: translate(-50%,-15px); }
  100% { transform: translate(-50%,0px); }
}
</style>
</head>
<body>
  <!-- Dashboard Navigation -->
  <div class="navbar">
    <h2>📚 Booksy Dashboard</h2>
    <div>
      
      <a href="aboutme.php">Profile</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <!-- Main Section -->
  <div class="container">
    <h1>Choose Your Department</h1>
    <div class="category-buttons">
      <a class="cat-btn" href="ECE.php">
        <img src="Images/Electrical.svg" alt="ECE">
        ECE
      </a>
      <a class="cat-btn" href="CIVIL.php">
        <img src="Images/Civil.svg" alt="Civil">
        Civil
      </a>
      <a class="cat-btn" href="ME.php">
        <img src="Images/Mechanical.svg" alt="Mechanical">
        Mechanical
      </a>
    </div>
  </div>

  <!-- Bottom Animated Image -->
  <div class="bottom-animation">
    <img src="Images/cat.svg" alt="Decoration">
  </div>
</body>
</html>
