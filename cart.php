<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "razer_store");
if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}

// Handle quantity update or remove item actions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['update_quantity'], $_POST['cart_id'], $_POST['quantity'])) {
        $cart_id = (int)$_POST['cart_id'];
        $quantity = (int)$_POST['quantity'];
        if ($quantity > 0) {
            $update_sql = "UPDATE cart SET quantity = $quantity WHERE id = $cart_id";
            mysqli_query($conn, $update_sql);
        } else {
            $delete_sql = "DELETE FROM cart WHERE id = $cart_id";
            mysqli_query($conn, $delete_sql);
        }
    }
    if (isset($_POST['remove_item'], $_POST['cart_id'])) {
        $cart_id = (int)$_POST['cart_id'];
        $delete_sql = "DELETE FROM cart WHERE id = $cart_id";
        mysqli_query($conn, $delete_sql);
    }
    header("Location: cart.php");
    exit();
}

// Fetch cart items with product details
$sql = "SELECT c.id AS cart_id, p.id AS product_id, p.name, p.price, p.image, c.quantity 
        FROM cart c 
        JOIN products p ON c.product_id = p.id";
$result = mysqli_query($conn, $sql);

$cart_items = [];
$total = 0;
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = $row;
        $total += $row['price'] * $row['quantity'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Your Cart</title>
  <link rel="stylesheet" href="styles.css" />
  <style>
    .cart-item {
      border-bottom: 1px solid #ddd;
      padding: 10px 0;
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .cart-item img {
      width: 80px;
      height: auto;
    }
    .cart-item-details {
      flex-grow: 1;
    }
    .cart-item-actions form {
      display: inline-block;
      margin-right: 10px;
    }
  </style>
</head>
<body>
<header>
  <div class="logo"><img src="razer-logo.jpeg" alt="Razer Logo" /> Razer Store</div>
  <nav>
    <a href="index.php">Home</a>
    <a href="products.php">Products</a>
    <a href="about.php">About</a>
    <a href="contact.php">Contact</a>
    <a href="cart.php">Cart 🛒</a>
  </nav>
</header>

<main class="cart-page">
  <h1>Your Shopping Cart</h1>

  <?php if (empty($cart_items)): ?>
    <p>Your cart is empty.</p>
  <?php else: ?>
    <?php foreach ($cart_items as $item): ?>
      <div class="cart-item">
        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" />
        <div class="cart-item-details">
          <h3><?php echo htmlspecialchars($item['name']); ?></h3>
          <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
          <p>Quantity: <?php echo (int)$item['quantity']; ?></p>
          <p>Subtotal: $<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
        </div>
        <div class="cart-item-actions">
          <form method="POST" style="display:inline-block;">
            <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>" />
            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" style="width:50px;" />
            <button type="submit" name="update_quantity">Update</button>
          </form>

          <form method="POST" style="display:inline-block;">
            <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>" />
            <button type="submit" name="remove_item" onclick="return confirm('Remove this item?')">Remove</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>

    <h3>Total: $<?php echo number_format($total, 2); ?></h3>
    <button onclick="window.location.href='checkout.php'">Checkout</button>
  <?php endif; ?>
</main>

<footer>&copy; 2025 Razer Inc. All rights reserved.</footer>
</body>
</html>
