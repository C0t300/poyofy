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
        ?>

    <title>Playlists</title>
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
                <a class="nav-link" href="playlist.php">Playlists</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Personas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
            </li>
            </ul>
            <span class="nav-item navbar-text"> <?php echo "Hola, ", $_SESSION['name']?> </span>
            <a class="nav-link" href="logout.php">Log Out</a>
            
        </div>
        </nav>
        <div class="container" style="margin-top:25px" >
  
            
        <div class="row">
            <div class="col-sm">
                <div class="list-group">
                
                    <?php

                        $array = $db->getPlaylistUser($pdo, $_SESSION['id']);
                        if(empty($array)){
                            echo "
                                <div class='jumbotron bg-dark text-white'>
                                <h1 class='display-4'>No hay playlists</h1>
                                <p class='lead'>Crea una playlist! </p>
                                <p class='lead'>
                                <a class='btn btn-primary btn-lg' href='home.php' role='button'>Volver</a>
                                </p>";
                        }
                        else{
                            echo "<form action='showpl.php' method='post'>";
                            foreach($array as list($n, $pid)){
                                # <input type="submit" name="upvote" value="Upvote" />
                                echo "
                                    <button type='submit' name='pl' value='" . $pid . "' class='list-group-item list-group-item-action'>
                                        " . $n . "
                                    </button>";
                            }
                            echo "</form>";
                        }

                        
                    ?>
                </div>
            </div>
            <div class="col-sm">
            </div>
            <div class="col-sm">
            </div>
            </div>
        </div>  

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>