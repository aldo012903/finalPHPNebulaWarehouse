<?php
require_once 'User.cls.php';
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
    <title>Add User</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/NebulaWarehouse/style.css">
</head>
<body>
<div class="container mt-5 pt-5">
	<h2>Add User</h2>
	<form action="" method="POST">
	<div style="color:red;" id="message"></div>
		<div class="form-group">
			<label for="username">Username:</label>
			<input type="text" class="form-control" id="username" name="username" required>
		</div>
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" class="form-control" id="email" name="email" required>
		</div>
		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" class="form-control" id="password" name="password" required>
		</div>
		<div class="form-group">
			<label for="type">Type:</label>
			<select class="form-control" id="typeWork" name="typeWork" required>
				<option value="">Select Type</option>
				<option value="admin">Admin</option>
				<option value="warehouse">Warehouse</option>
				<option value="sales">Sales</option>
			</select>
		</div>
        <button type="submit" name="submit" class="btn btn-primary background-general text-dark border-secondary">Submit</button>
	</form>
	<?php
        if(isset($_POST['submit'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $type = $_POST['typeWork'];            
            $active = 1;
            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setType($type);
            $user->setActive($active);
            $res = $user->Create($connection, $password); 
            if ($res==1) {
                echo "<script>document.getElementById('message').innerHTML = 'User added successfully.';</script>";
                return;
            }
            echo "<script>document.getElementById('message').innerHTML = 'Email/Username not available.';</script>";
        }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>