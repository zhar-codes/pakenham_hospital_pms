<?php
// public/kpi_probe.php
// Minimal read of v_admin_kpis to verify app ↔ DB wiring.

require_once __DIR__ . '/../config/db.php';   // this should return a PDO in $pdo or a getPDO()

// normalize how your app exposes PDO
$pdo = isset($pdo) ? $pdo : (function () {
    if (function_exists('getPDO')) return getPDO();
    // Fallback: build a PDO like your config does
    $dsn = 'mysql:host=127.0.0.1;dbname=pakenham_hospital_pms;charset=utf8mb4';
    $user = 'root';        // keep current working creds for now; we’ll switch to pmsapp later
    $pass = '';            // update if your root has a password
    $opt  = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    ];
    return new PDO($dsn, $user, $pass, $opt);
})();

$row = $pdo->query("SELECT * FROM v_admin_kpis LIMIT 1")->fetch();
header('Content-Type: application/json');
echo json_encode(['ok' => true, 'v_admin_kpis' => $row], JSON_PRETTY_PRINT);
