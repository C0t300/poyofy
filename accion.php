
<?php 

if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
include_once "DB.php";
$db = new DB();
$pdo = $db->connect();

$user = $_POST['user']; 
$pass = $_POST['pass']; 


if($db->login($pdo, $user, $pass)){

    $_SESSION['user'] = $user;
    $_SESSION['pass'] = $pass;

    header("Location: checkname.php");
    die();
}
else{
    echo "Sesion Incorrecta ", "<br>    ";
    echo "<a href='index.php'>Volver al Inicio de Sesion</a>";
}
