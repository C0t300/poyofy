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

    $songid = $_POST['songid'];
    $name =  $_POST['name'];
    $genre = $_POST['genre'];
    $date = $_POST['date'];
    $length = $_POST['length'];


    if(!empty($name)){
        $db->updateNameSong($pdo, $songid, $name);
        $change = "true";
    }
    if(!empty($genre)){
        $db->updateGenreSong($pdo, $songid, $genre);
        $change = "true";
    }
    if(!empty($date)){
        $db->updateDateSong($pdo, $songid, $date);
        $change = "true";
    }
    if(!empty($length)){
        $db->updateLengthSong($pdo, $songid, $length);
        $change = "true";
    }

    header("Location: canciones.php");
    die();
