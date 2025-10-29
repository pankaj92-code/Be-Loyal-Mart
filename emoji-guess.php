<?php
include '../php/db_connect.php'; // Ye session_start() bhi kar dega

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to index.php (index.html nahi)
    header("Location: ../index.php"); 
    exit();
}

// (Optional) Get user's data for use on this page
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop & Guess | Mall Game</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { background-color: #0d1117; font-family: 'Inter', sans-serif; color: #e5e7eb; }
    .gradient-text { background: linear-gradient(to right, #facc15, #f97316); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .emoji-box { font-size: 3rem; }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

  <div class="w-full max-w-lg bg-gray-800 rounded-3xl shadow-2xl p-8 border border-yellow-500/30 text-center">
    <h1 class="text-4xl font-extrabold mb-4 gradient-text">🛍️ Shop & Guess</h1>
    <p class="text-gray-400 mb-6">Decode the emojis to guess the correct shop, brand, or product. Earn points for every right answer!</p>
    <div id="emoji" class="emoji-box mb-6">🍔👑</div>
    <input id="guessInput" type="text" placeholder="Type your guess..." 
           class="w-full mb-4 p-3 rounded-md bg-gray-900 border border-yellow-500/40 text-gray-200 focus:outline-none focus:border-yellow-400">
    <button onclick="checkAnswer()" 
            class="premium-button w-full py-3 rounded-full font-bold text-gray-900 text-lg shadow-xl" style="background-image: linear-gradient(135deg, #facc15 0%, #f97316 100%);">
      Submit Guess
    </button>
    <p id="feedback" class="mt-4 text-lg font-semibold h-8"></p>
    <p class="text-sm text-gray-500 mt-2">Score: <span id="score" class="text-yellow-400">0</span></p>
    <button id="nextBtn" onclick="nextQuestion()" 
            class="hidden mt-4 py-2 px-6 rounded-full bg-yellow-500 text-gray-900 font-semibold hover:bg-yellow-400 transition">
      Next ➡️
    </button>
  </div>

  <script>
    // === Database Point Saving Function ===
    function savePointsToDatabase(points) {
        fetch('../php/update-points.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ points: points })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Points saved!');
            } else {
                console.error('Failed to save points:', data.message);
            }
        });
    }
    // ==================================
  
    // === Game Logic ===
    const questions = [
      { emoji: "🍔👑", answer: "burger king" },
      { emoji: "☕🍩", answer: "dunkin donuts" },
      { emoji: "🛒🏬", answer: "shopping mall" },
      { emoji: "🍎📱", answer: "apple store" },
      { emoji: "👟⚡", answer: "nike" },
      { emoji: "🍕🏠", answer: "pizza hut" },
      { emoji: "🎬🍿", answer: "cinema" },
      { emoji: "👜💄", answer: "sephora" }
    ];
    let current = 0;
    let score = 0;
    const emojiDiv = document.getElementById("emoji");
    const feedback = document.getElementById("feedback");
    const scoreBox = document.getElementById("score");
    const nextBtn = document.getElementById("nextBtn");
    const guessInput = document.getElementById("guessInput");

    function checkAnswer() {
      const userGuess = guessInput.value.trim().toLowerCase();
      if (!userGuess) return;

      if (userGuess === questions[current].answer) {
        feedback.textContent = "✅ Correct!";
        feedback.className = "mt-4 text-green-400 font-bold";
        
        // Point saving logic
        const points = 10; 
        score += points;
        savePointsToDatabase(points); // Call the function
        
        scoreBox.textContent = score;
        nextBtn.classList.remove("hidden");
      } else {
        feedback.textContent = "❌ Try Again!";
        feedback.className = "mt-4 text-red-400 font-bold";
      }
    }

    function nextQuestion() {
      current++;
      if (current >= questions.length) {
        emojiDiv.textContent = "🏁";
        feedback.textContent = `Game Over! Final Score: ${score}`;
        feedback.className = "mt-4 text-yellow-400 font-bold";
        nextBtn.classList.add("hidden");
        guessInput.disabled = true;
        return;
      }
      emojiDiv.textContent = questions[current].emoji;
      guessInput.value = "";
      feedback.textContent = "";
      nextBtn.classList.add("hidden");
      guessInput.focus();
    }
  </script>
</body>
</html>