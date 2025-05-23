<?php
$conn = mysqli_connect("localhost", "root", "", "razer_store");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cart_id"])) {
    $cart_id = (int)$_POST["cart_id"];
    
    $sql = "DELETE FROM cart WHERE id = $cart_id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: cart.php");
        exit();
    } else {
        echo "Error removing from cart: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
