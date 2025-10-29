<?php
// PATH FIX: Ye file 'games' folder ke andar hai
include '../php/db_connect.php'; 

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // PATH FIX: Wapas index.php par bhejein
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mall Match Mania 🛍️</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { background-color: #0d1117; font-family: 'Inter', sans-serif; color: #e5e7eb; }
    .card {
      width: 80px; height: 100px; 
      background: #1f2937; border: 2px solid #facc15; border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; font-size: 2rem; transition: transform 0.3s;
    }
    .card.flipped { background: #facc15; color: #1f2937; transform: rotateY(180deg); }
    .grid { display: grid; grid-template-columns: repeat(4, 80px); gap: 15px; justify-content: center; }
  </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen text-center">

  <h1 class="text-4xl font-extrabold mb-4 text-yellow-400">Mall Match Mania 🛍️</h1>
  <p class="text-gray-400 mb-6">Flip cards to match pairs — win instant mall rewards!</p>

  <div id="game" class="grid mb-6"></div>
  <p id="status" class="text-yellow-300 font-semibold h-6"></p>

  <div id="reward" class="hidden bg-gray-800 border border-yellow-400 rounded-2xl p-6 mt-6 max-w-sm">
    <h2 class="text-2xl font-bold text-green-400 mb-2">🎉 Congratulations!</h2>
    <p class="text-gray-300 mb-4" id="rewardMessage">You won <strong>50 points</strong> and unlocked a mall reward:</p>
    <p id="rewardText" class="text-yellow-400 font-semibold text-lg"></p>
    <button onclick="restart()" class="mt-4 bg-yellow-500 text-gray-900 font-bold py-2 px-6 rounded-full hover:bg-yellow-400 transition">Play Again</button>
  </div>

  <script>
    // === Database Point Saving Function ===
    function savePointsToDatabase(points) {
        // PATH FIX: 'games' folder se bahar 'php' folder mein jaana hai
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
    const emojis = ['🍔','🍕','👟','👗','🎁','☕','🎬','👜'];
    let cards = [...emojis, ...emojis].sort(() => Math.random() - 0.5);
    const game = document.getElementById('game');
    const status = document.getElementById('status');
    let flipped = [];
    let matched = 0;
    let gameWon = false; // Taki function baar baar na chale

    cards.forEach((emoji, i) => {
      const card = document.createElement('div');
      card.className = 'card';
      card.dataset.emoji = emoji;
      card.addEventListener('click', () => flipCard(card));
      game.appendChild(card);
    });

    function flipCard(card) {
      if (gameWon || flipped.length === 2 || card.classList.contains('flipped')) {
        return; // Agar game jeet gaye, ya 2 card khule hain, ya card pehle se khula hai toh kuch mat karo
      }
      
      card.classList.add('flipped');
      card.textContent = card.dataset.emoji;
      flipped.push(card);
      
      if (flipped.length === 2) {
        setTimeout(checkMatch, 800); // Thoda ruk kar check karo
      }
    }

    function checkMatch() {
      const [c1, c2] = flipped;
      if (c1.dataset.emoji === c2.dataset.emoji) {
        // Match
        matched += 2;
        flipped = [];
        if (matched === cards.length) {
          gameWon = true;
          setTimeout(showReward, 500); // Jeetne par reward dikhao
        }
      } else {
        // No Match
        flipped.forEach(c => { c.classList.remove('flipped'); c.textContent = ''; });
        flipped = [];
      }
    }

    function showReward() {
      status.textContent = '';
      const rewardBox = document.getElementById('reward');
      const rewardText = document.getElementById('rewardText');
      const rewards = [
        '☕ Free Coffee Coupon at Starbucks',
        '🍿 Free Movie Ticket',
        '🛍️ 10% Off Any Store',
        '🍔 Free Burger Meal Voucher'
      ];
      rewardText.textContent = rewards[Math.floor(Math.random() * rewards.length)];
      rewardBox.classList.remove('hidden');

      // === YAHAN CODE UPDATE HUA HAI ===
      const points = 50; // Memory match jeetne par 50 points
      savePointsToDatabase(points); // Database mein points save karein
      document.getElementById('rewardMessage').innerHTML = `You won <strong>${points} points</strong> and unlocked a mall reward:`;
      // =================================
    }

    function restart() {
      location.reload();
    }
  </script>
</body>
</html>