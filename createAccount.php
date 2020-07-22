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

        if(isset($_SESSION['user'])){

            header("Location: home.php");
            die();
        }

        include_once "DB.php";
        $db = new DB();
        $pdo = $db->connect();
    ?>

    <title>Crea tu cuenta!</title>
  </head>
  <body class="p-3 mb-2 bg-dark text-white">
    <div class="container vertical-center ">

    <img src="Poyofy.png" class="rounded mx-auto d-block" width="100" height="100" alt="Poyofy Icon">
    <br>

    <form action="create.php" method="post">
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Elliot Alderson" required>
        </div>
        <div class="form-group">
            <label for="user">User</label>
            <input type="text" class="form-control" name="user" id="user" placeholder="samsepi0l" required>
        </div>
        <div class="form-group">
            <label for="pass">Password</label>
            <input type="password" class="form-control" name="pass" id="pass" required>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="option" id="type" value="user" checked>
            <label class="form-check-label" for="inlineRadio1">Usuario</label>
            </div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="option" id="type" value="artist">
            <label class="form-check-label" for="inlineRadio2">Artista</label>
        </div>
        <br> <br>
        <button type="submit" class="btn btn-primary">Registrarse</button>
    </form>


    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>