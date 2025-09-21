<?php
// PakenhamH_Web_App/lib/Auth.php
declare(strict_types=1);
require_once __DIR__ . '/StubStore.php';

final class Auth {

  public static function tryLogin(string $username, string $password): bool {
    $rec = StubStore::getUser($username);
    if (!$rec) return false;
    $ok = hash_equals($rec['password'], (string)$password);
    if ($ok) {
      $_SESSION['auth'] = [
        'username' => $username,
        'role'     => $rec['role'], // admin | clinician | reception | patient
      ];
    }
    return $ok;
  }

  public static function logout(): void {
    unset($_SESSION['auth']);
  }

  /**
   * Redirects to the PMS dashboard page for a given role.
   * We try common filenames in order: dashboard.php, index.php, home.php
   * You can customize per-role targets in $perRole map below.
   */
  public static function redirectToRolePMS(): void {
    if (empty($_SESSION['auth']['role'])) return;

    $role = $_SESSION['auth']['role']; // 'admin','clinician','reception','patient'

    // URL roots (not filesystem)
    $publicPath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); // e.g. /PakenhamH_Web_App/public
    $appRootUrl = rtrim(dirname($publicPath), '/');             // e.g. /PakenhamH_Web_App

    // 1) Optional explicit per-role landing overrides (set if your filenames differ)
    $perRole = [
      'admin'     => $appRootUrl . '/views/admin/dashboard.php',
      'clinician' => $appRootUrl . '/views/clinician/dashboard.php',
      'reception' => $appRootUrl . '/views/reception/dashboard.php',
      'patient'   => $appRootUrl . '/views/patient/dashboard.php',
    ];

    // If the mapped file exists on disk, use it
    $candidate = $perRole[$role] ?? null;
    if ($candidate && file_exists(self::toFs($candidate))) {
      header('Location: ' . $candidate);
      exit;
    }

    // 2) Fallback: probe common filenames in /views/{role}/
    $base = $appRootUrl . '/views/' . $role . '/';
    foreach (['dashboard.php','index.php','home.php'] as $f) {
      $url = $base . $f;
      if (file_exists(self::toFs($url))) {
        header('Location: ' . $url);
        exit;
      }
    }

    // 3) Last resort: go to folder (not ideal, but avoids a dead end)
    header('Location: ' . $base);
    exit;
  }

  // Convert a project-relative URL (/PakenhamH_Web_App/...) to a filesystem path
  private static function toFs(string $urlPath): string {
    // SCRIPT_FILENAME = C:\xampp\htdocs\PakenhamH_Web_App\public\index.php
    $publicFs = dirname($_SERVER['SCRIPT_FILENAME']);          // ...\public
    $appFs    = dirname($publicFs);                            // ...\PakenhamH_Web_App
    $appUrl   = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');  // /PakenhamH_Web_App/public
    $rootUrl  = rtrim(dirname($appUrl), '/');                  // /PakenhamH_Web_App
    // Replace the URL root with the filesystem root
    $rel = ltrim(str_replace($rootUrl, '', $urlPath), '/');    // e.g. views/admin/dashboard.php
    return $appFs . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $rel);
  }
}
