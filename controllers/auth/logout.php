<?php
// PakenhamH_Web_App/controllers/auth/logout.php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();
require_once dirname(__DIR__, 2) . '/lib/Auth.php';

Auth::logout();
$_SESSION['flash'] = 'You have been logged out.';
header('Location: ' . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/index.php?p=auth/login');
exit;
