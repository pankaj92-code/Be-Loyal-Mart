<?php
// Step 1: Master header ko include karein
// Ye session check, points fetch, aur navigation sab kar lega
include 'php/header.php';

// Agar user logged in nahi hai, toh header.php usey pehle hi
// index.php par bhej dega.
?>

<link rel="stylesheet" href="assets/tiers-style.css" />
<title>My Tiers - Believers</title>
<h1 style="text-align: center; color: var(--accent1);">🏆 Your Loyalty Tiers</h1>
  <p style="text-align: center; color: var(--muted); margin-top: -20px; margin-bottom: 30px;">Earn more points to unlock new levels and exclusive rewards.</p>

  <section id="progress-section" class="card">
    <div class="progress-header">
        <h2>Current Progress</h2>
        <div class="points-display">Your Points: <strong><?php echo $user_points; ?></strong></div>
    </div>
    <div id="myProgress">
      <div id="myBar" style="width: 0%;">0%</div>
    </div>
    <p id="progress-info">Loading...</p>
  </section>
  <section id="level-container"></section>
  
  <div id="spin-section" class="card hidden">
    <h2>🎉 Lucky Spin Unlocked!</h2>
    <p>You've reached Level 5! Spin the wheel for a bonus reward.</p>
    <div class="wheel" id="wheel"></div>
    <button id="spin-btn" class="btn btn-primary">Spin the Wheel</button>
    <p id="result"></p>
  </div>
  </main> </div> <script>
    // === YAHAN POORA JAVASCRIPT LOGIC PASTE KIYA GAYA HAI ===
    
    // PHP se dynamic value lein
    let currentShopping = <?php echo $user_points; ?>;
    
    const totalLevels = 50;
    const maxShopping = 150000; // 150,000 points

    const levelContainer = document.getElementById('level-container');
    const spinSection = document.getElementById("spin-section");
    const wheel = document.getElementById("wheel");
    const spinBtn = document.getElementById("spin-btn");
    const resultText = document.getElementById("result");
    const progressSection = document.getElementById("progress-section");
    const progressBar = document.getElementById("myBar");
    const progressInfo = document.getElementById("progress-info");

    let levels = [];
    for (let i = 1; i <= totalLevels; i++) {
        const shoppingAmt = Math.round((i / totalLevels) * maxShopping);
        let reward = "";
        if (i % 5 === 0) {
            switch (i) {
                case 5: reward = "Lucky Spin Chance 🎯"; break;
                case 10: reward = "₹100 Tiffin Box"; break;
                case 15: reward = "₹200 Gift Voucher"; break;
                case 20: reward = "₹500 Shopping Coupon"; break;
                case 25: reward = "₹1000 Gift Pack"; break;
                case 30: reward = "₹2000 Gift Pack"; break;
                case 35: reward = "₹3000 Voucher"; break;
                case 40: reward = "Special Gift Box"; break;
                case 45: reward = "₹5000 Voucher"; break;
                case 50: reward = "Grand Prize + Membership 🎉"; break;
            }
        }
        levels.push({ level: i, shoppingTarget: shoppingAmt, reward });
        
        // Card HTML
        const levelDiv = document.createElement('div');
        levelDiv.classList.add('level-card'); // Nayi class
        if (reward) levelDiv.classList.add('milestone');
        if (currentShopping >= shoppingAmt) {
            levelDiv.classList.add('unlocked'); // Unlocked level ko highlight karein
        }
        
        levelDiv.innerHTML = `
            <h3>Level ${i}</h3>
            <p class="target">Target Points: <strong>${shoppingAmt.toLocaleString()}</strong></p>
            ${reward ? `<p class="reward">${reward}</p>` : ""}
        `;
        levelContainer.appendChild(levelDiv);
    }

    // Current level find karein
    let currentLevel = levels[0];
    for (let i = levels.length - 1; i >= 0; i--) {
        if (currentShopping >= levels[i].shoppingTarget) {
            currentLevel = levels[i];
            break;
        }
    }

    let nextLevel = levels.find(l => l.level === currentLevel.level + 1) || currentLevel;

    progressSection.classList.remove('hidden');

    const shoppingStart = (levels.find(l => l.level === currentLevel.level) || { shoppingTarget: 0 }).shoppingTarget;
    const shoppingEnd = nextLevel.shoppingTarget || maxShopping;
    const shoppingRange = shoppingEnd - shoppingStart;
    const shoppingProgress = currentShopping - shoppingStart;
    
    let percentProgress = 0;
    if (shoppingRange > 0) {
       percentProgress = (shoppingProgress / shoppingRange) * 100;
    } else if (currentShopping >= maxShopping) {
       percentProgress = 100; // Max level reached
    }
    
    percentProgress = percentProgress > 100 ? 100 : percentProgress < 0 ? 0 : percentProgress;

    progressBar.style.width = percentProgress + '%';
    progressBar.textContent = Math.floor(percentProgress) + '%';
    
    if (currentLevel.level === totalLevels && currentShopping >= maxShopping) {
        progressInfo.textContent = `🎉 Congratulations! You have reached the max level!`;
    } else {
        progressInfo.textContent = `You are ${shoppingEnd - currentShopping} points away from Level ${nextLevel.level}!`;
    }

    // Spin wheel dikhayein agar level 5+ hai
    if (currentLevel.level >= 5) {
        spinSection.classList.remove('hidden');
    }

    // Spin wheel logic
    const rewards = [
        "Better Luck Next Time", "Team Membership", "₹500 Shopping Coupon",
        "Extra Reward Point", "Small Gift Hamper"
    ];

    spinBtn.addEventListener("click", () => {
        const rotation = Math.ceil(Math.random() * 3600);
        wheel.style.transform = `rotate(${rotation}deg)`;
        spinBtn.disabled = true;
        resultText.textContent = "Spinning...";

        setTimeout(() => {
            const randomReward = rewards[Math.floor(Math.random() * rewards.length)];
            resultText.textContent = "You won: " + randomReward + "!";
        }, 4000);
    });
  </script>
</body>
</html>