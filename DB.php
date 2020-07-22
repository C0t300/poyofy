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

    function getIDuser($pdo, $u){
        $str = "SELECT ID_ac FROM `persona` WHERE `Username` LIKE '" . $u . "'";
        $retorno = $this->query($pdo, $str); #Name
        return $retorno[0];
    }

    #Returns array
    function getPlaylistUser($pdo, $ID){
        $str = "SELECT name, ID_pl FROM `playlists` WHERE `ID_ac` = '" . $ID . "'";
        #$q = $this->query($pdo, $str);
        $q = $pdo->prepare($str);
        $q->execute();
        $retorno = $q->fetchAll();
        return $retorno;
    }

    function getPlaylistName($pdo, $plID){
        $str = "SELECT name FROM `playlists` WHERE `ID_pl` = '" . $plID . "'";
        #$q = $this->query($pdo, $str);
        $q = $pdo->prepare($str);
        $q->execute();
        $retorno = $q->fetchAll();
        return $retorno[0][0];

    }

    function getPlaylistSongs($pdo, $plID){
        $str = "SELECT `ID-s` FROM `Playlist-Canciones` WHERE `ID_pl` = '" . $plID . "'";
        #$q = $this->query($pdo, $str);
        $q = $pdo->prepare($str);
        $q->execute();
        $retorno = $q->fetchAll();
        return $retorno;
    }

    function getSongData($pdo, $sID){
        $str = "SELECT name, genre, length, ID_AC, publ FROM `Canciones` WHERE `ID_s` = '" . $sID . "'";
        #$q = $this->query($pdo, $str);
        $q = $pdo->prepare($str);
        $q->execute();
        $retorno = $q->fetchAll();
        return $retorno;
    }

    function getSongArtist($pdo, $sID){
        $str = "SELECT ID_ac FROM `Canciones` WHERE `ID_s` = '" . $sID . "'";
        #$q = $this->query($pdo, $str);
        $q = $pdo->prepare($str);
        $q->execute();
        $retorno = $q->fetchAll();
        $acID =  $retorno[0][0];
        $str = "SELECT Name FROM `persona` WHERE `ID_ac` = '" . $acID . "'";
        #$q = $this->query($pdo, $str);
        $q = $pdo->prepare($str);
        $q->execute();
        $retorno = $q->fetchAll();
        return $retorno[0][0];
    }

    function addUser($pdo, $name, $user, $pass){

        $str = "INSERT INTO persona (Username, Password, Name) VALUES ('" . $user . "', '" . $pass . "', '" . $name . "')";
        $q = $pdo->prepare($str);
        $q->execute();

        $str = "SELECT ID_ac FROM `persona` WHERE `Username` = '" . $user . "'";
        $q = $pdo->prepare($str);
        $q->execute();
        $userID = $q->fetchAll()[0][0];
        echo $userID;

        $str = "INSERT INTO Usuario (ID_ac) VALUES ('" . $userID . "')";
        $q = $pdo->prepare($str);
        $q->execute();
        echo "done";

    }


    function checkUserAvailable($pdo, $user){
        $str = "SELECT username FROM `persona` WHERE `Username` = '" . $user . "'";
        $q = $pdo->prepare($str);
        $q->execute();
        $userID = $q->rowCount();
        if ($userID == 0){
            return True;
        }
        return False;
    }


}
?>