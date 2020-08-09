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

    function addArtist($pdo, $name, $user, $pass){

        $str = "INSERT INTO persona (Username, Password, Name) VALUES ('" . $user . "', '" . $pass . "', '" . $name . "')";
        $q = $pdo->prepare($str);
        $q->execute();

        $str = "SELECT ID_ac FROM `persona` WHERE `Username` = '" . $user . "'";
        $q = $pdo->prepare($str);
        $q->execute();
        $userID = $q->fetchAll()[0][0];
        echo $userID;

        $str = "INSERT INTO artista (ID_ac) VALUES ('" . $userID . "')";
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

    function searchSongs($pdo, $string){
        $query = $string;
        $min_length = 1;
        if(strlen($query) >= $min_length){ 
            $query = htmlspecialchars($query); 
            $str = "SELECT ID_s FROM Canciones WHERE (`name` LIKE '%".$query."%')";
            $q = $pdo->prepare($str);
            $q->execute();
            $numResults = $q->rowCount();
            $lista = [];
            if($numResults > 0){ // if one or more rows are returned do following
                $cont = 0;
                while($cont < $numResults){
                    array_push($lista, $q->fetchColumn(0));
                    $cont++;
                }
                return $lista;  
            }
            else{ // if there is no matching rows do following
                return [];
            }
        }
        else{ // if query length is less than minimum
            return [];
        }
    }

    function getAllSongs($pdo){
        $str = "SELECT `ID_s` FROM `Canciones`";
        #$q = $this->query($pdo, $str);
        $q = $pdo->prepare($str);
        $q->execute();
        $retorno = $q->fetchAll();
        return $retorno;
    }

    function isArtist($pdo, $ID){
        $str = "SELECT * FROM `artista` WHERE `ID_ac`=" . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
        $lineas = $q->rowCount();
        if ($lineas > 0){
            return true;
        }
        return false;
    }

    function getBio($pdo, $ID){
        $str = "SELECT `bio` FROM `artista` WHERE `ID_ac`=" . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
        $retorno = $q->fetch();
        return $retorno[0];
    }

    function getAlbums($pdo, $ID){
        $str = "SELECT `ID_al` FROM `albumes` WHERE `ID_ac` =" . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
        $am = $q->rowCount();
        $retorno = $q->fetchAll();
        $lista = [];
        if($am > 0){
            foreach($retorno as $item){
                array_push($lista, $item[0]);
            }
        }
        return $lista;
    }

    #ID_al, nombre, canciones, genero, id_ac, fecha
    function getAlbumDetail($pdo, $ID){
        $str = "SELECT * FROM `albumes` WHERE `ID_al` =" . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
        $am = $q->rowCount();
        $retorno = $q->fetch();
        return $retorno;
    }

    function updateUser($pdo, $ID, $newuser){
        $str = "UPDATE persona SET Username = '" . $newuser . "' WHERE ID_ac = " . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function updateName($pdo, $ID, $newname){
        $str = "UPDATE persona SET Name = '" . $newname . "' WHERE ID_ac = " . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function updatePass($pdo, $ID, $newpass){
        $str = "UPDATE persona SET Password = '" . $newpass . "' WHERE ID_ac = " . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function updateBio($pdo, $ID, $newbio){
        $str = "UPDATE artista SET bio = '" . $newbio . "' WHERE ID_ac = " . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function getPlaylistData($pdo, $ID){ #ID_pl, name, descr, id_ac
        $str = "SELECT * FROM `playlists` WHERE `ID_pl` =" . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
        $retorno = $q->fetch();
        return $retorno;
    }

    function deleteAlbum($pdo, $ID){
        $str = "DELETE FROM albumes WHERE ID_al =" . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function getSongAlbum($pdo, $ID){
        $str = "SELECT ID_al FROM `Canciones` WHERE `ID_s` =" . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
        $retorno = $q->fetch();
        return $retorno[0];
    }

    function getAlbumSongs($pdo, $ID){
        $str = "SELECT * FROM `Canciones` WHERE `ID_al` = '" . $ID . "'";
        #$q = $this->query($pdo, $str);
        $q = $pdo->prepare($str);
        $q->execute();
        $retorno = $q->fetchAll();
        return $retorno;
    }

    function deleteFromAlbum($pdo,$ID){
        $str = "UPDATE `Canciones` SET `ID_al` = NULL WHERE `Canciones`.`ID_s` = ". $ID . "";
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function deleteFromPlaylist($pdo,$ID){
        $str = "DELETE FROM `Playlist-Canciones` WHERE `ID-s` = " . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function updateNamePl($pdo, $ID, $newname){
        $str = "UPDATE playlists SET name = '" . $newname . "' WHERE ID_pl = " . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function updateDescPl($pdo, $ID, $newdesc){
        $str = "UPDATE playlists SET descr = '" . $newdesc . "' WHERE ID_pl = " . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function updateNameAl($pdo, $ID, $newname){
        $str = "UPDATE albumes SET nombre = '" . $newname . "' WHERE ID_al = " . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function updateDateAl($pdo, $ID, $newdate){
        $str = "UPDATE albumes SET fecha = '" . $newdate . "' WHERE ID_al = " . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function updateGenreAl($pdo, $ID, $newgenre){
        $str = "UPDATE albumes SET genero = '" . $newgenre . "' WHERE ID_al = " . $ID;
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function addToPlaylist($pdo, $idpl, $ids){
        $str = "INSERT INTO `Playlist-Canciones`(`ID_pl`, `ID-s`) VALUES (" . $idpl . "," . $ids . ")";
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function searchSongsArtist($pdo, $string, $IDac){
        $query = $string;
        $min_length = 1;
        if(strlen($query) >= $min_length){ 
            $query = htmlspecialchars($query); 
            $str = "SELECT ID_s FROM Canciones WHERE (`name` LIKE '%".$query."%') AND (`ID_ac` = " . $IDac . ")";
            $q = $pdo->prepare($str);
            $q->execute();
            $numResults = $q->rowCount();
            $lista = [];
            if($numResults > 0){ // if one or more rows are returned do following
                $cont = 0;
                while($cont < $numResults){
                    array_push($lista, $q->fetchColumn(0));
                    $cont++;
                }
                return $lista;  
            }
            else{ // if there is no matching rows do following
                return [];
            }
        }
        else{ // if query length is less than minimum
            return [];
        }
    }

    function addToAlbum($pdo, $idal, $ids){
        $str = "UPDATE `Canciones` SET `ID_al` = " . $idal . " WHERE `Canciones`.`ID_s` = " . $ids . ";";
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function playlistFollowed($pdo, $ID){
        $str = "SELECT `ID_pl` FROM `persona-playlist` WHERE `ID_ac` =" . $ID;
        #$q = $this->query($pdo, $str);
        $q = $pdo->prepare($str);
        $q->execute();
        $retorno = $q->fetchAll();
        return $retorno;
    }

    #array
    #ID_pl, name, descr, ID_ac
    function getAllPlaylists($pdo){
        $str = "SELECT * FROM `playlists`"; 
        #$q = $this->query($pdo, $str);
        $q = $pdo->prepare($str);
        $q->execute();
        $retorno = $q->fetchAll();
        return $retorno;
    }

    function isFollowing($pdo, $pl, $idac){
        $str = "SELECT * FROM `persona-playlist` WHERE `ID_ac` = " . $idac . " AND `ID_pl` = " . $pl . "";
        $q = $pdo->prepare($str);
        $q->execute();
        $cant = $q->rowCount();
        if ($cant > 0){
            return true;
        }
        return false;
    }

    function followPlaylist($pdo, $pl, $idac){
        $str = "INSERT INTO `persona-playlist` (`ID_ac`, `ID_pl`) VALUES ('" . $idac . "', '" . $pl . "')";
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function unfollowPlaylist($pdo, $pl, $idac){
        $str = "DELETE FROM `persona-playlist` WHERE `persona-playlist`.`ID_ac` = " . $idac . " AND `persona-playlist`.`ID_pl` = " . $pl;
        $q = $pdo->prepare($str);
        $q->execute();
    }
    
    function isLiked($pdo, $songid, $idac){
        $str = "SELECT * FROM `Usuario-Canciones` WHERE `ID_ac` = " . $idac . " AND `ID_s` =" . $songid;
        $q = $pdo->prepare($str);
        $q->execute();
        $cant = $q->rowCount();
        if ($cant > 0){
            return true;
        }
        return false;
    }

    function getLikedSongs($pdo, $idac){
        $str = "SELECT `ID_s` FROM `Usuario-Canciones` WHERE `ID_ac` =" . $idac;
        $q = $pdo->prepare($str);
        $q->execute();
        $retorno = $q->fetchAll();
        return $retorno;
    }

    function likeSong($pdo, $idac, $idsong){
        $str = "INSERT INTO `Usuario-Canciones` (`ID_ac`, `ID_s`) VALUES (" . $idac . ", '" . $idsong . "')";
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function unlikeSong($pdo, $idac, $idsong){
        $str = "DELETE FROM `Usuario-Canciones` WHERE `Usuario-Canciones`.`ID_ac` = " . $idac . " AND `Usuario-Canciones`.`ID_s` = " . $idsong;
        $q = $pdo->prepare($str);
        $q->execute();
    }

    function getAmmountFollowers($pdo, $idpl){
        $str = "SELECT * FROM `persona-playlist` WHERE `ID_pl` = " . $idpl;
        $q = $pdo->prepare($str);
        $q->execute();
        return $q->rowCount();
    }

    

}