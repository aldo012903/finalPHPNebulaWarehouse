<html>
<body>
<?php 
session_start();
if(!isset($_SESSION["USER_ID"])){
    header("Location: Login.php");
    exit();
}
    else {
        header("Location: Homepage.php");
        exit();
    }
?>
</body>
</html>