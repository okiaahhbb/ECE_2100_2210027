

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <style>
        /* Reset and Base Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #c5d5c5; /* Light green background */
            line-height: 1.6;
        }

        /* Header */
        header {
            background-color: #05420f; /* Dark green header */
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo h1 {
            margin: 0;
            font-size: 24px;
            font-weight: normal;
        }

        /* Navigation */
        nav ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 30px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        /* Main Content */
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .welcome-container {
            background-color: #e9f5e9;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }

        .welcome-container h2 {
            color: #05420f;
            margin-bottom: 15px;
            font-size: 28px;
            font-weight: normal;
        }

        .quote {
            font-style: italic;
            color: #05420f;
            font-size: 18px;
            margin-top: 15px;
        }

        /* Footer */
        footer {
            background-color: #05420f; /* Dark green footer */
            color: white;
            text-align: center;
            padding: 15px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <h1>ONLINE LIBRARY MANAGEMENT SYSTEM</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="books.php">Books</a></li>
                <li><a href="student_login.php">Student Login</a></li>
                <li><a href="feedback.php">Feedback</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="welcome-container">
            <h2>Welcome to the Library</h2>
            <p class="quote" id="quoteBox">"A reader lives a thousand lives before he dies."</p>
        </div>
    </main>

    <footer>
        &copy; 2025 RUET Library All rights reserved.
    </footer>

    <script>
        // Quote rotation script
        const quotes = [
            '"A reader lives a thousand lives before he dies."',
            '"Books are a uniquely portable magic."',
            '"Today a reader, tomorrow a leader."',
            '"There is no friend as loyal as a book."',
            '"Libraries store the energy that fuels the imagination."'
        ];

        const quoteBox = document.getElementById('quoteBox');
        let currentQuote = 0;

        function rotateQuote() {
            quoteBox.style.opacity = 0;
            setTimeout(() => {
                quoteBox.textContent = quotes[currentQuote];
                quoteBox.style.opacity = 1;
                currentQuote = (currentQuote + 1) % quotes.length;
            }, 500);
        }

        // Rotate quotes every 5 seconds
        setInterval(rotateQuote, 5000);
    </script>
</body>
</html>

