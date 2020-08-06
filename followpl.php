<?php 

        if(!isset($_SESSION)) 
            { 
                session_start(); 
            }
        include_once "DB.php";
        $db = new DB();
        $pdo = $db->connect();

        $plfollow = $_GET['pl'];

        if($db->isFollowing($pdo, $plfollow, $_SESSION['id'])){
            $db->unfollowPlaylist($pdo, $plfollow, $_SESSION['id']);
        }
        else{
            $db->followPlaylist($pdo,$plfollow, $_SESSION['id']);
        }

        header("Location: playlist.php");