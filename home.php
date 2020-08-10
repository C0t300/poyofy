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

    <title>Bienvenido a Poyofy!</title>
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

    <div class="container" style="margin-top:15px;">
        <div class="card">
            <div class="card-header">
                <?php echo $_SESSION['name'];?>
            </div>
            <div class="card-body">
                <p><?php echo "Seguidores: " . $db->getAmmountFollowersAccount($pdo, $_SESSION['id']); ?></p>
                <a class="btn btn-secondary" href="myprofile.php" role="button"><?php if($_SESSION['artist']){ echo "Artista";} else{echo "Usuario";} ?></a>
            </div>
        </div>

        <div class='card-deck' style='margin-top:25px'>

            <?php 

            $randpl = $db->getRandomPlaylist($pdo); #ID_pl, name
            if($randpl != false){
                echo "<div class='card' style='width: 18rem;'>
                        <div class='card-body'>
                            <h5 class='card-title'>Random Playlist</h5>
                            <p class='card-text'>" . $randpl[1] . "</p>
                            <a href='showpl.php?pl=" . $randpl[0] . "' class='btn btn-primary'>Go</a>
                        </div>
                        </div>";
            }

            $randal = $db->getRandomAlbum($pdo); #ID_al, nombre
            if($randal != false){
                echo "<div class='card' style='width: 18rem;'>
                        <div class='card-body'>
                            <h5 class='card-title'>Random Album</h5>
                            <p class='card-text'>" . $randal[1] . "</p>
                            <a href='showal.php?id=" . $randal[0] . "' class='btn btn-primary'>Go</a>
                        </div>
                        </div>";
            }

            $randguy = $db->getRandomAccount($pdo, $_SESSION['id']); #ID_ac, name
            if($randguy != false){
                echo "<div class='card' style='width: 18rem;'>
                        <div class='card-body'>
                            <h5 class='card-title'>Random Account</h5>
                            <p class='card-text'>" . $randguy[1] . "</p>
                            <a href='viewprofile.php?ac=" . $randguy[0] . "' class='btn btn-primary'>Go</a>
                        </div>
                        </div>";
            }

            ?>

            

        </div>
    </div>
    
   


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>


