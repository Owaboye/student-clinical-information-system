<?php //require_once '../config/functions.php'; ?>
<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CDIS </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?= baseUrl('public/asset/css/style.css') ?>">
  </head>
  <body class="d-flex h-100 text-bg-dark"> 
   <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="mb-auto"> 
      <div> 
        <h3 class="float-md-start mb-0">
          <a class="nav-link fw-bold py-1 px-0" href="<?= baseUrl() ?>"> Home</a> 
         
        </h3> 
        <nav class="nav nav-masthead justify-content-center float-md-end"> 
          <?php if(!isset($_SESSION['user'])): ?>
          <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="<?= baseUrl('public/login.php') ?>">Sign in</a> 
          
          <?php else: ?>
            <a href="<?= baseUrl('public/logout.php') ?>" class="nav-link fw-bold py-1 px-0 active">Logout</a>
          <?php endif ?>

         

        </nav> 
      </div> 
    </header>