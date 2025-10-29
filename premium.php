<?php
// Master header ko include karein
include 'php/header.php';
?>

<link rel="stylesheet" href="assets/premium-style.css" />
<title>Premium Access - Believers</title>

<div class="premium-container card">
    <header class="text-center">
      <h1 class="premium-gradient">Elite Premium Access</h1>
      <p>
        Welcome, <?php echo htmlspecialchars($user_name); ?>! Experience unparalleled access to advanced features, exclusive rewards, and premium benefits.
      </p>
    </header>

    <section class="benefits-grid">
      <div class="benefit-card">
        <span class="icon">🌟</span>
        <h3>Comprehensive Content Library</h3>
        <p>Access exclusive articles, video courses, and specialized resources.</p>
      </div>
      <div class="benefit-card">
        <span class="icon">🤝</span>
        <h3>Exclusive Community</h3>
        <p>Participate in private forums and collaborate with industry experts.</p>
      </div>
      <div class="benefit-card">
        <span class="icon">🏷</span>
        <h3>Member-Only Discounts</h3>
        <p>Enjoy special pricing across all products, events, and partner services.</p>
      </div>
      <div class="benefit-card">
        <span class="icon">🚀</span>
        <h3>Priority Early Access</h3>
        <p>Be the first to experience beta features and newly released content.</p>
      </div>
      <div class="benefit-card">
        <span class="icon">📞</span>
        <h3>Dedicated Priority Support</h3>
        <p>Receive expedited and personalized assistance from our expert team.</p>
      </div>
      <div class="benefit-card">
        <span class="icon">🎁</span>
        <h3>Curated Exclusive Rewards</h3>
        <p>Gain access to limited-edition perks and bespoke member rewards.</p>
      </div>
    </section>

    <div class="text-center">
      <button onclick="openPopup()" class="btn btn-primary premium-button">
        Join Premium Today
      </button>
    </div>
  </div>
  
  <div id="popupModal" class="modal">
    <div class="modal-content">
      <button onclick="closePopup()" class="close">&times;</button>
      <h2 style="color: var(--accent1);">Subscribe to Premium 🚀</h2>
      <form action="#" method="POST" class="form">
        <div>
          <label for="email">Registered Email ID:</label>
          <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_email ?? ''); ?>" required class="input">
        </div>
        <div>
          <label for="name">Registered Name:</label>
          <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user_name); ?>" required class="input">
        </div>
        <div>
          <label for="profileId">Registered Profile ID:</label>
          <input type="text" id="profileId" name="profileId" value="<?php echo $user_id; ?>" readonly class="input" style="background: var(--border);">
        </div>
        <input type="submit" value="Activate Premium" class="btn btn-primary">
      </form>
    </div>
  </div>

</main> </div> <script>
    // Is page ki specific scripts
    function openPopup() {
      document.getElementById('popupModal').classList.add('show');
    }
    function closePopup() {
      document.getElementById('popupModal').classList.add('show');
    }
    // Modal close logic header.php se aa raha hai
</script>
</body>
</html>