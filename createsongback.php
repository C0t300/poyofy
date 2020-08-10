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

    $name = $_GET['name'];
    $genre = $_GET['genre'];
    $length = $_GET['length'];
    $date = $_GET['date'];

    $db->createSong($pdo, $name, $genre, $length, $date, $_SESSION['id']);

    

    header("Location: canciones.php");
    die();
