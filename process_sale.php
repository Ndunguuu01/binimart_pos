<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Fetch product details
    $product_sql = "SELECT * FROM products WHERE id='$product_id'";
    $product_result = $conn->query($product_sql);
    $product = $product_result->fetch_assoc();

    if ($product && $product['stock_quantity'] >= $quantity) {
        $total_price = $product['price'] * $quantity;
        
        // Insert sale record
        $sale_sql = "INSERT INTO sales (product_id, quantity, total_price) VALUES ('$product_id', '$quantity', '$total_price')";
        $conn->query($sale_sql);

        // Update stock
        $new_stock = $product['stock_quantity'] - $quantity;
        $conn->query("UPDATE products SET stock_quantity='$new_stock' WHERE id='$product_id'");

        echo "Sale processed successfully! Total: $$total_price";
    } else {
        echo "Insufficient stock!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Process Sale</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="header">
        <img src="images/shopping-cart-icon.png" alt="BiniMart Logo">
        <h1>BiniMart POS System</h1>
    </div>
    <div class="container">
        <h1>Process Sale</h1>
        <form method="POST">
            Product ID: <input type="number" name="product_id" required><br>
            Quantity: <input type="number" name="quantity" required><br>
            <input type="submit" value="Process Sale">
        </form>
    </div>
</body>
</html>
