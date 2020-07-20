<!DOCTYPE html>
<?php
    include_once "DB.php";
    $db = new DB();
    $pdo = $db->connect();
?>

<html>  
<head>
    <title>Bienvenido a Poyofy!</title>
</head>
<body>
    <h1>Index</h1>

    <form action="accion.php" method="post">
    <p>Username: <input type="text" name="nombre" /></p>
    <p>Password: <input type="text" name="edad" /></p>
    <p><input type="submit" /></p>
    </form>

    

    
</body>
</html>