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
  <title>Mystery Mall Box 🎁</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { background-color: #0d1117; color: #e5e7eb; font-family: 'Inter', sans-serif; }
    .box {
      width: 120px; height: 120px; 
      background: linear-gradient(145deg, #facc15, #f97316);
      border-radius: 1rem;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; font-size: 2.5rem; color: #111;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .box:hover { transform: translateY(-6px); box-shadow: 0 12px 25px rgba(249, 115, 22, 0.4); }
    .opened { background: #22c55e !important; color: white; transform: scale(1.1); }
  </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen text-center">

  <h1 class="text-4xl font-extrabold mb-4 text-yellow-400">Mystery Mall Box 🎁</h1>
  <p class="text-gray-400 mb-6 max-w-md">Daily Pick a box to reveal your surprise reward! Each box contains something special from our mall partners.</p>
  <div id="boxes" class="grid grid-cols-3 gap-6 mb-8"></div>
  
  <div id="rewardPopup" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center">
    <div class="bg-gray-800 rounded-2xl border border-yellow-500 p-8 max-w-sm w-full text-center shadow-2xl">
      <h2 class="text-3xl font-bold text-green-400 mb-2">🎉 Congratulations!</h2>
      <p class="text-gray-300 mb-4">You’ve won:</p>
      <p id="rewardText" class="text-yellow-400 text-xl font-semibold mb-6"></p>
      <button onclick="closePopup()" class="premium-button bg-yellow-400 text-gray-900 font-bold py-2 px-6 rounded-full hover:bg-yellow-300 transition">Close</button>
    </div>
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
    const rewards = [
      { text: "💸 5% Off Any Purchase", points: 10 },
      { text: "🍿 Free Movie Ticket", points: 25 },
      { text: "☕ Free Coffee Coupon", points: 20 },
      { text: "🎫 50 Bonus Points", points: 50 },
      { text: "🛍️ Free Tote Bag", points: 15 },
      { text: "🎁 100 Bonus Points", points: 100 }
    ];

    const boxesContainer = document.getElementById('boxes');
    const rewardPopup = document.getElementById('rewardPopup');
    const rewardText = document.getElementById('rewardText');

    // Create boxes dynamically
    for (let i = 0; i < 6; i++) {
      const box = document.createElement('div');
      box.className = 'box';
      box.textContent = '🎁';
      box.addEventListener('click', () => openBox(box), { once: true }); // {once: true} ensures it can only be clicked once
      boxesContainer.appendChild(box);
    }

    let boxOpened = false; // Flag to check if a box is already opened

    function openBox(box) {
      if (boxOpened) return; // Agar pehle hi box khul gaya hai, toh kuch mat karo
      boxOpened = true; // Flag set karo
      
      box.classList.add('opened');
      
      // Prize chuno
      const prize = rewards[Math.floor(Math.random() * rewards.length)];
      
      // Points save karo agar mile hain
      if (prize.points > 0) {
          savePointsToDatabase(prize.points); 
      }
      
      // Reward dikhao
      setTimeout(() => showReward(prize.text, prize.points), 800);
      
      // Baaki boxes ko disable kar do
      document.querySelectorAll('.box').forEach(b => {
          if (!b.classList.contains('opened')) {
              b.style.opacity = '0.5';
              b.style.cursor = 'not-allowed';
          }
      });
    }

    function showReward(prizeText, pointsWon) {
      if (pointsWon > 0) {
        rewardText.textContent = `${prizeText} (+${pointsWon} Points)`;
      } else {
        rewardText.textContent = `${prizeText}`;
      }
      rewardPopup.classList.remove('hidden');
    }

    function closePopup() {
      rewardPopup.classList.add('hidden');
    }
  </script>
</body>
</html>