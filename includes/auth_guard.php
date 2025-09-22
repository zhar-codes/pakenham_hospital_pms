<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('require_auth_role')) {
    function require_auth_role(string $role): void {
        if (empty($_SESSION['auth']) || ($_SESSION['auth']['role'] ?? '') !== $role) {
            header('Location: /pakenham_hospital_pms/public/index.php?p=public/login');
            exit;
        }
    }
}
