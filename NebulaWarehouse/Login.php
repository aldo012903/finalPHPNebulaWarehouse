<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/NebulaWarehouse/style.css">
</head>
<body>
    	<?php 
            session_start();
            if(isset($_SESSION["USER_ID"])){
                header("Location: Homepage.php");
                exit();
            }
        ?>
	<div class="super-container d-flex justify-content-center align-items-center"  style="height:100vh;">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
					<img class="w-50 logo mb-3" src="/NebulaWarehouse/logo-transparent-png.png" />
                    <div class="card background-general">
                        <div class="card-header">
                            <h4 class="mx-auto">Login</h4>
                        </div>
                        
                        <div class="card-body">
                            <form action="" method="post">
                            	<div style="color:red;" id="message"></div>
                                <div class="form-group">
                                    <input type="text" class="form-control background-general border-top-0 border-left-0 border-right-0" id="username" name="username" placeholder="Username" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control background-general border-top-0 border-left-0 border-right-0" id="password" name="password" placeholder="Password" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary background-general text-dark border-secondary">Submit</button>
                            </form>
                            <?php
                                require_once 'dbConfig.php';
                                if(isset($_POST['submit'])) {
                                    $username = $_POST['username'];
                                    $password = $_POST['password'];
                                    $password = md5($password);
                                    global $connection;
                                    $sql = "SELECT * FROM Users WHERE username = ? AND password = ?";   
                                    
                                    $stmt = mysqli_prepare($connection, $sql);
                                    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                    if (mysqli_num_rows($result) > 0) {
                                        echo "<script>document.getElementById('message').innerHTML = 'User found!';</script>";
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if($row['active']==0){
                                                echo "<script>document.getElementById('message').innerHTML = 'Account deactivated';</script>";
                                                return;
                                            }
                                            echo "Username: " . $row['username'] . "<br>";
                                            echo "Password: " . $row['password'] . "<br>";
                                            session_start();
                                            $_SESSION["EXIST"]="Y";
                                            $_SESSION["USER_ID"]=$row['user_id'];
                                            $_SESSION["USERNAME"]=$row['username'];
                                            $_SESSION["EMAIL"]=$row['email'];
                                            $_SESSION["TYPE"]=$row['type'];
                                        }
                                        header("Location: Homepage.php");
                                        exit();
                                        return;
                                    } else {
                                        echo "<script>document.getElementById('message').innerHTML = 'Username or Password incorrect!';</script>";
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
