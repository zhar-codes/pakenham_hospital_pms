<?php
// PakenhamH_Web_App/controllers/auth/register_patient.php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();
require_once dirname(__DIR__, 2) . '/lib/StubStore.php';

$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  require dirname(__DIR__, 2) . '/views/public/patient_register.php';
  exit;
}

$username = trim($_POST['username'] ?? '');
$password = (string)($_POST['password'] ?? '');

if ($username === '' || $password === '') {
  $_SESSION['flash'] = 'Please complete all required fields.';
  header('Location: ' . $baseUrl . '/index.php?p=public/register');
  exit;
}

if (!StubStore::pretendCreatePatient($username, $password)) {
  $_SESSION['flash'] = 'Username already exists (in stub). Try another.';
  header('Location: ' . $baseUrl . '/index.php?p=public/register');
  exit;
}

$_SESSION['flash'] = 'Registration successful. Please login.';
header('Location: ' . $baseUrl . '/index.php?p=auth/login');
exit;
