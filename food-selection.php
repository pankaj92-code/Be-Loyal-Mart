<?php
// Master header ko include karein
include 'php/header.php';
?>

<link rel="stylesheet" href="assets/food-style.css" />
<title>Food Section - Believers</title>

<h1 style="text-align: center; color: var(--accent1);">🛍️ Food Section</h1>
  <p style="text-align: center; color: var(--muted); margin-top: -20px; margin-bottom: 30px;">Aapki apni online grocery store!</p>

  <main class="food-main">
    <section id="products">
      <div id="product-grid"></div>
    </section>

    <aside id="cart-container" class="card">
      <h2>🛒 Shopping Cart</h2>
      <ul id="cart-list">
        <li id="cart-empty-message">Your cart is empty.</li>
      </ul>
      <p id="cart-total">Total: ₹0.00</p>
      <button id="checkout-btn" class="btn btn-primary" disabled>Proceed to Pay</button>
    </aside>
  </main>

</main> </div> <script>
    // Is page ki specific scripts
    const groceries = [
      { id: 101, name: "Basmati Rice (1kg)", price: 120.00, emoji: "🍚" },
      { id: 102, name: "Toor Dal (500g)", price: 75.50, emoji: "🥣" },
      { id: 103, name: "MDH Garam Masala (100g)", price: 95.00, emoji: "🌶" },
      { id: 104, name: "Amul Butter (100g)", price: 55.00, emoji: "🧈" },
      { id: 105, name: "Aashirvaad Atta (5kg)", price: 299.00, emoji: "🌾" },
      { id: 106, name: "Fresh Curd/Dahi (400g)", price: 40.00, emoji: "🥛" },
      { id: 107, name: "Onions (1kg)", price: 35.00, emoji: "🧅" },
      { id: 108, name: "Potatoes (1kg)", price: 28.50, emoji: "🥔" },
    ];
    let cart = [];
    const productGrid = document.getElementById('product-grid');
    const cartList = document.getElementById('cart-list');
    const cartTotalElement = document.getElementById('cart-total');
    const checkoutBtn = document.getElementById('checkout-btn');
    const emptyCartMessage = document.getElementById('cart-empty-message');

    function renderProducts() {
      productGrid.innerHTML = '';
      groceries.forEach(item => {
        const card = document.createElement('div');
        card.className = 'product-card card'; // Global card style ka use
        card.innerHTML = `
          <span class="emoji">${item.emoji}</span>
          <h3>${item.name}</h3>
          <p>₹${item.price.toFixed(2)}</p>
          <button class="add-to-cart-btn btn btn-ghost" data-id="${item.id}">Add to Cart</button>
        `;
        productGrid.appendChild(card);
      });
    }

    function renderCart() {
      cartList.innerHTML = '';
      let total = 0;
      if (cart.length === 0) {
        emptyCartMessage.style.display = 'list-item';
        checkoutBtn.disabled = true;
        cartTotalElement.textContent = "Total: ₹0.00";
        return;
      }
      emptyCartMessage.style.display = 'none';
      checkoutBtn.disabled = false;
      cart.forEach(item => {
        const listItem = document.createElement('li');
        const itemPrice = item.price * item.quantity;
        total += itemPrice;
        listItem.innerHTML = `
          <span>${item.quantity}x ${item.name.split('(')[0].trim()}</span>
          <span>
            ₹${itemPrice.toFixed(2)}
            <button class="remove-item-btn" data-id="${item.id}" title="Remove one unit">X</button>
          </span>
        `;
        cartList.appendChild(listItem);
      });
      cartTotalElement.textContent = `Total: ₹${total.toFixed(2)}`;
    }
    
    // (Baaki JS functions... addToCart, removeFromCart...)
    function addToCart(itemId) {
      const item = groceries.find(g => g.id === itemId);
      const existingItem = cart.find(c => c.id === itemId);
      if (existingItem) { existingItem.quantity += 1; } 
      else { cart.push({ ...item, quantity: 1 }); }
      renderCart();
    }
    function removeFromCart(itemId) {
      const index = cart.findIndex(c => c.id === itemId);
      if (index !== -1) {
        if (cart[index].quantity > 1) { cart[index].quantity -= 1; } 
        else { cart.splice(index, 1); }
      }
      renderCart();
    }
    
    // Checkout Logic
    function checkout() {
      if (cart.length === 0) return;
      const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
      alert(`🎉 Success! Your payment of ₹${total.toFixed(2)} has been processed.`);
      // Yahaan hum points save kar sakte hain
      // savePointsToDatabase(Math.floor(total));
      cart = [];
      renderCart();
    }
    productGrid.addEventListener('click', (e) => {
      if (e.target.classList.contains('add-to-cart-btn')) {
        addToCart(parseInt(e.target.dataset.id));
      }
    });
    cartList.addEventListener('click', (e) => {
      if (e.target.classList.contains('remove-item-btn')) {
        removeFromCart(parseInt(e.target.dataset.id));
      }
    });
    checkoutBtn.addEventListener('click', checkout);
    renderProducts();
    renderCart();
</script>
</body>
</html>