<?php declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();

function base_url(): string {
  $docRootFs = rtrim(str_replace('\\','/', realpath($_SERVER['DOCUMENT_ROOT'] ?? '')), '/');
  $projRootFs = rtrim(str_replace('\\','/', realpath(dirname(__DIR__))), '/');
  $baseUrl    = str_replace($docRootFs, '', $projRootFs);
  return ($baseUrl === '/' || $baseUrl === '\\') ? '' : $baseUrl;
}

function redirect_to_login(): void {
  $_SESSION['flash'] = 'Please sign in.';
  header('Location: ' . base_url() . '/index.php?p=public/login');
  exit;
}

function require_login(): void {
  if (empty($_SESSION['auth']['id'])) redirect_to_login();
}

function require_auth_role(string $role): void {
  require_login();
  $have = strtolower((string)($_SESSION['auth']['role'] ?? ''));
  if ($have !== strtolower($role)) {
    $_SESSION['flash'] = 'Please sign in with the correct role.';
    header('Location: ' . base_url() . '/index.php?p=public/login');
    exit;
  }
}

function require_auth_roles(array $roles): void {
  require_login();
  $have = strtolower((string)($_SESSION['auth']['role'] ?? ''));
  $roles = array_map('strtolower', $roles);
  if (!in_array($have, $roles, true)) {
    $_SESSION['flash'] = 'You don’t have access to that page.';
    header('Location: ' . base_url() . '/index.php?p=public/login');
    exit;
  }
}
