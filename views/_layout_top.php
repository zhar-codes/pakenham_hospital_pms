<?php
// PakenhamH_Web_App/views/_layout_top.php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();
$title = $title ?? 'Pakenham Hospital';
$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); // /PakenhamH_Web_App/public

function nav_active(string $slug): string {
  $p = $_GET['p'] ?? 'home';
  return $p === $slug ? 'active' : '';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($title) ?></title>

  <!-- Bootswatch Sandstone (Bootstrap 5) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/sandstone/bootstrap.min.css">

  <style>
    .hero { padding: 3.5rem 0; }
    .brand-badge { letter-spacing:.5px; font-weight:600; }
    .navbar .nav-link.active { font-weight:600; }
  </style>
</head>
<body>

<!-- PUBLIC NAVBAR (separate from PMS) -->
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container">
    <a class="navbar-brand brand-badge" href="<?= $baseUrl ?>/index.php?p=home">
      Pakenham Hospital
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#phPublicNav" aria-controls="phPublicNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="phPublicNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link <?= nav_active('home') ?>" href="<?= $baseUrl ?>/index.php?p=home">Home</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('about') ?>" href="<?= $baseUrl ?>/index.php?p=about">About</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('services') ?>" href="<?= $baseUrl ?>/index.php?p=services">Services</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('staff') ?>" href="<?= $baseUrl ?>/index.php?p=staff">Our Staff</a></li>
        <li class="nav-item"><a class="nav-link <?= nav_active('contact') ?>" href="<?= $baseUrl ?>/index.php?p=contact">Contact</a></li>
      </ul>

      <div class="d-flex gap-2">
  <?php if (!empty($_SESSION['auth'])): ?>
    <span class="navbar-text text-white-50">
      Hello, <?= htmlspecialchars($_SESSION['auth']['username']) ?>
      (<?= htmlspecialchars($_SESSION['auth']['role']) ?>)
    </span>
    <a class="btn btn-outline-light" href="<?= $baseUrl ?>/index.php?p=auth/logout">Logout</a>
  <?php else: ?>
    <a class="btn btn-outline-light" href="<?= $baseUrl ?>/index.php?p=public/login">Login</a>
    <a class="btn btn-warning text-dark" href="<?= $baseUrl ?>/index.php?p=public/register">Register</a>
  <?php endif; ?>
    </div>
  </div>
</nav>

<main class="container my-4">
