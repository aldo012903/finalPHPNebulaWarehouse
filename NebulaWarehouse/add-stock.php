<?php
require_once 'Stock.cls.php';
require_once 'dbConfig.php';
session_start();
global $connection;
if(!isset($_SESSION["USER_ID"])){
    header("Location: Login.php");
    exit();
}
include_once 'Menu.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Stock</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/NebulaWarehouse/style.css">
</head>
<body>
<div class="container mt-5 pt-5">
    <h2>Add Stock</h2>
    <form action="" method="POST">
        <div style="color:red;" id="message"></div>
        <div class="form-group">
            <label for="product_id">Product ID:</label>
            <input type="text" class="form-control" id="product_id" name="product_id" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary background-general text-dark border-secondary">Submit</button>
    </form>
    <?php
        if(isset($_POST['submit'])) {
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            date_default_timezone_set('UTC');
            $updatetime = date('Y-m-d H:i:s');
            $stock = new Stock();
            $stock->setProduct_id($product_id);
            $stock->setQuantity($quantity);
            $stock->setUpdate_time($updatetime);
            $res = $stock->Create($connection); 
            if ($res==1) {
                echo "<script>document.getElementById('message').innerHTML = 'Stock added successfully.';</script>";
                return;
            }
            echo "<script>document.getElementById('message').innerHTML = 'Error adding stock.';</script>";
        }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
