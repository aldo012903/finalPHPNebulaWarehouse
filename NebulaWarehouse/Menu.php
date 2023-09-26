<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Menu</title>
  <!-- Bootstrap CSS link -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="Homepage.php">Menu</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarNav">
    <ul class="navbar-nav">
      <?php 
      session_start();
      if($_SESSION["TYPE"] == "admin" || $_SESSION["TYPE"] == "warehouse"): ?>
        <li class="nav-item">
          <a class="nav-link" id="Stock" href="Stock.php">Stock</a>
        </li>
      <?php endif; ?>
      <?php if($_SESSION["TYPE"] == "admin"): ?>
        <li class="nav-item">
          <a class="nav-link" id="User" href="Users.php">Users</a>
        </li>
      <?php endif; ?>
      <?php if($_SESSION["TYPE"] == "admin"): ?>
        <li class="nav-item">
          <a class="nav-link" id="Product" href="Product.php">Product</a>
        </li>
      <?php endif; ?>
      <?php if($_SESSION["TYPE"] == "admin" || $_SESSION["TYPE"] == "sales" ): ?>
      <li class="nav-item">
        <a class="nav-link" href="Transaction.php">Transactions</a>
      </li>
      <?php endif; ?>
    </ul>
    <div class="d-flex flex-row">
    	<div class="mx-3 d-flex flex-row">
    		Username:&nbsp;
    		<div id="username">
    			UNDEFINED
    		</div>
    	</div>
    	<div class="mx-3 d-flex flex-row">
    		Position:&nbsp;
    		<div id="position">
    			UNDEFINED
    		</div>
    	</div>
    	<div>
    		<a href='destroySession.php'>Log Out</a>
    	</div>
    	<?php 
    	   if(isset($_SESSION["USER_ID"])){
    	       $username = $_SESSION["USERNAME"];
    	       $type = $_SESSION["TYPE"];
    	       echo "<script>document.getElementById('username').innerHTML = '$username';</script>";
    	       echo "<script>document.getElementById('position').innerHTML = '$type';</script>";
    	   }
    	?>
    </div>
  </div>
</nav>

</body>
</html>
