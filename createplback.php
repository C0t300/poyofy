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
    $desc = $_GET['desc'];

    $db->createPlaylist($pdo, $name, $desc, $_SESSION['id']);

    

    header("Location: myprofile.php");
    die();
