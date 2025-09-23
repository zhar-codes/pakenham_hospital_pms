<?php
// /includes/header.php  (shared header for all roles)
// Optional vars before include: $title, $user, $active, $brandLogo, $menu ('admin' | 'reception' | 'clinician' | 'patient')

$brandName = 'Pakenham Hospital';

/* Figure out base URL (e.g., /PakenhamH_Web_App) */
$docRootFs = rtrim(str_replace('\\','/', realpath($_SERVER['DOCUMENT_ROOT'] ?? '')), '/');
$projRootFs = rtrim(str_replace('\\','/', realpath(dirname(__DIR__))), '/');
$baseUrl    = str_replace($docRootFs, '', $projRootFs);
if ($baseUrl === '/' || $baseUrl === '\\') { $baseUrl = ''; }

/* Helper routes */
$routeAdmin     = $baseUrl . '/views/admin';
$routeReception = $baseUrl . '/views/reception';
$routeClinician = $baseUrl . '/views/clinician';
$routePatient   = $baseUrl . '/views/patient';

if (!function_exists('u')) {
  function u($p){ global $baseUrl; return rtrim($baseUrl,'/').'/'.ltrim($p,'/'); }
}

/* Logo (web path) */
$brandLogo = $brandLogo ?? ($baseUrl . '/assets/img/pakenham-hospital-logo.png');

/* Load nav config (provides $NAV_ADMIN, $NAV_RECEPTION, $NAV_CLINICIAN, $NAV_PATIENT) */
$NAV_ADMIN = $NAV_RECEPTION = $NAV_CLINICIAN = $NAV_PATIENT = [];
$navPath = __DIR__.'/nav.php';
if (file_exists($navPath)) { require_once $navPath; }

/* Pick which nav to render up top */
$menu = $menu ?? 'admin';
if     ($menu === 'reception') { $NAV = $NAV_RECEPTION ?: []; }
elseif ($menu === 'clinician') { $NAV = $NAV_CLINICIAN ?: []; }
elseif ($menu === 'patient')   { $NAV = $NAV_PATIENT   ?: []; }
else                           { $NAV = $NAV_ADMIN     ?: []; }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title ?? $brandName) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootswatch Sandstone + Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/sandstone/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background:#f8fafc; }
    .card { border:0; border-radius:16px; box-shadow:0 6px 20px rgba(15,23,42,.06); }
    .navbar { box-shadow:0 2px 10px rgba(15,23,42,.05); }
    .brand-logo{ height:32px; width:auto; object-fit:contain; display:block; }
    .brand-logo-sm{ height:22px; width:auto; object-fit:contain; display:block; }
  </style>
</head>
<body>
<?php if (file_exists(__DIR__ . '/flash.php')) include __DIR__ . '/flash.php'; ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="<?= u('index.php') ?>" aria-label="<?= htmlspecialchars($brandName) ?>">
      <img src="<?= htmlspecialchars($brandLogo) ?>" alt="" class="brand-logo">
      <span class="visually-hidden"><?= htmlspecialchars($brandName) ?></span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div id="nav" class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <?php foreach ($NAV as $item): if (empty($item['top'])) continue; ?>
          <li class="nav-item">
            <a class="nav-link <?= ($active??'')===$item['key'] ? 'active' : '' ?>" href="<?= $item['href'] ?>">
              <?= htmlspecialchars($item['label']) ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="d-flex align-items-center gap-2 text-light">
        <span class="small">Signed in as <?= htmlspecialchars($user ?? 'User Name') ?></span>
        <a class="btn btn-outline-light btn-sm" href="<?= u('logout.php') ?>"><i class="bi bi-box-arrow-right"></i> Logout</a>
      </div>
    </div>
  </div>
</nav>

<main class="container my-4">
