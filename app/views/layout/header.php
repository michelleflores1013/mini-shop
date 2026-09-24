<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../../db.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mini Shop MVC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="/mini-shop/">Mini Shop</a>
      <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="/mini-shop/">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="/mini-shop/products.php">Products</a></li>
          <li class="nav-item"><a class="nav-link" href="/mini-shop/newsfeed.php">Newsfeed</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
