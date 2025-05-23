<?php
$conn = mysqli_connect("localhost", "root", "", "razer_store");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["product_id"])) {
    $product_id = (int)$_POST["product_id"];

    // Check if product is already in cart
    $check = mysqli_query($conn, "SELECT * FROM cart WHERE product_id = $product_id");

    if (mysqli_num_rows($check) > 0) {
        $sql = "UPDATE cart SET quantity = quantity + 1 WHERE product_id = $product_id";
    } else {
        $sql = "INSERT INTO cart (product_id, quantity) VALUES ($product_id, 1)";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: cart.php");
        exit();
    } else {
        echo "Error with query: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
