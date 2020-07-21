<!DOCTYPE html>
<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    include_once "DB.php";
    $db = new DB();
    $pdo = $db->connect();

    if(isset($_SESSION['user'])){

        header("Location: home.php");
        die();
    }
?>

<!doctype html>
<html lang="en">
  <head>
  <style>
  .vertical-center {
    min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
    min-height: 100vh; /* These two lines are counted as one :-)       */

    display: flex;
    align-items: center;
}</style>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Bienvenido a Poyofy!</title>
  </head>
  <body class="p-3 mb-2 bg-dark text-white">

  


    <div class="container vertical-center ">

        <img src="Poyofy.png" class="rounded mx-auto d-block" alt="Poyofy Icon">
    <!-- Content here -->

        <!--- BOOTSTRAP FORM--->

        <form action="accion.php" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="text" name="user" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <small id="emailHelp" class="form-text text-muted">Debe ser unico en el sistema. </small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="pass" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <!--- OLD FORM

        <form action="accion.php" method="post">
        <p>Username: <input type="text" name="user" /></p>
        <p>Password: <input type="text" name="pass" /></p>
        <p><input type="submit" /></p>  
        </form>

        --->

        </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>
