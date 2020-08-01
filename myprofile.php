<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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

        echo "<title>" . $_SESSION['name'] . "</title>";
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

    
    
    <div class="container" style="margin-top:25px">

    <?php
        if(isset($_GET['change'])){
        
            if($_GET['change'] == "true"){
                echo "<div class='alert alert-primary' role='alert'>
                Modificacion efectuada.
              </div>";
            }
        }
    ?>

        

        <div class="card text-center">
            <div class="card-header">
            <?php 
                if($_SESSION['artist']){
                    echo "Artista";
                }
                else{
                    echo "Usuario";
                } 
            
            ?>
            </div>
            <div class="card-body">
                <h5 class="card-title"><?php echo $_SESSION['name']?></h5>
                <?php 
            
                if($_SESSION['artist']){
                echo "<p class='card-text'>" . $db->getBio($pdo,$_SESSION['id']) . "</p>";
                }
                ?>
                <a href="changeprofile.php" class="btn btn-primary">Modificar</a>
            </div>
            <div class="card-footer text-muted">
                Poyofy
            </div>
        </div>
    </div>
    <div class="container">
        <h3 class="text-center" style='margin-top: 15px;'> 
            <?php 
                if($_SESSION['artist']){
                    echo "Albumes";
                }
                else{
                    echo "Canciones";
                }
            ?> 
        </h3>
        <?php 
            if($_SESSION['artist']){
                $albums = $db->getAlbums($pdo, $_SESSION['id']);
                echo "<div class='card-deck' style='margin-top:25px'>";
                foreach($albums as $al){
                    
                    $info = $db->getAlbumDetail($pdo, $al); #ID_al, nombre, canciones, genero, id_ac, fecha
                    $idal = $info[0];
                    $name = $info[1];
                    $genre = $info[3];
                    $date = $info[5];
                
                    echo "<div class='card' style='width: 18rem;'>";
                    echo "
                    <div class='card-body'>
                        <h5 class='card-title'>" . $name . "</h5>
                        <h6 class='card-subtitle mb-2 text-muted'>" . $date . "</h6>
                        <p class='card-text'>" . $genre . "</p>
                        <a href='showal.php?id=" . $idal . "' class='card-link'>Ver Album</a>
                        <a href='delal.php?id=" . $idal . " 'class='card-link'>Eliminar</a>
                    </div>
                    ";
                    echo "</div>";
                }
                echo "</div>";
                
            }
            else{
                $playlists = $db->getPlaylistUser($pdo, $_SESSION['id']);
                echo "<div class='card-deck' style='margin-top:25px'>";
                foreach($playlists as $pl){
                    $pl = $pl[1];
                    
                    $info = $db->getPlaylistData($pdo, $pl); #ID_pl, name, descr, id_ac
                    $idpl = $info[0];
                    $name = $info[1];
                    $descr = $info[2];
                
                    echo "<div class='card' style='width: 18rem;'>";
                    echo "
                    <div class='card-body'>
                        <h5 class='card-title'>" . $name . "</h5>
                        <p class='card-text'>" . $descr . "</p>
                        <a href='showpl.php?pl=" . $idpl . "' class='card-link'>Ver playlist</a>
                        <a href='delpl.php?id=" . $idpl . " 'class='card-link'>Eliminar</a>
                    </div>
                    ";
                    echo "</div>";
                }
                echo "</div>";
                
            }
        ?>
        </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    

    
  </body>

  
</html>