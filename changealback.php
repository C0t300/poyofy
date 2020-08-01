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

    $alid = $_POST['al'];
    $newname =  $_POST['name'];
    $newdate = $_POST['date'];
    $newgenre = $_POST['genre'];
    $change = "false";


    if(!empty($newname)){
        $db->updateNameAl($pdo, $alid, $newname);
        $change = "true";
    }
    if(!empty($newdate)){
        $db->updateDateAl($pdo, $alid, $newdate);
        $change = "true";
    }
    if(!empty($newgenre)){
        $db->updateGenreAl($pdo, $alid, $newgenre);
        $change = "true";
    }

    header("Location: showal.php?change=" . $change . "&id=" . $alid);
    die();
