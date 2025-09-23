<?php declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();

if (!function_exists('require_auth_role')) {
  function require_auth_role(string $role): void {
    $have = strtolower($_SESSION['auth']['role'] ?? '');
    if ($have !== strtolower($role)) {
      $_SESSION['flash'] = 'Please sign in with the correct role.';
      header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/index.php?p=public/login');
      exit;
    }
  }
}
