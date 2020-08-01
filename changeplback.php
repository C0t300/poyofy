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

    $plid = $_POST['pl'];
    $newname =  $_POST['name'];
    $newdesc = $_POST['desc'];
    $change = "false";


    if(!empty($newname)){
        $db->updateNamePl($pdo, $plid, $newname);
        $change = "true";
        $_SESSION['name'] = $newname;
    }
    if(!empty($newdesc)){
        $db->updateBio($pdo, $plid, $newdesc);
        $change = "true";
    }

    header("Location: showpl.php?change=" . $change . "&pl=" . $plid);
    die();
