<?php
// Step 1: Master header ko include karein
include 'php/header.php';

// Agar user logged in nahi hai, toh header.php usey pehle hi index.php par bhej dega.
?>

<link rel="stylesheet" href="assets/game-zone-style.css" />
<title>Game Zone - Believers</title>
<div class="game-zone-container">
    <div class="how-it-works card">
      <h2>🧩 How It Works</h2>
      <ol>
        <li>Play daily games from the list below.</li>
        <li>Earn points or cash credits instantly.</li>
        <li>Redeem your points for wallet balance or mall offers.</li>
        <li>Repeat daily to unlock higher levels!</li>
      </ol>
    </div>

    <h2 class="game-grid-title">🎲 Available Games</h2>
    
    <div class="game-list">
      <a href="games/emoji-guess.php" class="game-card card">
        <h3>Emoji Guess Game</h3>
        <p>Decode emojis to guess the shop/brand.</p>
        <p class_="reward">💰 Earn <b>10 points</b> per correct answer.</p>
        <span class="play-btn btn btn-ghost">Play Now</span>
      </a>
      <a href="games/lucky-card.php" class="game-card card">
        <h3>Lucky Card Game</h3>
        <p>Scratch and win exciting mall prizes daily.</p>
        <p class_="reward">💰 Win up to <b>100 points</b> or gifts.</p>
        <span class="play-btn btn btn-ghost">Play Now</span>
      </a>
      <a href="games/memory-match.php" class="game-card card">
        <h3>Memory Match Game</h3>
        <p>Flip cards to find matching pairs quickly.</p>
        <p class_="reward">💰 Earn <b>50 points</b> for winning.</p>
        <span class="play-btn btn btn-ghost">Play Now</span>
      </a>
      <a href="games/random-box.php" class="game-card card">
        <h3>Random Box Game</h3>
        <p>Pick a mystery box to reveal a surprise reward.</p>
        <p class_="reward">💰 Win random points or gifts.</p>
        <span class="play-btn btn btn-ghost">Play Now</span>
      </a>
      <a href="games/tic-tac-toe.php" class="game-card card">
        <h3>Tic Tac Toe</h3>
        <p>Challenge the computer and win points.</p>
        <p class_="reward">💰 Win up to <b>70 points</b> for victory!</p>
        <span class="play-btn btn btn-ghost">Play Now</span>
      </a>
    </div>
  </div>

</main> </div> </body>
</html>