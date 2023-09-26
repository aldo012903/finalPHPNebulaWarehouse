<?php
require_once 'User.cls.php';
require_once 'dbConfig.php';
session_start();
global $connection;
$user = new User();
$users = $user->getAllUsers($connection);
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
    <title>Users Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/NebulaWarehouse/style.css">
</head>
    <body>
    <div class="p-3">
        <button class="btn btn-success" onclick="location.href='add-user.php'">Add User</button>
        <table class="table">
          <thead>
            <tr>
              <th>User ID</th>
              <th>Username</th>
              <th>Email</th>
              <th>Type</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user) { ?>
              <tr>
                <td><?= $user->getUser_id(); ?></td>
                <td><?= $user->getUsername(); ?></td>
                <td><?= $user->getEmail(); ?></td>
                <td><?= $user->getType(); ?></td>
                <td class="d-flex flex-row">
                  <a href="edit-users.php?id=<?= $user->getUser_id() ?>" class="btn btn-primary">Edit</a>
                  <form method="post" action="Users.php">
                  	<?php 
                  	 if($user->getUser_id()==$_SESSION["USER_ID"] ){continue;}
                  	 if($user->getActive()==1 ){
                  	?>
                  		<button type="submit" name="deactive<?= $user->getUser_id() ?>" class="btn btn-danger delete-user">Deactivate</button>
                  	<?php }else{?>
                  		<button type="submit" name="active<?= $user->getUser_id() ?>" class="btn btn-danger active-user">Activate</button>
                 	<?php }?>
                  </form>
                  <?php 
                      $user_id = $user->getUser_id();
                      if (isset($_POST["deactive$user_id"])) {
                          require_once 'dbConfig.php';
                          if($user->deactive($connection)==1){
                              ?>
                             <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Users.php">
                             <?php
                          }
                      }
                      if (isset($_POST["active$user_id"])) {
                          if($user->activate($connection)==1){
                              ?>
                             <META HTTP-EQUIV="REFRESH" CONTENT="0;URL=Users.php">
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

   