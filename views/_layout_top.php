<?php declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();

$title   = isset($title) && $title !== '' ? $title : 'Pakenham Hospital';
$baseUrl = rtrim(str_replace('\\','/', dirname($_SERVER['SCRIPT_NAME'])), '/');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?= htmlspecialchars($title, ENT_QUOTES) ?></title>

  <!-- Bootswatch Sandstone (includes Bootstrap 5 under the hood) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/sandstone/bootstrap.min.css">

  <!-- Bootstrap Icons (optional, for your <i class="bi ...">) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <style>
    body { padding-top: 2rem; padding-bottom: 2rem; }
  </style>
</head>
<body>
  <?php
$flashPath = dirname(__DIR__) . '/includes/flash.php';
if (file_exists($flashPath)) include $flashPath;
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="<?= $baseUrl ?>/index.php?p=home">Pakenham Hospital</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#phNav" aria-controls="phNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="phNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/index.php?p=home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/index.php?p=about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/index.php?p=services">Services</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/index.php?p=staff">Staff</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/index.php?p=contact">Contact</a></li>
      </ul>

      <div class="d-flex gap-2">
        <?php if (!empty($_SESSION['auth'])): ?>
          <span class="navbar-text small">
            <i class="bi bi-person-circle"></i>
            <?= htmlspecialchars($_SESSION['auth']['username'] ?? 'User') ?>
            (<?= htmlspecialchars($_SESSION['auth']['role'] ?? 'role') ?>)
          </span>
          <a class="btn btn-outline-light btn-sm" href="<?= $baseUrl ?>/index.php?p=auth/logout">Logout</a>
        <?php else: ?>
          <a class="btn btn-light btn-sm" href="<?= $baseUrl ?>/index.php?p=public/login">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<div class="container">
