<?php
// Step 1: Master header ko include karein (isme session check aur nav sab hai)
include 'php/header.php';
?>
<section class="hero">
    <div class="card">
      <h1 class="h1">Keep customers coming back — beautifully.</h1>
      <p class="p">Believers is a modern loyalty program: points, tiers, referrals, cashback and instant rewards — all in one place. Make every purchase count.</p>
      <div class="features">
        <div class="feature"><strong>Points & Rewards</strong><div class="small">Earn points on every purchase and redeem for discounts & freebies.</div></div>
        <div class="feature"><strong>Referral Bonuses</strong><div class="small">Give and get points when friends join with your code.</div></div>
        <div class="feature"><strong>Tiered Benefits</strong><div class="small">Bronze → Silver → Gold → Platinum — unlock better perks at higher tiers.</div></div>
      </div>
      <div class="cta">
        <a class="btn btn-primary" id="cta-join-hero">Join now — free 200 points</a>
        <a class="btn btn-ghost" href="dashboard.php">See features</a>
      </div>
    </div>
    <aside class="card right-panel">
      <h3 style="margin:0">Get Started Quickly</h3>
      <p class="small">Choose how you'd like to begin your loyalty journey.</p>
      <div class="options">
        <div class="option-card" id="option-demo"><h4>Try Demo Account</h4><p>Explore with pre-loaded points and features<br> [no sign-up needed!]</p></div>
        <div class="option-card" id="option-signup-hero"><h4>Create Account</h4><p>Sign up fast! to get your welcome bonus instantly.</p></div>
      </div>
      <hr style="margin:20px 0">
      <div style="font-size:14px;color:var(--muted)">Secure sign-up, encrypted password storage, and easy rewards tracking.</div>
    </aside>
  </section>

<?php 
// (Humne footer banaya nahi hai, toh hum 'main' aur 'body' ko close karenge)
// Saare modal script ab `footer.php` (ya header.php) mein rahenge
?>
</main> </div> <script>
    // Ye script ab sirf is page ke modals ko control karegi
    // (Ye buttons sirf tab dikhenge jab user logged out hai)
    const signupModal = document.getElementById('signup-modal');
    const loginModal = document.getElementById('login-modal');

    // Header buttons (jo header.php se aa rahe hain)
    if(document.getElementById('show-signup')) {
        document.getElementById('show-signup').addEventListener('click', () => signupModal.classList.add('show'));
    }
    if(document.getElementById('show-login')) {
        document.getElementById('show-login').addEventListener('click', () => loginModal.classList.add('show'));
    }
    
    // Page content buttons
    if(document.getElementById('cta-join-hero')) {
        document.getElementById('cta-join-hero').addEventListener('click', () => signupModal.classList.add('show'));
    }
    if(document.getElementById('option-signup-hero')) {
        document.getElementById('option-signup-hero').addEventListener('click', () => signupModal.classList.add('show'));
    }

    // Modal close buttons
    if(signupModal) document.getElementById('close-signup-modal').addEventListener('click', () => signupModal.classList.remove('show'));
    if(loginModal) document.getElementById('close-login-modal').addEventListener('click', () => loginModal.classList.remove('show'));
    
    // Demo
    if(document.getElementById('option-demo')) {
        document.getElementById('option-demo').addEventListener('click', () => alert('Demo account feature will be available soon!'));
    }
</script>
</body>
</html>