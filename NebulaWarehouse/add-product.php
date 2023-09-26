<?php
require_once 'Product.cls.php';
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
    <title>Add Product Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/NebulaWarehouse/style.css">
</head>
<body>
<div class="container mt-5 pt-5">
	<h2>Add Product</h2>
	<form action="" method="POST">
		<div style="color:red;" id="message"></div>
		<div class="form-group">
			<label for="product_name">Product Name:</label>
			<input type="text" class="form-control" id="product_name" name="product_name" required>
		</div>
		<div class="form-group">
			<label for="description">Description:</label>
			<textarea class="form-control" id="description" name="description" rows="3"></textarea>
		</div>
		<div class="form-group">
			<label for="price">Price:</label>
			<input type="number" class="form-control" id="price" name="price" required>
		</div>
		<button type="submit" name="submit" class="btn btn-primary">Submit</button>
	</form>
	<?php
        if(isset($_POST['submit'])) {
            $product_name = $_POST['product_name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $product = new Product();
            $product->setProduct_name($product_name);
            $product->setDescription($description);
            $product->setPrice($price);
            
            $res = $product->Create($connection);             
            if($res==1){
                echo "<script>document.getElementById('message').innerHTML = 'Product added successfully.';</script>";
                return;
            }
            echo "<script>document.getElementById('message').innerHTML = 'Error in the information provided.';</script>";
        }
    ?>
</div>

</body>
</html>
