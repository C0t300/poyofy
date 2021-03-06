<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
        $db->addName($pdo, $_SESSION['user'], $_SESSION['name']);
        $_SESSION['id'] = $db->getIDuser($pdo, $_SESSION['user']);
        ?>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Canciones</title>
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
    

            <?php
                

                if(! $_SESSION['artist']){
                    echo " <h3 class='text-center' style='margin-top: 15px;'>Liked Songs </h3>
                    <span class='border '>
                        <div class='container shadow p-3 mb-5 bg-white rounded'>
                            <table class='table '>
                            <thead class='thead-light'>
                                <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Nombre</th>
                                <th scope='col'>Artista</th>
                                <th scope='col'>Duracion</th>
                                <th scope='col'>Genero</th>
                                <th scope='col'>Unlike</th>
                                </tr>
                            </thead>";
                    $cont = 0;
                    $arraySongsLiked = $db->getLikedSongs($pdo, $_SESSION['id']); #name, genre, length, ID_AC, publ
                    foreach($arraySongsLiked as $songID){
                        $songID = $songID[0];
                        $cont++;
                        $arrayData = $db->getSongData($pdo, $songID);
                        list($name, $genre, $length, $ID_AC, $publ) = $arrayData[0];
                        $artista =  $db->getSongArtist($pdo, $songID);

                        if(is_null($length)){
                            $min = "Sin";
                            $sec = "largo";
                        }
                        else{
                            $min = floor($length/60);
                            $sec = $length-($min*60);
                            if($sec < 10){
                                $sec = "0" . $sec;
                            }
                        }

                        echo "  <tr>
                                <th scope='row'>" . $cont . "</th>
                                <td>" . $name . "</td>
                                <td>" . $artista . "</td>
                                <td>" . $min . ":" . $sec . "</td>
                                <td>" . $genre . "</td>
                                <form action='likesong.php' method='get'>
                                <td> <button type='submit' name=songid value='" . $songID . "' class='btn btn-danger' >Unlike</button> </td>
                                </form>
                                </tr>";
                    }
                }
                else{
                    echo " <div class='mx-auto' style='width: 200px; margin-top: 15px;'>
                    <h3>Tus Canciones</h3>
                    </div>
                    <span class='border '>
                        <div class='container shadow p-3 mb-5 bg-white rounded'>
                            <table class='table '>
                            <thead class='thead-light'>
                                <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Nombre</th>
                                <th scope='col'>Artista</th>
                                <th scope='col'>Duracion</th>
                                <th scope='col'>Genero</th>
                                <th scope='col'>Modify</th>
                                </tr>
                            </thead>";
                    $cont = 0;
                    $arraySongsMine = $db->getAccountSongs($pdo, $_SESSION['id']); #name, genre, length, ID_AC, publ
                    $asm = [];
                    foreach($arraySongsMine as list($songID)){
                        array_push($asm, $songID);
                    }
                    foreach($asm as $songID){
                        $cont++;
                        $arrayData = $db->getSongData($pdo, $songID);
                        list($name, $genre, $length, $ID_AC, $publ) = $arrayData[0];
                        $artista =  $db->getSongArtist($pdo, $songID);
                        
                        if(is_null($length)){
                            $min = "Sin";
                            $sec = "largo";
                        }
                        else{
                            $min = floor($length/60);
                            $sec = $length-($min*60);
                            if($sec < 10){
                                $sec = "0" . $sec;
                            }
                        }
                        echo "  <tr>
                                <th scope='row'>" . $cont . "</th>
                                <td>" . $name . "</td>
                                <td>" . $artista . "</td>
                                <td>" . $min . ":" . $sec . "</td>
                                <td>" . $genre . "</td>
                                <form action='changesong.php' method='get'>
                                <td> <button type='submit' name=songid value='" . $songID . "' class='btn btn-danger' >Modificar</button> </td>
                                </form>
                                </tr>";
                    }
                }

                


            ?>
            </table>
            <?php 
            if($_SESSION['artist']){
                echo "<a class='btn btn-outline-info' href='createsong.php' role='button'>Crear Cancion</a>";
            }
            ?>  
            </div>
        </span>

    <span class="border ">
        <div class="container shadow p-3 mb-5 bg-white rounded">
            <table class="table ">
            <thead class="thead-light">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Artista</th>
                <th scope="col">Duracion</th>
                <th scope="col">Genero</th>
                <th scope="col">Like</th>
                </tr>
            </thead>

            <?php
                $cont = 0;
                $arraySongs = $db->getAllSongs($pdo); #name, genre, length, ID_AC, publ

                foreach($arraySongs as $songID){
                    if($_SESSION['artist']){
                        if(!in_array($songID[0], $asm)){
                            $songID = $songID[0];
                            $cont++;
                            $arrayData = $db->getSongData($pdo, $songID);
                            list($name, $genre, $length, $ID_AC, $publ) = $arrayData[0];
                            $artista =  $db->getSongArtist($pdo, $songID);
                            
                            if(is_null($length)){
                                $min = "Sin";
                                $sec = "largo";
                            }
                            else{
                                $min = floor($length/60);
                                $sec = $length-($min*60);
                                if($sec < 10){
                                    $sec = "0" . $sec;
                                }
                            }
                            echo "  <tr>
                                    <th scope='row'>" . $cont . "</th>
                                    <td>" . $name . "</td>
                                    <td>" . $artista . "</td>
                                    <td>" . $min . ":" . $sec . "</td>
                                    <td>" . $genre . "</td>
                                    <form action='likesong.php' method='get'>
                                    <td> <button type='submit' name=songid value='" . $songID . "' class='btn btn-outline-dark' disabled>Like</button> </td>
                                    </form>
                                    </tr>";
                        }
                    }
                    else{
                        if(! in_array($songID, $arraySongsLiked)){

                        $songID = $songID[0];
                        $cont++;
                        $arrayData = $db->getSongData($pdo, $songID);
                        list($name, $genre, $length, $ID_AC, $publ) = $arrayData[0];
                        $artista =  $db->getSongArtist($pdo, $songID);
                        
                        if(is_null($length)){
                            $min = "Sin";
                            $sec = "largo";
                        }
                        else{
                            $min = floor($length/60);
                            $sec = $length-($min*60);
                        }
                        echo "  <tr>
                                <th scope='row'>" . $cont . "</th>
                                <td>" . $name . "</td>
                                <td>" . $artista . "</td>
                                <td>" . $min . ":" . $sec . "</td>
                                <td>" . $genre . "</td>
                                <form action='likesong.php' method='get'>
                                <td> <button type='submit' name=songid value='" . $songID . "' class='btn btn-success' >Like</button> </td>
                                </form>
                                </tr>";
                    }
                    
                }}


            ?>
            </table>
            </div>
        </span>
    
   


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>


