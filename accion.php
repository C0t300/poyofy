
<?php 

include_once "DB.php";
$db = new DB();
$pdo = $db->connect();

$user = $_POST['nombre']; 
$pass = $_POST['edad']; 



echo $db->checkAccountExists($pdo, $user, $pass);
