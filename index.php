<!DOCTYPE html>
<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    include_once "DB.php";
    $db = new DB();
    $pdo = $db->connect();

    if(isset($_SESSION['user'])){

        header("Location: home.php");
        die();
    }
?>

<html>  
<head>
    <title>Bienvenido a Poyofy!</title>
</head>
<body>
    <h1>Index</h1>

    <form action="accion.php" method="post">
    <p>Username: <input type="text" name="user" /></p>
    <p>Password: <input type="text" name="pass" /></p>
    <p><input type="submit" /></p>  
    </form>

    

    
</body>
</html>