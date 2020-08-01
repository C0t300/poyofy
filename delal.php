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


        $idaldelete =  $_GET['id'];

        $db->deleteAlbum($pdo, $idaldelete);

        header("Location: myprofile.php?change=true");
        die();