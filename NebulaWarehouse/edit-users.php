<?php
require_once 'User.cls.php';
require_once 'dbConfig.php';
session_start();
global $connection;


if(!isset($_SESSION["USER_ID"])){
    header("Location: Login.php");
    exit();
}

if(!isset($_GET['id'])) {
    header("Location: Users.php");
    exit();
}

$user_id = $_GET['id'];


$user = new User();
$user->setUser_id($user_id);
$user = $user->getById($connection, $user_id);


if(!$user->getUser_id()) {
    header("Location: Users.php");
    exit();
}

include_once 'Menu.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/NebulaWarehouse/style.css">
</head>
<body>
    <div class="container mt-5">
    <h2>Edit Users</h2>
        <form action="" method="POST">
            <div style="color:red;" id="message"></div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $user->getUsername() ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $user->getEmail() ?>" required>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="">-- Select Type --</option>
                    <option value="Admin" <?php if($user->getType() == 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="Manager" <?php if($user->getType() == 'manager') echo 'selected'; ?>>Manager</option>
                    <option value="Employee" <?php if($user->getType() == 'employee') echo 'selected'; ?>>Employee</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>

        <?php
        if(isset($_POST['submit'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $type = $_POST['type'];
            $user = new User();
            $user->setUser_id($user_id);
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setType($type);

            $res = $user->Update($connection);

            if($res == 1) {
                echo "<script>document.getElementById('message').innerHTML = 'User updated successfully.';</script>";
                ?> 
                <META HTTP-EQUIV="REFRESH" CONTENT="1.5;URL=Users.php">
                <?php  

            } else {
                echo "<script>document.getElementById('message').innerHTML = 'Error in the information provided.';</script>";
            }
        }
        ?>
    </div>
</body>
</html>
