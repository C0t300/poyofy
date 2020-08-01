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

    $newuser = $_POST['user'];
    $newpass = $_POST['pass'];
    $newname =  $_POST['name'];
    $newbio = $_POST['bio'];
    $change = "false";


    if(!empty($newuser)){
        $db->updateUser($pdo, $_SESSION['id'], $newuser);
        $change = "true";
        $_SESSION['user'] = $newuser;
    }
    if(!empty($newpass)){
        $db->updatePass($pdo, $_SESSION['id'], $newpass);
        $change = "true";
    }
    if(!empty($newname)){
        $db->updateName($pdo, $_SESSION['id'], $newname);
        $change = "true";
        $_SESSION['name'] = $newname;
    }
    if(!empty($newbio)){
        $db->updateBio($pdo, $_SESSION['id'], $newbio);
        $change = "true";
    }

    header("Location: myprofile.php?change=" . $change);
    die();
