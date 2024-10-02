<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];

    $sql = "INSERT INTO products (name, price, stock_quantity) VALUES ('$name', '$price', '$stock_quantity')";
    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
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
        <h1>Add New Product</h1>
        <form method="POST">
            Name: <input type="text" name="name" required><br>
            Price: <input type="number" step="0.01" name="price" required><br>
            Stock Quantity: <input type="number" name="stock_quantity" required><br>
            <input type="submit" value="Add Product">
        </form>
    </div>
</body>
</html>
