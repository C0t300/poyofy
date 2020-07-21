<?php   

class DB{

    public function connect(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "poyofy";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function query($pdo, $query){
        $stm = $pdo->query($query);

        $return = $stm->fetch();

        return $return;
    }

    public function queryNoReturn($pdo, $query){
        $stm = $pdo->query($query);
    }

    function login($pdo, $u, $p){
        $str = "SELECT ID_AC, Password FROM `persona` WHERE `Username` LIKE '" . $u . "'";
        $retorno = $this->query($pdo, $str); #ID, PASS
        if ($retorno == false){
            return False;
        }
        elseif ($p === $retorno[1]) {
            $_SESSION["ID_AC"] = $retorno[0];
            return True;
        }
        return False;
    }

    function addName($pdo, $u, $name){
        $str = "UPDATE `persona` SET `Name` = '" . $name . "' WHERE `persona`.`Username` = '" . $u . "';";
        $this->queryNoReturn($pdo, $str);
    }

    function getName($pdo, $u){
        $str = "SELECT Name FROM `persona` WHERE `Username` LIKE '" . $u . "'";
        $retorno = $this->query($pdo, $str); #Name
        return $retorno[0];
    }

    
    
}
?>