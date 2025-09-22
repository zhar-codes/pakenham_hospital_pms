<?php
// PakenhamH_Web_App/public/index.php
declare(strict_types=1);
session_start();

$PAGE = $_GET['p'] ?? 'home';
$BASE_DIR = dirname(__DIR__);
$VIEW_DIR = $BASE_DIR . '/views';
$CTRL_DIR = $BASE_DIR . '/controllers';

$routes = [
  'home'            => $VIEW_DIR . '/public/home.php',
  'about'           => $VIEW_DIR . '/public/about.php',
  'services'        => $VIEW_DIR . '/public/services.php',
  'staff'           => $VIEW_DIR . '/public/staff.php',
  'contact'         => $VIEW_DIR . '/public/contact.php',

  'auth/login'      => $CTRL_DIR . '/auth/login.php',
  'auth/logout'     => $CTRL_DIR . '/auth/logout.php',
  'auth/register'   => $CTRL_DIR . '/auth/register_patient.php',
  'public/register' => $VIEW_DIR . '/public/register_patient.php',
  'public/login'    => $VIEW_DIR . '/public/login.php',
  'admin/dashboard'  => $VIEW_DIR . '/admin/dashboard.php',
  'clinician/dashboard'  => $VIEW_DIR . '/clinician/dashboard.php',
  'reception/dashboard'  => $VIEW_DIR . '/reception/dashboard.php',
  'patient/dashboard'       => $VIEW_DIR . '/patient/dashboard.php',




];

if (isset($routes[$PAGE]) && file_exists($routes[$PAGE])) {
  require $routes[$PAGE];
  exit;
}

http_response_code(404);
require $VIEW_DIR . '/public/home.php';
