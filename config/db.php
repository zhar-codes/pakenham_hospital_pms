<?php
// config/db.php
declare(strict_types=1);

/** @var PDO $pdo */
$pdo = new PDO(
    'mysql:host=127.0.0.1;dbname=pakenham_hospital_pms;charset=utf8mb4',
    'pmsapp',
    'pmsapp_local_Dev#2025',
    [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]
);
