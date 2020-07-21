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
        include_once "DB.php";
        $db = new DB();
        $pdo = $db->connect();

        $user = $_POST['user']; 
        $pass = $_POST['pass']; 
    ?>

    <title>Inter Login</title>
  </head>
  <body class="p-3 mb-2 bg-dark text-white">

  


    <div class="container vertical-center ">

    <?php
        if($db->login($pdo, $user, $pass)){

            $_SESSION['user'] = $user;
            $_SESSION['pass'] = $pass;

            header("Location: checkname.php");
            die();
        }
        else{
            echo "<img src='Poyofy.png' width='100' height='100' class='rounded mx-auto d-block' alt='Poyofy Icon'>
            <div class='jumbotron bg-dark text-white'>
            <h1 class='display-4'>Sesion Incorrecta</h1>
            <p class='lead'>Por favor ingresa un usuario o contraseña previamente creados. </p>
            <p class='lead'>
              <a class='btn btn-primary btn-lg' href='index.php' role='button'>Volver</a>
            </p>
            
          </div>";
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




