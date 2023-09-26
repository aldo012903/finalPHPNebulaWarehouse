<?php
require_once 'Product.cls.php';
require_once 'dbConfig.php';

session_start();
global $connection;
if(!isset($_SESSION["USER_ID"])){
    header("Location: Login.php");
    exit();
}

if(!isset($_GET['id'])) {
    header("Location: Products.php");
    exit();
}

$product_id = $_GET['id'];

$product = new Product();
$product->setProduct_id($product_id);
$product = $product->getById($connection, $product->getProduct_id());

if(!$product->getProduct_id()) {
    header("Location: Products.php");
    exit();
}

include_once 'Menu.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/NebulaWarehouse/style.css">
</head>
<body>
    <div class="container mt-5">
    	<h2>Edit Product</h2>
        <form action="" method="POST">
            <div style="color:red;" id="message"></div>
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?= $product->getProduct_name() ?>" required>
            </div>
            <div class="form-group">
                <label for="product_description">Product Description:</label>
                <input type="text" class="form-control" id="product_description" name="product_description" value="<?= $product->getDescription() ?>" required>
            </div>
            <div class="form-group">
                <label for="unit_price">Unit Price:</label>
                <input type="number" class="form-control" id="unit_price" name="unit_price" value="<?= $product->getPrice() ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>

        <?php
        if(isset($_POST['submit'])) {
            $product_name = $_POST['product_name'];
            $product_description = $_POST['product_description'];
            $unit_price = $_POST['unit_price'];
            $product = new Product();
            $product->setProduct_id($product_id);
            $product->setProduct_name($product_name);
            $product->setDescription($product_description);
            $product->setPrice($unit_price);

            $res = $product->Update($connection);

            if($res == 1) {
                echo "<script>document.getElementById('message').innerHTML = 'Product updated successfully.';</script>";
                ?> 
                <META HTTP-EQUIV="REFRESH" CONTENT="1.5;URL=Product.php">
                <?php  

            } else {
                echo "<script>document.getElementById('message').innerHTML = 'Error in the information provided.';</script>";
            }
        }
        ?>
    </div>
</body>
</html>