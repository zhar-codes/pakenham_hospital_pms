<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();

$baseDir = __DIR__;
$p = $_GET['p'] ?? 'public/login';

/** Map URL “p=” values to actual PHP files */
$routes = [
  // public/auth
  'public/login'        => $baseDir . '/views/public/login.php',
  'public/register'     => $baseDir . '/controllers/auth/register_patient.php',
  'auth/login'          => $baseDir . '/controllers/auth/login.php',
  'auth/logout'         => $baseDir . '/controllers/auth/logout.php',

  // views (pages)
  'reception/checkin'        => $baseDir . '/views/reception/checkin.php',
  'patient/appointments'     => $baseDir . '/views/patient/appointments.php',     // ← add
  'reception/appointments'   => $baseDir . '/views/reception/appointments.php',   // ← add

  // controllers (actions)
  'visits/checkin'      => $baseDir . '/controllers/visits/checkin.php',
  'visits/complete'     => $baseDir . '/controllers/visits/complete.php',
  'appointments/book'   => $baseDir . '/controllers/appointments/book.php',

  // dashboards
  'admin/dashboard'     => $baseDir . '/views/admin/dashboard.php',
  'clinician/dashboard' => $baseDir . '/views/clinician/dashboard.php',
  'reception/dashboard' => $baseDir . '/views/reception/dashboard.php',
  'patient/dashboard'   => $baseDir . '/views/patient/dashboard.php',
];

if (!isset($routes[$p]) || !is_file($routes[$p])) {
  http_response_code(404);
  echo 'Not Found';
  exit;
}

require $routes[$p];
