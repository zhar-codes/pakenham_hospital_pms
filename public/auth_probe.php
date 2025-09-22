<?php
declare(strict_types=1);
session_start();
require __DIR__ . '/../config/db.php'; // must set $pdo

$u  = $_GET['u']  ?? '';
$pw = $_GET['pw'] ?? '';

header('Content-Type: text/plain; charset=utf-8');
echo "USER: $u\n";

$sql = "SELECT id, username, role, status, password_hash
        FROM users
        WHERE username = :u
        LIMIT 1";
$st = $pdo->prepare($sql);
$st->execute(['u' => $u]);
$row = $st->fetch();

if (!$row) {
  echo "No row found.\n";
  exit;
}

echo "Row status: {$row['status']}\n";
echo "Hash len: " . strlen($row['password_hash']) . "\n";
echo "password_verify: " . (password_verify($pw, $row['password_hash']) ? 'TRUE' : 'FALSE') . "\n";
