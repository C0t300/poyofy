<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <?php

        if(!isset($_SESSION)) 
        { 
            session_start(); 
        }

        if($_SESSION['name'] == ""){
            header("Location: checkname.php");  
        }

        include_once "DB.php";
        $db = new DB();
        $pdo = $db->connect();
        $data = $db->getPlaylistData($pdo, $_GET['pl']);
        #ID_pl, name, descr, id_ac
        $plname = $data[1];
        $pldescr = $data[2];
        $plowner = $data[3];

        echo "<title>" . $plname . "</title>";

        $mine = "disabled";
        if ($plowner == $_SESSION['id']){
            $mine = "";
        }

        if(isset($_GET['songid'])){
            $songdel = $_GET['songid'];
            $db->deleteFromPlaylist($pdo, $songdel);
        }
        if(isset($_GET['songidadd'])){
            $songadd = $_GET['songidadd'];
            $db->addToPlaylist($pdo, $_GET['pl'], $songadd);
        }

        ?>
        

    
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="home.php">
    <img src="Poyofy.png" width="30" height="30" alt="Poyofy Icon">
    </a>
    </nav>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto"> 
        <li class="nav-item">
            <a class="nav-link" href="canciones.php">Canciones</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="playlist.php">Playlists</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="personas.php">Personas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="myprofile.php">Mi Cuenta</a>
        </li>
        </ul>
    
        <span class="nav-item navbar-text"> <?php echo "Hola, ", $_SESSION['name']?> </span>
        <a class="nav-link" href="logout.php">Log Out</a>

        <form action="search.php" method="get" class="form-inline my-2 my-lg-0" style="margin:5px;">
            <input class="form-control mr-sm-2" name="str" type="search" placeholder="Busca" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Busca!</button>
            </form>
        
    </div>
    </nav>
    <span class="border ">
        <div class="container shadow p-3 mb-5 bg-white rounded">
            <?php
            if(isset($_GET['change'])){
            
                if($_GET['change'] == "true"){
                    echo "<div class='alert alert-primary' role='alert'>
                    Modificacion efectuada.
                </div>";
                }
            }
        ?>

        <h2 class="text-center"> <?php echo $plname; ?> <br> <small class="text-muted"><?php echo $pldescr; ?></small> 
        <br> <a class="btn btn-outline-secondary btn-sm" href="changepl.php?pl= <?php echo $_GET['pl'];?>" role="button" <?php if($mine == "disabled"){ echo "style=pointer-events:none;";}?>>Modificar</a>
        <br> <a class="btn btn-outline-secondary btn-sm" href="followpl.php?pl= <?php echo $_GET['pl'];?>" role="button"> <?php if($db->isFollowing($pdo, $_GET['pl'], $_SESSION['id'])){ echo "Dejar de seguir";} else{echo "Seguir";}?></a>
         </h2>
         <p class="text-center text-secondary">Seguidores: <?php echo $db->getAmmountFollowers($pdo, $_GET['pl']); ?></p>
        
            <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Artista</th>
                <th scope="col">Duracion</th>
                <th scope="col">Genero</th>
                <th scope="col">Album</th>
                <th scope="col">Eliminar</th>
                </tr>
            </thead>

            <?php
                $cont = 0;
                $plID = $_GET['pl'];
                $arraySongs = $db->getPlaylistSongs($pdo, $plID); #name, genre, length, ID_AC, publ

                $mine = "disabled";
                if ($plowner == $_SESSION['id']){
                    $mine = "";
                }

                foreach($arraySongs as $songID){
                    $songID = $songID[0];
                    $cont++;
                    $arrayData = $db->getSongData($pdo, $songID);
                    list($name, $genre, $length, $ID_AC, $publ) = $arrayData[0];
                    $artista =  $db->getSongArtist($pdo, $songID);
                    $album = $db->getSongAlbum($pdo, $songID);
                    if(is_null($album)){
                        $album = "-";
                    }
                    else{
                        $album = $db->getAlbumDetail($pdo, $album)[1];
                    }
                    
                    $min = floor($length/60);
                    $sec = $length-($min*60);
                    echo "  <tr>
                            <th scope='row'>" . $cont . "</th>
                            <td>" . $name . "</td>
                            <td>" . $artista . "</td>
                            <td>" . $min . ":" . $sec . "</td>
                            <td>" . $genre . "</td>
                            <td>" . $album . "</td>
                            <form action='showpl.php?" . $_GET['pl'] . "' method='get'>
                            <input type='hidden' name='pl' value='" . $_GET['pl'] . "' >
                            <td> <button type='submit' name=songid value='" . $songID . "' class='btn btn-secondary' " . $mine . ">Eliminar</button> </td>
                            </form>
                            </tr>";
                }


            ?>
            </table>
            </div>
            </span>

            <div class="container">

            <form action="showpl.php" method="get" class="form-inline my-2 my-lg-0" style="margin:5px;">
                <input type='hidden' name='pl' value=' <?php echo $_GET['pl']; ?>' >
                <input class="form-control form-control-sm" name="search" type="search" placeholder="Busca" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0 btn-sm" type="submit">Busca!</button>
            </form>
            </br>
            
            <?php

                if(isset($_GET['search'])){
                    echo "
                    <table class='table table-sm'>
                    <thead>
                      <tr>
                        <th scope='col'>Nombre</th>
                        <th scope='col'>Artista</th>
                        <th scope='col'>Agregar</th>
                      </tr>
                    </thead>
                    <tbody>";

                    $search = $_GET['search'];

                    

                    $cont = 0;
                    $arraySongs = $db->searchSongs($pdo, $search); #name, genre, length, ID_AC, publ

                    foreach($arraySongs as $songID){
                        $songID = $songID[0];
                        $cont++;
                        $arrayData = $db->getSongData($pdo, $songID);
                        list($name, $genre, $length, $ID_AC, $publ) = $arrayData[0];
                        $artista =  $db->getSongArtist($pdo, $songID);
                        
                        $min = floor($length/60);
                        $sec = $length-($min*60);
                        echo "  <tr>
                                <td>" . $name . "</td>
                                <td>" . $artista . "</td>
                                <form action='showpl.php' method='get'>
                                <input type='hidden' name='pl' value='" . $_GET['pl'] . "'>
                                <td> <button type='submit' name='songidadd' value='" . $songID . "' class='btn btn-secondary' " . $mine . ">Agregar</button> </td>
                                </form>
                                </tr>";
                                
                    }
                    

                    echo "</tbody>
                        </table>";
                }

            ?>
            
            </div>
            



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>