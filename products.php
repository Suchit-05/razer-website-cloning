<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Razer Products</title>
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

  <main class="products-grid">
    <?php
    $conn = mysqli_connect("localhost", "root", "", "razer_store");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<div class="product-card">';
            echo '<img src="' . $row["image"] . '" alt="' . $row["name"] . '">';
            echo '<h3>' . $row["name"] . '</h3>';
            echo '<p>$' . $row["price"] . '</p>';
           echo '<form action="add_to_cart.php" method="POST">';
echo '<input type="hidden" name="product_id" value="' . $row["id"] . '">';
echo '<button type="submit">Add to Cart</button>';
echo '</form>';


            echo '</div>';
        }
    } else {
        echo "<p>No products found.</p>";
    }

    mysqli_close($conn);
    ?>
  </main>

  <footer>&copy; 2025 Razer Inc. All rights reserved.</footer>

  <script>
    function addToCart(id, name, price) {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      
      // Check if the product already exists in the cart
      const productIndex = cart.findIndex(item => item.id === id);
      if (productIndex > -1) {
        cart[productIndex].quantity += 1;
      } else {
        cart.push({ id, name, price, quantity: 1 });
      }

      // Store updated cart back to localStorage
      localStorage.setItem('cart', JSON.stringify(cart));
      alert(name + " added to cart!");
    }
  </script>
</body>
</html>
