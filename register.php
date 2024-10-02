<?php
session_start();
include 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, password_hash, role) VALUES ('$username', '$password', '$role')";
    if($conn->query($sql) === TRUE ){
        echo "user registered successfully!";
    }else{
      echo "Error: " .$sql . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="header">
        <img src="images/shopping-cart-icon.png" alt="BiniMart Logo">
        <h1>BiniMart POS System</h1>
    </div>
    <div class="container">
        <h1>Register</h1>
        <form method="POST">
            Username: <input type="text" name="username" required><br>
            Password: <input type="password" name="password" required><br>
            Role: <select name="role">
                <option value="cashier">Cashier</option>
                <option value="manager">Manager</option>
            </select><br>
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>