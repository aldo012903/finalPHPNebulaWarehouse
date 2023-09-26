<?php
require_once 'Transaction.cls.php';
require_once 'dbConfig.php';
session_start();
global $connection;
$transaction = new Transaction();
$transactions = $transaction->getAllTransactions($connection);
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
    <title>transactions Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/NebulaWarehouse/style.css">
</head>
<body>
    <div class="p-3">
    <div style="color:red;" id="message"></div>
        <button class="btn btn-success" onclick="location.href='add-transaction.php'">Add transaction</button>
        <table class="table">
          <thead>
            <tr>
              <th>Transaction ID</th>
              <th>User ID</th>
              <th>Product ID</th>
              <th>Quantity</th>
              <th>Transaction Time</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($transactions as $transaction) { ?>
              <tr>
                <td><?= $transaction->getTransaction_id(); ?></td>
                <td><?= $transaction->getUser_id(); ?></td>
                <td><?= $transaction->getProduct_id(); ?></td>
                <td><?= $transaction->getQuantity(); ?></td>
                <td><?= $transaction->getTransaction_time(); ?></td>
                <td class="d-flex flex-row">
                  <a href="edit-transaction.php?id=<?= $transaction->getTransaction_id() ?>" class="btn btn-primary">Edit</a>
                  <?php 
                  $transaction_id = $transaction->getTransaction_id();
                      if (isset($_POST["delete$transaction_id"])) {
                          require_once 'dbConfig.php';
                          $res = $transaction->delete($connection);
                          echo "<script>document.getElementById('message').innerHTML = '$res';</script>";
                          if($res=="Delete successfull"){
                              ?>
                             <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Transaction.php">
                             <?php
                          }
                      }
                  ?> 
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
    </div>
</body>
</html>
