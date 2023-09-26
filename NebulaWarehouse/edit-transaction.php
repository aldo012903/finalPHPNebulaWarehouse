<?php
require_once 'Transaction.cls.php';
require_once 'dbConfig.php';
session_start();
global $connection;

if(!isset($_SESSION["USER_ID"])){
    header("Location: Login.php");
    exit();
}

if(!isset($_GET['id'])) {
    header("Location: Transaction.php");
    exit();
}

$transaction_id = $_GET['id'];

$transaction = new Transaction();
$transaction->setTransaction_id($transaction_id);
$transaction = $transaction->getById($connection, $transaction->getTransaction_id());

if(!$transaction->getTransaction_id()) {
    header("Location: Transactions.php");
    exit();
}

include_once 'Menu.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaction</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/NebulaWarehouse/style.css">
</head>
<body>
    <div class="container mt-5">
        <form action="" method="POST">
            <div style="color:red;" id="message"></div>
            <div class="form-group">
                <label for="user_id">User ID:</label>
                <input type="text" class="form-control" id="user_id" name="user_id" value="<?= $transaction->getUser_id() ?>" required>
            </div>
            <div class="form-group">
                <label for="product_id">Product ID:</label>
                <input type="text" class="form-control" id="product_id" name="product_id" value="<?= $transaction->getProduct_id() ?>" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="<?= $transaction->getQuantity() ?>" required>
            </div>
            <div class="form-group">
                <label for="transaction_time">Transaction Time:</label>
                <input type="datetime-local" class="form-control" id="transaction_time" name="transaction_time" value="<?= date('Y-m-d\TH:i:s', strtotime($transaction->getTransaction_time())) ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>

        <?php
        if(isset($_POST['submit'])) {
            $user_id = $_POST['user_id'];
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
            $transaction_time = date('Y-m-d H:i:s', strtotime($_POST['transaction_time']));
            $transaction = new Transaction();
            $transaction->setTransaction_id($transaction_id);
            $transaction->setUser_id($user_id);
            $transaction->setProduct_id($product_id);
            $transaction->setQuantity($quantity);
            $transaction->setTransaction_time($transaction_time);

            $res = $transaction->Update($connection);

            if($res == 1) {
                echo "<script>document.getElementById('message').innerHTML = 'Transaction updated successfully.';</script>";
                 ?> 
                 <META HTTP-EQUIV="REFRESH" CONTENT="1.5;URL=Transaction.php">
                 <?php  

            } else {
                echo "<script>document.getElementById('message').innerHTML = 'Error in the information provided.';</script>";
            }
        }
        ?>
    </div>
</body>
</html>
