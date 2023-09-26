<?php
require_once 'Stock.cls.php';
require_once 'dbConfig.php';
session_start();
global $connection;
$stock = new Stock();
$stocks = $stock->getAllStocks($connection);
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
    <title>Stock Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/NebulaWarehouse/style.css">
</head>
<body>
    <div class="p-3">
    <div style="color:red;" id="message"></div>
        <button class="btn btn-success" onclick="location.href='add-stock.php'">Add Stock</button>
        <table class="table">
          <thead>
            <tr>
              <th>Stock ID</th>
              <th>Product ID</th>
              <th>Quantity</th>
              <th>Update Time</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($stocks as $stock) { ?>
              <tr>
                <td><?= $stock->getStock_id(); ?></td>
                <td><?= $stock->getProduct_id(); ?></td>
                <td><?= $stock->getQuantity(); ?></td>
                <td><?= $stock->getUpdate_time(); ?></td>
                <td class="d-flex flex-row">
                  <a href="edit-stock.php?id=<?= $stock->getStock_id() ?>" class="btn btn-primary">Edit</a>
                  <form method="post">
                      <button type="submit" name="delete<?= $stock->getStock_id() ?>" class="btn btn-danger delete-stock">Delete</button>
                  </form>
                  <?php 
                    $stock_id = $stock->getStock_id();
                      if (isset($_POST["delete$stock_id"])) {
                          require_once 'dbConfig.php';
                          $res = $stock->delete($connection);
                          echo "<script>document.getElementById('message').innerHTML = '$res';</script>";
                          if($res=="Delete successfull"){
                              echo "<script>
                              const myBtn = document.getElementById('Stock')
                              myBtn.click()
                              </script>";
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
