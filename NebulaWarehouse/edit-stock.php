<?php
require_once 'Stock.cls.php';
require_once 'dbConfig.php';
session_start();
global $connection;

if(!isset($_SESSION["USER_ID"])){
    header("Location: Login.php");
    exit();
}

if(!isset($_GET['id'])) {
    header("Location: Stock.php");
    exit();
}

$stock_id = $_GET['id'];

$stock = new Stock();
$stock->setStock_id($stock_id);
$stock = $stock->getById($connection, $stock_id);

if(!$stock->getStock_id()) {
    header("Location: Stock.php");
    exit();
}


include_once 'Menu.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Stock Item</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/NebulaWarehouse/style.css">
</head>
<body>
    <div class="container mt-5">
    <h2>Edit Stock</h2>
        <form action="" method="POST">
            <div style="color:red;" id="message"></div>
            <div class="form-group">
                <label for="product_id">Product ID:</label>
                <input type="text" class="form-control" id="product_id" name="product_id" value="<?= $stock->getProduct_id() ?>" readonly>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="<?= $stock->getQuantity() ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>

        <?php
        if(isset($_POST['submit'])) {
            $quantity = $_POST['quantity'];
            $update_time = date('Y-m-d H:i:s');
            $stock = new Stock();
            $stock->setStock_id($stock_id);
            $stock->setQuantity($quantity);
            $stock->setUpdate_time($update_time);
            $res = $stock->Update($connection);
            if($res == 1) {
                echo "<script>document.getElementById('message').innerHTML = 'Stock item updated successfully.';</script>";
                ?> 
                <META HTTP-EQUIV="REFRESH" CONTENT="1.5;URL=Stock.php">
                <?php  
            } else {
                echo "<script>document.getElementById('message').innerHTML = 'Error in the information provided.';</script>";
            }
        }
        ?>
    </div>
</body>
</html>
