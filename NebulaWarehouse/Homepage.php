<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/NebulaWarehouse/style.css">
</head>
	<body>
    	<?php 
            session_start();
            if(!isset($_SESSION["USER_ID"])){
                header("Location: Login.php");
                exit();
            }
            include_once 'Menu.php';
        ?>
        <img class="w-50 logo mb-3" src="/NebulaWarehouse/logo-transparent-png.png" />
	</body>
</html>