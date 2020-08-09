<?php 

        if(!isset($_SESSION)) 
            { 
                session_start(); 
            }
        include_once "DB.php";
        $db = new DB();
        $pdo = $db->connect();

        $idac = $_GET['ac'];

        if($db->isFollowingAccount($pdo, $_SESSION['id'], $idac)){
            $db->unfollowac($pdo, $_SESSION['id'], $idac);
        }
        else{
            $db->followac($pdo, $_SESSION['id'], $idac);
        }

        header("Location: viewprofile.php?ac=" . $idac);