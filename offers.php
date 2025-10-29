<?php
// Master header ko include karein
include 'php/header.php';
?>

<link rel="stylesheet" href="assets/offers-style.css" />
<title>Exclusive Offers - Believers</title>

<h1 style="text-align: center; color: var(--accent1);">🎁 Exclusive Offers & Rewards</h1>
  <p style="text-align: center; color: var(--muted); margin-top: -20px; margin-bottom: 30px;">Welcome, <?php echo htmlspecialchars($user_name); ?>! Here are your available offers.</p>

  <div class="controls">
    <button class="btn" id="toggleDouble" type="button">Enable Double Points</button>
    <div class="small">Double points apply during special events / slow seasons</div>
  </div>

  <section class="cards-grid">
    
    <article class="card offer-card">
      <div class="ribbon">Celebrate!</div>
      <h3>Birthday & Anniversary Rewards</h3>
      <p>Celebrate with us — get a special coupon, extra points, or a surprise voucher on your birthday / anniversary.</p>
      <div class="badge">Verified: once per year</div>
    </article>

    <article class="card offer-card">
      <h3>Eco & Social Benefits</h3>
      <p>Support sustainable choices: choose eco-packaging, donate points to social causes, or claim special eco-coupons.</p>
      <div class="badge">Choose green — get bonus points</div>
    </article>

    <article class="card offer-card">
      <h3>Milestone Rewards — 10th Order</h3>
      <p>Hit your 10th completed order and unlock cashback between <strong>Rs 200</strong> and <strong>Rs 2000</strong>.</p>
      <div class="progress">
        <i id="progressBar" style="width: 30%;"></i>
      </div>
      <div class="small">Orders: <strong>3</strong>/10</div>
    </article>

    <article class="card offer-card">
      <h3>Refer & Earn</h3>
      <p>Share your code. When friends sign up, you both get rewards (credits / points / coupons).</p>
      <div class="ref-code">
        <div class="code-pill" id="refCode">BELIEVE2025</div>
        <button class="btn btn-ghost" id="copyRef" type="button">Copy</button> 
      </div>
    </article>

    <article class="card offer-card points-calc">
      <h3>Points-based Rewards</h3>
      <p>Earn points as you shop and redeem for coupons, vouchers or discounts.</p>
      <div class="points-row">
        <label class="small" for="spendInput">Enter spend (Rs):</label>
        <input id="spendInput" class="input" type="number" placeholder="100" min="0" value=""> 
        <button class="btn btn-primary" id="calcPoints" type="button">Calculate</button> 
      </div>
      <div id="pointsResult" class="small">Points: —</div>
    </article>

  </section>

</main> </div> <script>
    // Is page ki specific scripts
    const toggleBtn = document.getElementById('toggleDouble');
    let doublePoints = false;
    toggleBtn.addEventListener('click', () => {
      doublePoints = !doublePoints;
      toggleBtn.textContent = doublePoints ? 'Double Points: ON' : 'Enable Double Points';
      toggleBtn.classList.toggle('btn-primary');
    });

    document.getElementById('copyRef').addEventListener('click', async () => {
      const code = document.getElementById('refCode').textContent.trim();
      const copyBtn = document.getElementById('copyRef');
      try{ 
        await navigator.clipboard.writeText(code); 
        const originalText = copyBtn.textContent;
        copyBtn.textContent = 'Copied!';
        setTimeout(() => { copyBtn.textContent = originalText; }, 1500);
      }
      catch(e){ 
        prompt('Copy this code:', code); 
      }
    });

    const calcBtn = document.getElementById('calcPoints');
    const pointsResult = document.getElementById('pointsResult');
    calcBtn.addEventListener('click', ()=>{
      const spend = Number(spendInput.value) || 0;
      if(spend <= 0) {
        pointsResult.textContent = 'Please enter a valid spend amount.';
        return;
      }
      let base = Math.floor(spend) * 10;
      if(doublePoints) base *= 2;
      pointsResult.textContent = `Points earned: ${base} ${doublePoints ? '(double points active)' : ''}`;
    });
</script>
</body>
</html>