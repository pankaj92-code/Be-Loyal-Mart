<?php
// Is file mein session start aur DB connection, dono hain
include 'db_connect.php';

// Check karein ki user logged in hai ya nahi
$is_logged_in = isset($_SESSION['user_id']);
$user_name = '';
$user_points = 0;

if ($is_logged_in) {
    // Agar logged in hai, toh uska data database se lein
    $user_id = $_SESSION['user_id'];
    $result = $conn->query("SELECT name, points FROM users WHERE id = $user_id");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_name = $user['name'];
        $user_points = $user['points'];
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Believers Loyalty Program</title>
  
  <link rel="stylesheet" href="assets/global-style.css" />
  
  </head>
<body>
  <div class="container">
    <header class="header">
      <a href="index.php" class="logo-link">
        <div class="logo">
          <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='160' height='52'><rect rx='12' width='160' height='52' fill='%238b5cf6'/><text x='20' y='34' font-family='Arial' font-size='20' fill='white'>Believers</text></svg>" alt="Believers logo">
          <div style="line-height:1">
            <div style="font-weight:800">Believers Loyalty</div>
            <div style="font-size:12px;color:var(--muted)">Rewards that keep you returning</div>
          </div>
        </div>
      </a>
      
      <div class="header-right">
        <nav class="nav" aria-label="Main">
          <a class="nav-link" href="index.php">Home</a>
          <a class="nav-link" href="dashboard.php">Menu</a>
          <a class="nav-link" href="contact.html">Support</a>
          <a class="nav-link" href="premium.php">Premium</a>
        </nav>
        
        <div class="auth-area">
          <?php if ($is_logged_in): ?>
            <div class="user-info">
              <span>Welcome, <strong><?php echo htmlspecialchars($user_name); ?></strong></span>
              <span class="points">Points: <strong><?php echo $user_points; ?></strong></span>
            </div>
            <a href="php/logout.php" class="btn btn-ghost">Logout</a>
          <?php else: ?>
            <button id="show-signup" class="btn btn-primary">Join</button>
            <button id="show-login" class="btn btn-ghost">Log in</button>
          <?php endif; ?>
        </div>
      </div>
    </header>
    
    <?php if (!$is_logged_in): ?>
    <div id="signup-modal" class="modal">
      <div class="modal-content">
        <button class="close" id="close-signup-modal">&times;</button>
        <h3>Create your Believers account</h3>
        <form id="quick-signup" class="form" autocomplete="off" action="php/signup.php" method="POST">
          <label>Name <input class="input" name="name" required></label>
          <label>Email <input class="input" name="email" type="email" required></label>
          <label>Password <input class="input" name="password" type="password" minlength="6" required></label>
          <div style="margin-top:16px"><button class="btn btn-primary" type="submit">Create account & Get 200 Points</button></div>
        </form>
      </div>
    </div>
    
    <div id="login-modal" class="modal">
      <div class="modal-content">
        <button class="close" id="close-login-modal">&times;</button>
        <h3>Welcome Back!</h3>
        <form id="quick-login" class="form" autocomplete="off" action="php/login.php" method="POST">
          <label>Email <input class="input" name="email" type="email" required></label>
          <label>Password <input class="input" name="password" type="password" required></label>
          <div style="margin-top:16px"><button class="btn btn-primary" type="submit">Log In</button></div>
        </form>
      </div>
    </div>
    <?php endif; ?>
    
    <main class="main-content">