<?php 

        if(!isset($_SESSION)) 
            { 
                session_start(); 
            }
        include_once "DB.php";
        $db = new DB();
        $pdo = $db->connect();

        $songid = $_GET['songid'];

        if($db->isLiked($pdo, $songid, $_SESSION['id'])){
            $db->unlikeSong($pdo, $_SESSION['id'], $songid);
        }
        else{
            $db->likeSong($pdo, $_SESSION['id'], $songid);
        }

        header("Location: canciones.php");