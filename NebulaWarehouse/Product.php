<?php
require_once 'Product.cls.php';
require_once 'dbConfig.php';
session_start();
global $connection;
$product = new Product();
$products = $product->getAllProducts($connection);
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
    <title>Products Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/NebulaWarehouse/style.css">
</head>
<body>
    <div class="p-3">
    <div style="color:red;" id="message"></div>
        <button class="btn btn-success" onclick="location.href='add-product.php'">Add Product</button>
        <table class="table">
          <thead>
            <tr>
              <th>Product ID</th>
              <th>Product Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product) { ?>
              <tr>
                <td><?= $product->getProduct_id(); ?></td>
                <td><?= $product->getProduct_name(); ?></td>
                <td><?= $product->getDescription(); ?></td>
                <td><?= $product->getPrice(); ?></td>
                <td class="d-flex flex-row">
                  <a href="edit-products.php?id=<?= $product->getProduct_id() ?>" class="btn btn-primary">Edit</a>
                  <form method="post">
                      <button type="submit" name="delete<?= $product->getProduct_id() ?>" class="btn btn-danger delete-product">Delete</button>
                  </form>
                  <?php 
                    $product_id = $product->getProduct_id();
                      if (isset($_POST["delete$product_id"])) {
                          require_once 'dbConfig.php';
                          $res = $product->delete($connection);
                          echo "<script>document.getElementById('message').innerHTML = '$res';</script>";
                          if($res=="Delete successfull"){
                              echo "<script>
                              const myBtn = document.getElementById('Product')
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






