<?php include 'header.php'; ?>

        <style>
  body {
    background-color: #c5d5c5;
  }

  .welcome-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 60px 20px;
    flex-grow: 1;
  }

  .welcome-box {
    background-color: #e9f5e9;
    padding: 40px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    position: relative;
  }

  .slideshow-quote {
    font-size: 18px;
    color: #05420f;
    min-height: 60px;
    margin-top: 15px;
    transition: opacity 0.5s ease-in-out;
  }
</style>

<div class="welcome-container">
  <div class="welcome-box">
    <h1>Welcome to the Library</h1>
    <div class="slideshow-quote" id="quoteBox">
      📚 "A reader lives a thousand lives before he dies."
    </div>
  </div>
</div>

<script>
  const quotes = [
    '📚 "A reader lives a thousand lives before he dies."',
    '📖 "Today a reader, tomorrow a leader."',
    '📘 "Reading is essential for those who seek to rise above the ordinary."',
    '📗 "Books are a uniquely portable magic."',
    '📕 "Libraries store the energy that fuels the imagination."'
  ];

  let current = 0;
  const quoteBox = document.getElementById('quoteBox');

  setInterval(() => {
    current = (current + 1) % quotes.length;
    quoteBox.style.opacity = 0;
    setTimeout(() => {
      quoteBox.textContent = quotes[current];
      quoteBox.style.opacity = 1;
    }, 300);
  }, 4000); // changes every 4 seconds
</script>

<?php include 'footer.php'; ?>