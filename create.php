<?php

    include_once "DB.php";
    $db = new DB();
    $pdo = $db->connect();



    $name = $_POST['name'];
    $user = $_POST['user']; 
    $pass = $_POST['pass']; 
    $tipo = $_POST['option'];

    if(!$db->checkUserAvailable($pdo, $user)){
        $message = "Usuario no Disponible, por favor intenta con otro.";
        echo "<script type='text/javascript'>alert('$message');";
        echo 'window.location.href = "createAccount.php";</script>';
    }
    elseif($tipo == "user"){
        $db->addUser($pdo, $name, $user, $pass);
        $message = "Usuario creado, inicia sesion.";
        echo "<script type='text/javascript'>alert('$message');";
        echo 'window.location.href = "index.php";</script>';
    }
    elseif($tipo == "artist"){
        $db->addArtist($pdo, $name, $user, $pass);
        $message = "Usuario creado, inicia sesion.";
        echo "<script type='text/javascript'>alert('$message');";
        echo 'window.location.href = "index.php";</script>';
    }
    else{
        $message = "Esto no deberia pasar, por favor avisa al desarrollador.";
        echo "<script type='text/javascript'>alert('$message');";
        echo 'window.location.href = "index.php";</script>';
    }

?>