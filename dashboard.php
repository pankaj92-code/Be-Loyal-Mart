<?php
// Step 1: Master header ko include karein
// Ye file session check, points fetch, aur navigation sab kuch kar legi
include 'php/header.php';

// Agar user logged in nahi hai, toh header.php usey pehle hi
// index.php par bhej dega (is line tak code pahuchega hi nahi)
?>

<style>
    /* Dashboard-specific styles */
    .menu-container {
      width: 100%;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 30px;
    }
    .menu-card {
      /* Hum 'card' class ka base style global-style.css se lenge */
      /* Lekin yahaan usse thoda dark aur cool banate hain */
      background: linear-gradient(145deg, #1e293b, #0f172a);
      border-color: var(--accent1);
      color: #fff;
      padding: 50px 25px;
      text-align: center;
      text-decoration: none;
      transition: all 0.3s ease;
    }
    .menu-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 10px 20px rgba(139, 92, 246, 0.3);
    }
    .card-icon {
      font-size: 55px;
      margin-bottom: 15px;
      color: var(--accent2);
    }
    .card-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 10px;
      color: #fff;
    }
    .card-desc {
      font-size: 0.9rem;
      color: #ccc;
    }
  </style>
  
  <h1 style="text-align: center; color: var(--accent1);">⚡ Main Menu Dashboard ⚡</h1>
  
  <div class="menu-container">
    <a href="tiers.php" class="card menu-card">
      <div class="card-content">
        <div class="card-icon">🏆</div>
        <div class="card-title">Tiers</div>
        <div class="card-desc">Climb up levels and unlock epic rewards.</div>
      </div>
    </a>
    <a href="game-zone.php" class="card menu-card">
      <div class="card-content">
        <div class="card-icon">🎮</div>
        <div class="card-title">Game Zone</div>
        <div class="card-desc">Play mini-games and earn bonus coins.</div>
      </div>
    </a>
    <a href="offers.php" class="card menu-card">
      <div class="card-content">
        <div class="card-icon">🎁</div>
        <div class="card-title">Offers</div>
        <div class="card-desc">Get amazing limited-time deals & bonuses.</div>
      </div>
    </a>
    <a href="food-section.php" class="card menu-card">
      <div class="card-content">
        <div class="card-icon">🛍️</div>
        <div class="card-title">Food Section</div>
        <div class="card-desc">Browse our online grocery store.</div>
      </div>
    </a>
    <a href="premium.php" class="card menu-card">
      <div class="card-content">
        <div class="card-icon">💎</div>
        <div class="card-title">Premium Membership</div>
        <div class="card-desc">Access exclusive perks & first-class benefits.</div>
      </div>
    </a>
    <a href="contact.html" class="card menu-card">
      <div class="card-content">
        <div class="card-icon">🛠️</div>
        <div class="card-title">Support</div>
        <div class="card-desc">We’re here to help you 24/7.</div>
      </div>
    </a>
  </div>

</main> </div> </body>
</html>