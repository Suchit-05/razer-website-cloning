<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <div class="logo"><img src="razer-logo.jpeg" alt="Razer Logo"> Razer Store</div>
    <nav>
      <a href="index.php">Home</a>
      <a href="products.php">Products</a>
      <a href="about.php">About</a>
      <a href="contact.php">Contact</a>
      <a href="cart.php">Cart 🛒</a>
    </nav>
  </header>

  <main class="checkout-page">
    <h1>Checkout</h1>
    <div id="checkout-items"></div>
    <h3 id="checkout-total"></h3>
    <button onclick="completeCheckout()">Complete Checkout</button>
  </main>

  <footer>&copy; 2025 Razer Inc. All rights reserved.</footer>

  <script>
    // Load cart for checkout
    function loadCheckout() {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      const checkoutContainer = document.getElementById('checkout-items');
      const totalContainer = document.getElementById('checkout-total');
      checkoutContainer.innerHTML = '';
      
      let total = 0;
      
      cart.forEach(item => {
        const div = document.createElement('div');
        div.innerHTML = `
          <h3>${item.name}</h3>
          <p>Price: $${item.price} x ${item.quantity}</p>
        `;
        checkoutContainer.appendChild(div);
        total += item.price * item.quantity;
      });
      
      totalContainer.textContent = `Total: $${total}`;
    }

    function completeCheckout() {
      // Here you would process the order (e.g., save to database, etc.)
      alert('Checkout complete! Thank you for your purchase.');
      localStorage.removeItem('cart'); // Clear the cart
      window.location.href = 'index.php'; // Redirect to homepage
    }

    document.addEventListener('DOMContentLoaded', loadCheckout);
  </script>
</body>
</html>
