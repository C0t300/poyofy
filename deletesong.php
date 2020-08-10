<?php 

        if(!isset($_SESSION)) 
            { 
                session_start(); 
            }
        include_once "DB.php";
        $db = new DB();
        $pdo = $db->connect();

        $songid = $_GET['songid'];

        $db->deleteSong($pdo, $songid);

        header("Location: canciones.php");