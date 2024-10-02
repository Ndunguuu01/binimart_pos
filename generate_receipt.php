<?php
session_start();

// Check if the cart is set and not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "No items in the cart to generate a receipt.";
    exit();
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .receipt {
            width: 300px;
            margin: 0 auto;
            text-align: center;
        }
        .receipt h1 {
            border-bottom: 2px solid #000;
        }
        .receipt table {
            width: 100%;
            margin-top: 20px;
        }
        .receipt table, .receipt th, .receipt td {
            border: 1px solid #000;
            border-collapse: collapse;
        }
        .receipt th, .receipt td {
            padding: 8px;
            text-align: left;
        }
        .total {
            font-weight: bold;
        }
        .print-btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="receipt">

    <h1>BiniMart Receipt</h1>
    <p>Thank you for shopping with us!</p>
    
    <table>
        <tr>
            <th>No.</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        <?php foreach ($_SESSION['cart'] as $index => $item): ?>
        <tr>
            <td><?php echo $index + 1; ?></td>
            <td><?php echo $item['name']; ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td><?php echo $item['price']; ?></td>
            <td><?php echo $item['total_price']; ?></td>
        </tr>
        <?php $total += $item['total_price']; ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" class="total">Grand Total:</td>
            <td><?php echo "$" . number_format($total, 2); ?></td>
        </tr>
    </table>

    <button class="print-btn" onclick="window.print()">Print Receipt</button>
</div>

</body>
</html>
