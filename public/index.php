<?php declare(strict_types=1);
session_start();

$BASE_DIR = dirname(__DIR__);
$VIEW_DIR = $BASE_DIR . '/views';
$CTRL_DIR = $BASE_DIR . '/controllers';

$PAGE = $_GET['p'] ?? 'home';

$routes = [
  // public site
  'home'                 => $VIEW_DIR . '/public/index.php',
  'about'                => $VIEW_DIR . '/public/about.php',
  'services'             => $VIEW_DIR . '/public/services.php',
  'staff'                => $VIEW_DIR . '/public/staff.php',
  'contact'              => $VIEW_DIR . '/public/contact.php',

  // auth views + actions
  'public/login'         => $VIEW_DIR . '/public/login.php',
  'public/register'      => $VIEW_DIR . '/public/patient_register.php',
  'auth/login'           => $CTRL_DIR . '/auth/login.php',
  'auth/logout'          => $CTRL_DIR . '/auth/logout.php',
  'auth/register'        => $CTRL_DIR . '/auth/register_patient.php', // (can be stubbed for now)

  // dashboards
  'admin/dashboard'      => $VIEW_DIR . '/admin/dashboard.php',
  'clinician/dashboard'  => $VIEW_DIR . '/clinician/dashboard.php',
  'reception/dashboard'  => $VIEW_DIR . '/reception/dashboard.php',
  'patient/dashboard'    => $VIEW_DIR . '/patient/dashboard.php',
];

if (isset($routes[$PAGE]) && file_exists($routes[$PAGE])) {
  require $routes[$PAGE];
  exit;
}

http_response_code(404);
require $VIEW_DIR . '/public/index.php';
