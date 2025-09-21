<?php
// PakenhamH_Web_App/controllers/auth/login.php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();

require_once dirname(__DIR__, 2) . '/lib/Auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  require dirname(__DIR__, 2) . '/views/public/login.php';
  exit;
}

$username = trim($_POST['username'] ?? '');
$password = (string)($_POST['password'] ?? '');

if ($username === '' || $password === '') {
  $_SESSION['flash'] = 'Please enter username and password.';
  header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/index.php?p=auth/login');
  exit;
}

if (!Auth::tryLogin($username, $password)) {
  $_SESSION['flash'] = 'Invalid credentials.';
  header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/index.php?p=auth/login');
  exit;
}

Auth::redirectToRolePMS();
