<?php

    include_once "DB.php";
    $db = new DB();
    $pdo = $db->connect();

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    if(!isset($_SESSION['user'])){
        header("Location: logout.php");
    }

    if(!isset($_SESSION['name'])){
        $DBname = $db->getName($pdo, $_SESSION['user']);
        if($DBname != ""){
            echo "DBNAME: ", $DBname, "<br>";
            $_SESSION['name'] = $DBname;
            echo "<a href='home.php'>Redirect.</a>";
            header("Location: home.php");
        }
        else{
            echo "Bienvenido, ", $_SESSION['user'], "<br>";
            echo "<form name='form' action='checknametohome.php' method='post'> <p>Ingrese su nombre: <input type='text' name='name' /></p> </form>";
            
        }
    }
    else{
        header("Location: home.php");
    }

    

