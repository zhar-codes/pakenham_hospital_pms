<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Absolute base to your public router (adjust if your folder name changes)
$PUBLIC_BASE = '/pakenham_hospital_pms/public';

require_once dirname(__DIR__, 2) . '/lib/AuthDb.php'; // provides authdb_login()

// If someone opens this file directly (GET), send them to the public login page.
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: ' . $PUBLIC_BASE . '/index.php?p=public/login');
    exit;
}

// Read form inputs
$username = trim((string)($_POST['username'] ?? ''));
$password = (string)($_POST['password'] ?? '');

// Basic validation
if ($username === '' || $password === '') {
    $_SESSION['flash'] = 'Please enter username and password.';
    header('Location: ' . $PUBLIC_BASE . '/index.php?p=public/login');
    exit;
}

// Try DB login (expects users.status = 'Active' and bcrypt password_hash)
$user = authdb_login($username, $password);

if (!$user) {
    $_SESSION['flash'] = 'Invalid username or password.';
    header('Location: ' . $PUBLIC_BASE . '/index.php?p=public/login');
    exit;
}

// Store session (do NOT include the hash)
$_SESSION['auth'] = [
    'id'       => (int)$user['id'],
    'username' => (string)$user['username'],
    'role'     => (string)$user['role'],
    'email'    => $user['email'] ?? null,
];

// Role → route mapping (via your public router)
$roleRoutes = [
    'admin'     => 'admin/dashboard',
    'clinician' => 'clinician/dashboard',
    'reception' => 'reception/dashboard',
    'patient'   => 'patient/portal', // change to 'patient/dashboard' if that’s your file
];

$target = $roleRoutes[$_SESSION['auth']['role']] ?? 'home';
header('Location: ' . $PUBLIC_BASE . '/index.php?p=' . $target);
exit;
