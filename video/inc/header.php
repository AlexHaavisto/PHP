<!doctype html>
<html lang="fi-FI">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Videovuokraamo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  </head>
  <body>
    <?php session_start(); 

     require_once "inc/funktiot.php";

    if( basename($_SERVER['PHP_SELF']) != 'index.php' ){
      if( basename($_SERVER['PHP_SELF']) != 'kirjaudu.php' ){
        if( !tarkistaKirjautuminen() ){
          header("Location: index.php");
        }
      }
    }

    require_once "nav.php"; ?>
    <div class="container">