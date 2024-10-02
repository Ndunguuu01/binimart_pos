<?php
session_start();
include 'db.php';

$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';

$sql = "SELECT sales.id, products.name, sales.quantity, sales.total_price, sales.timestamp 
        FROM sales 
        JOIN products ON sales.product_id = products.id";

if (!empty($start_date) && !empty($end_date)) {
    $sql .= " WHERE sales.timestamp BETWEEN '$start_date' AND '$end_date'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Sales</title>
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
        <h1>Sales Records</h1>
        <form method="POST">
            Start Date: <input type="date" name="start_date" value="<?php echo $start_date; ?>"><br>
            End Date: <input type="date" name="end_date" value="<?php echo $end_date; ?>"><br>
            <input type="submit" value="Filter Sales">
        </form>

        <table border="1">
            <tr>
                <th>Sale ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Timestamp</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo $row['total_price']; ?></td>
                <td><?php echo $row['timestamp']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
