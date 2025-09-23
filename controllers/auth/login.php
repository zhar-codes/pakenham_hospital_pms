<?php declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();

require __DIR__ . '/../../lib/AuthDb.php'; // defines authdb_login()

// Optional CSRF check (uncomment when ready)
/*
if (!isset($_POST['csrf'], $_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], (string)$_POST['csrf'])) {
  $_SESSION['flash'] = 'Please try again.';
  header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/index.php?p=public/login');
  exit;
}
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/index.php?p=public/login');
  exit;
}

$username = trim((string)($_POST['username'] ?? ''));
$password = (string)($_POST['password'] ?? '');

if ($username === '' || $password === '') {
  $_SESSION['flash'] = 'Please enter username and password.';
  header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/index.php?p=public/login');
  exit;
}

$user = authdb_login($username, $password);
if (!$user) {
  $_SESSION['flash'] = 'Invalid username or password.';
  header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/index.php?p=public/login');
  exit;
}

$role = strtolower(trim((string)$user['role']));
$aliases = ['receptionist'=>'reception','doctor'=>'clinician','physician'=>'clinician'];
$role = $aliases[$role] ?? $role;

$_SESSION['auth'] = [
  'id'       => (int)$user['id'],
  'username' => $user['username'],
  'role'     => $role,
  'email'    => $user['email'] ?? null,
];

$roleRoutes = [
  'admin'     => 'admin/dashboard',
  'clinician' => 'clinician/dashboard',
  'reception' => 'reception/dashboard',
  'patient'   => 'patient/dashboard',
];

$target = $roleRoutes[$role] ?? 'home';
header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/index.php?p=' . $target);
exit;
