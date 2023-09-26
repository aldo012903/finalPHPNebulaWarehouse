<?php
require_once 'Transaction.cls.php';
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
    <title>Add Transaction Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/NebulaWarehouse/style.css">
</head>
<body>
<div class="container mt-5 pt-5">
	<h2>Add Transaction</h2>
	<form action="" method="POST">
		<div style="color:red;" id="message"></div>
		<div class="form-group">
			<label for="user_id">User ID:</label>
			<input type="text" class="form-control" id="user_id" name="user_id" required>
		</div>
		<div class="form-group">
			<label for="product_id">Product ID:</label>
			<input type="number" class="form-control" id="product_id" name="product_id" required>
		</div>
		<div class="form-group">
			<label for="quantity">Quantity:</label>
			<input type="number" class="form-control" id="quantity" name="quantity" required>
		</div>
		<div class="form-group">
			<label for="transaction_time">Transaction Time:</label>
			<input type="datetime-local" class="form-control" id="transaction_time" name="transaction_time" required>
		</div>
		<button type="submit" name="submit" class="btn btn-primary">Submit</button>
	</form>
	<?php
        if(isset($_POST['submit'])) {
            $user_id = $_POST['user_id'];
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $transaction_time = $_POST['transaction_time'];
            $transaction = new Transaction();
            $transaction->setUser_id($user_id);
            $transaction->setProduct_id($product_id);
            $transaction->setQuantity($quantity);
            $transaction->setTransaction_time($transaction_time);             
            $res = $transaction->Create($connection);  
            if($res==1){
                echo "<script>document.getElementById('message').innerHTML = 'Transaction added successfully.';</script>";
                return;
            }else{
                echo "<script>document.getElementById('message').innerHTML = '$res';</script>";
            }
        }
    ?>
</div>

</body>
</html>
