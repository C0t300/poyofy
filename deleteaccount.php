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

        $db->deleteAccount($pdo, $_SESSION['id']);

        // remove all session variables
        session_unset();

        // destroy the session
        session_destroy();

        header("Location: index.php");
        die();