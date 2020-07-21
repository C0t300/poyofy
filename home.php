<?php

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    if($_SESSION['name'] == ""){
        header("Location: checkname.php");  
    }
    
    include_once "DB.php";
    $db = new DB();
    $pdo = $db->connect();
    
    $db->addName($pdo, $_SESSION['user'], $_SESSION['name']);

    echo "Bienvenido ", $_SESSION['name'], "<br>";
    echo "<a href='logout.php'>Cerrar Sesion.</a>";