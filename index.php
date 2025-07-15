<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Choose Your Role</title>
<style>
:root {
  --primary-green: #2a5934;
  --primary-light: #e8f3e8;
  --accent-color: #4a8c5e;
  --white: #ffffff;
  --shadow-md: 0 6px 20px rgba(0,0,0,0.08);
}

*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}

body{
  min-height:100vh;
  background:var(--primary-light);
  display:flex;
  justify-content:center;
  align-items:center;
  flex-direction:column;
  animation: fadeIn 1.2s ease;
}

@keyframes fadeIn {
  0%{opacity:0; transform:translateY(20px);}
  100%{opacity:1; transform:translateY(0);}
}

.container{
  background:var(--white);
  padding:50px 40px;
  border-radius:20px;
  box-shadow:var(--shadow-md);
  text-align:center;
  max-width:600px;
  width:90%;
}

h1{
  font-size:2rem;
  font-weight:600;
  color:var(--primary-green);
  margin-bottom:40px;
}

.roles{
  display:flex;
  justify-content:center;
  gap:30px;
  flex-wrap:wrap;
  margin-bottom:40px;
}

.role-card{
  background:#f8f9f8;
  width:150px;
  height:160px;
  border-radius:16px;
  border:2px solid transparent;
  display:flex;
  flex-direction:column;
  justify-content:center;
  align-items:center;
  text-decoration:none;
  color:var(--primary-green);
  font-weight:500;
  font-size:1rem;
  box-shadow:0 4px 12px rgba(0,0,0,0.05);
  transition: all 0.3s ease;
  position:relative;
  overflow:hidden;
}

.role-card img{
  width:60px;
  height:60px;
  margin-bottom:10px;
  transition: transform 0.4s ease;
}

.role-card::after{
  content:"";
  position:absolute;
  width:100%;
  height:0%;
  left:0;
  bottom:0;
  background:var(--accent-color);
  z-index:0;
  transition:height 0.3s ease;
}

.role-card:hover{
  border-color:var(--accent-color);
  color:#fff;
}

.role-card:hover::after{
  height:100%;
}

.role-card:hover img{
  transform:scale(1.2);
}

.role-card span{
  position:relative;
  z-index:1;
}

.footer-illustration{
  margin-top:50px;
  animation: float 3s ease-in-out infinite;
}

@keyframes float{
  0%{transform:translateY(0);}
  50%{transform:translateY(-10px);}
  100%{transform:translateY(0);}
}
</style>
</head>
<body>

  <div class="container">
    <h1>Choose Your Role</h1>
    <div class="roles">
      <a class="role-card" href="http://localhost/booksy/Student/index.php">
        <img src="images/student.svg" alt="Student">
        <span>Student</span>
      </a>
      <a class="role-card" href="http://localhost/booksy/BooksyByOkia/index.php">
        <img src="images/admin.svg" alt="Admin">
        <span>Admin</span>
      </a>
    </div>
  </div>

  <div class="footer-illustration">
    <img src="images/decide.svg" alt="Decide" style="width:180px;height:auto;">
  </div>

</body>
</html>





