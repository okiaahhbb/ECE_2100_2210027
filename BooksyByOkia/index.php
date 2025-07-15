<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Booksy Admin Panel</title>

  <!-- Stylesheet -->
  <link rel="stylesheet" href="style.css" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body>

  <!-- ===== NAVBAR ===== -->
  <header class="navbar">
    <div class="logo">📚 Booksy Admin</div>
    <input type="text" class="search" placeholder="Search books..." />
    <nav class="nav-links">
      <a href="index.php">Home</a>
      <a href="Collection.php">Collection</a>
    </nav>
  </header>

  <!-- ===== HERO SECTION ===== -->
  <section class="hero-green">
    <div class="hero-text">
      <h1>📘 Welcome Back, Admin</h1>
      <p>Manage books, monitor collections, and update content from one dashboard.</p>
      <div class="hero-buttons">
        <a href="login.php" class="hero-animate-btn">Login</a>
      </div>
    </div>
    <div class="hero-float-image">
      <img src="Images/svg.svg" alt="Admin Panel Illustration" />
    </div>
  </section>

  <!-- ===== POPULAR BOOKS SECTION ===== -->
  <section class="popular">
    <div class="popular-header">
      <h2>🔥 Popular Now</h2>
      <a href="#">View All</a>
    </div>
    <div class="book-grid">
      <div class="book">
        <img src="Images/FundamentalOfElectricCircuit.jpg" alt="Fundamentals Of Electric Circuits">
        <h4>Fundamentals Of Electric Circuits</h4>
        <p>Charles K. Alexander | Matthew N. O. Sadiku</p>
      </div>
      <div class="book">
        <img src="Images/Logic And Computer Design.jpg" alt="Digital Logic Design">
        <h4>Digital Logic Design</h4>
        <p>M. Morris Mano | Charles R. Kime</p>
      </div>
      <div class="book">
        <img src="Images/Engineering Thermodynamics.jpg" alt="Engineering Thermodynamics">
        <h4>Engineering Thermodynamics</h4>
        <p>P.K. Nag | Rajat Kumar</p>
      </div>
      <div class="book">
        <img src="Images/Introduction to Algorithms.jpg" alt="Introduction to Algorithms">
        <h4>Introduction to Algorithms</h4>
        <p>Thomas H. Cormen | Charles E. Leiserson | Ronald L. Rivest | Clifford Stein</p>
      </div>
      <div class="book">
        <img src="Images/Electrical Machinery.webp" alt="Electrical Machinery">
        <h4>Electrical Machinery</h4>
        <p>P.S. Bimbhra</p>
      </div>
    </div>
  </section>

  <!-- ===== DEPARTMENT WISE BOOKS (ECE) ===== -->
  <section class="popular">
    <div class="popular-header">
      <h2>💡 Popular for ECE</h2>
    </div>
    <div class="book-grid">
      <div class="book">
        <img src="Images/Electrical Machinery.webp" alt="Electrical Machinery">
        <h4>Electrical Machinery</h4>
        <p>P.S. Bimbhra</p>
      </div>
      <div class="book">
        <img src="Images/Introduction to Algorithms.jpg" alt="Introduction to Algorithms">
        <h4>Introduction to Algorithms</h4>
        <p>Thomas H. Cormen | Charles E. Leiserson | Ronald L. Rivest | Clifford Stein</p>
      </div>
      <div class="book">
        <img src="Images/Logic And Computer Design.jpg" alt="Digital Logic Design">
        <h4>Digital Logic Design</h4>
        <p>M. Morris Mano | Charles R. Kime</p>
      </div>
      <div class="book">
        <img src="Images/Network Analysis.jpg" alt="Network Analysis">
        <h4>Network Analysis</h4>
        <p>M.E. Van Valkenburg</p>
      </div>
      <div class="book">
        <img src="Images/Principles of Electric Machines and Power Electronics.jpg" alt="Electric Machines and Power Electronics">
        <h4>Principles of Electric Machines and Power Electronics</h4>
        <p>P.C. Sen</p>
      </div>
    </div>
  </section>

  <!-- ===== ME ===== -->
  <section class="popular">
    <div class="popular-header">
      <h2>⚙️ Popular for ME</h2>
    </div>
    <div class="book-grid">
      <div class="book">
        <img src="Images/Engineering Thermodynamics.jpg" alt="">
        <h4>Engineering Thermodynamics</h4>
        <p>P.K. Nag | Rajat Kumar</p>
      </div>
      <div class="book">
        <img src="Images/Strength of Materials.jpg" alt="">
        <h4>Strength of Materials</h4>
        <p>R.K. Rajput</p>
      </div>
      <div class="book">
        <img src="Images/Theory of Machines.jpg" alt="">
        <h4>Theory of Machines</h4>
        <p>S.S. Rattan</p>
      </div>
      <div class="book">
        <img src="Images/Fluid Mechanics and Hydraulic Machines.jpg" alt="">
        <h4>Fluid Mechanics and Hydraulic Machines</h4>
        <p>R.K. Bansal</p>
      </div>
      <div class="book">
        <img src="Images/Mechanical Engineering Design.jpg" alt="">
        <h4>Mechanical Engineering Design</h4>
        <p>J.E. Shigley | Charles R. Mischke | Richard G. Budynas</p>
      </div>
    </div>
  </section>

  <!-- ===== Civil ===== -->
  <section class="popular">
    <div class="popular-header">
      <h2>🏗️ Popular for Civil</h2>
    </div>
    <div class="book-grid">
      <div class="book">
        <img src="Images/Strength of Materials.jpg" alt="Strength of Materials">
        <h4>Strength of Materials</h4>
        <p>R.K. Bansal</p>
      </div>
      <div class="book">
        <img src="Images/Surveying Volume 1.jpg" alt="Surveying Volume 1">
        <h4>Surveying (Volume 1)</h4>
        <p>B.C. Punmia | Ashok Kumar Jain | Arun Kumar Jain</p>
      </div>
      <div class="book">
        <img src="Images/Soil Mechanics and Foundations.jpg" alt="Soil Mechanics and Foundations">
        <h4>Soil Mechanics and Foundations</h4>
        <p>B.C. Punmia | Ashok Kumar Jain | Arun Kumar Jain</p>
      </div>
      <div class="book">
        <img src="Images/Building Construction.jpg" alt="Building Construction">
        <h4>Building Construction</h4>
        <p>B.C. Punmia</p>
      </div>
      <div class="book">
        <img src="Images/Environmental Engineering.jpg" alt="Environmental Engineering">
        <h4>Environmental Engineering (Volume 1)</h4>
        <p>S.K. Garg</p>
      </div>
    </div>
  </section>

</body>
</html>
