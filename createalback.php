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
    $date = $_GET['date'];

    $db->createAlbum($pdo, $name, $genre, $date, $_SESSION['id']);

    

    header("Location: myprofile.php");
    die();
