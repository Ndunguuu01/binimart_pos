<?php
session_start();
include 'db.php';

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle the product search and add to cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Fetch product details
    $sql = "SELECT * FROM products WHERE id='$product_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        if ($product && $product['stock_quantity'] >= $quantity) {
            $total_price = $product['price'] * $quantity;

            // Add the product to session cart
            $_SESSION['cart'][] = [
                'product_id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'total_price' => $total_price
            ];

            // Update stock
            $new_stock = $product['stock_quantity'] - $quantity;
            $conn->query("UPDATE products SET stock_quantity='$new_stock' WHERE id='$product_id'");
        } else {
            echo "Insufficient stock!";
        }
    } else {
        echo "Product not found!";
    }
}

// Calculate total price
$total = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['total_price'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BiniMart POS System</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Make the navigation links appear vertically */
        nav ul {
            list-style-type: none; /* Remove bullets */
            padding: 10;
            margin: 0;
            display: flex;
        }
        nav ul li {
            margin-right: 40px; /* Add space between the links */
        }
        nav ul li a {
            text-decoration: none;
            font-size: 18px;
            color: #000; /* Customize link color */
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="shopping-cart.png" alt="BiniMart Logo">
        <h1>BiniMart POS System</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="add_product.php">Add Product</a></li>
                <li><a href="view_sales.php">View Sales</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
    <div class="container">
        <h1>Make a Sale</h1>
        <form method="POST">
            <label for="product">Scan or Enter Product ID:</label>
            <input type="number" id="product_id" name="product_id" required>
            Quantity: <input type="number" name="quantity" value="1" required><br>
            <input type="submit" value="Add to Cart">
        </form>

        <h2>Cart</h2>
        <table border="1">
            <tr>
                <th>No.</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price (per item)</th>
                <th>Total Price</th>
            </tr>
            <?php if (isset($_SESSION['cart'])): ?>
                <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo $item['price']; ?></td>
                    <td><?php echo $item['total_price']; ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            <tr>
                <td colspan="4" style="text-align:right;">Total:</td>
                <td><?php echo $total; ?></td>
            </tr>
        </table>

        <form action="generate_receipt.php" method="POST">
            <input type="submit" value="Generate Receipt">
        </form>
    </div>

</body>
</html>
