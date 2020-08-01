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

        $alid = $_GET['al'];
        $data = $db->getAlbumDetail($pdo, $alid); #ID_al, nombre, canciones, genero, id_ac, fecha
        $alname = $data[1];
        $alsongs = $data[2];
        $algenre = $data[3];
        $alowner = $data[4];
        $aldate = $data[5];
        if($alowner != $_SESSION['id']){
            header("Location: home.php");
        }
        ?>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Modifica Album</title>
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
    
    <div class="container">

        <h2 class="text-center"> Modificar Album<br> <small class="text-muted">Introduce solo lo que quieras cambiar</small> </h2>
        <form action="changealback.php" method="post">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nombre</label>
                    <input type="text" class="form-control" name="name" placeholder="<?php echo $alname; ?>">
                </div>
                
                <div class="form-group">
                    <label for="exampleFormControlInput1">Genero</label>
                    <input type="text" class="form-control" name="genre" placeholder="<?php echo $algenre; ?>">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Fecha - <small class="text-muted"><?php echo $aldate; ?></small></label>
                    <input type="date" class="form-control" name="date" placeholder="<?php echo $aldate; ?>">

                </div>
                <input type='hidden' name='al' value='<?php echo $alid; ?>' >
                

                <button type="submit" class="btn btn-primary">Cambiar</button>
            
                
                
            </form>
    
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>


