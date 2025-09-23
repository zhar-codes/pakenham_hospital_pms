<?php
declare(strict_types=1);
error_reporting(E_ALL); ini_set('display_errors','1');

/* Get PDO from config:
   Works whether config/db.php RETURNS a PDO or DEFINES $pdo. */
$maybe = @require __DIR__ . '/../config/db.php';
if ($maybe instanceof PDO)      { $pdo = $maybe; }
elseif (isset($pdo) && $pdo instanceof PDO) { /* ok */ }
else { die('config/db.php must return/define a PDO'); }

/* Sanity: users table must already exist */
$exists = $pdo->prepare("
  SELECT COUNT(*) FROM information_schema.tables
  WHERE table_schema = DATABASE() AND table_name = 'users'
");
$exists->execute();
if ((int)$exists->fetchColumn() === 0) {
  die("ERROR: 'users' table does not exist. Create it first.");
}

$seed = [
  ['admin1',  'admin@local',   'Admin#2025',  'admin'],
  ['clin1',   'clin@local',    'Clin#2025',   'clinician'],
  ['recept1', 'recept@local',  'Recept#2025', 'reception'],
  ['patient1','patient@local', 'Patient#2025','patient'],
];

$sel = $pdo->prepare("SELECT id FROM users WHERE username = :u OR email = :e LIMIT 1");
$ins = $pdo->prepare("
  INSERT INTO users (username,email,password_hash,role,status,created_at)
  VALUES (:u,:e,:p,:r,'Active',NOW())
");
$upd = $pdo->prepare("
  UPDATE users
     SET email=:e, password_hash=:p, role=:r, status='Active'
   WHERE id=:id
");

$pdo->beginTransaction();
try {
  foreach ($seed as [$u,$e,$plain,$r]) {
    $sel->execute([':u'=>$u, ':e'=>$e]);
    $rowId = $sel->fetchColumn();

    $hash = password_hash($plain, PASSWORD_BCRYPT);

    if ($rowId) {
      $upd->execute([':e'=>$e, ':p'=>$hash, ':r'=>$r, ':id'=>$rowId]);
    } else {
      $ins->execute([':u'=>$u, ':e'=>$e, ':p'=>$hash, ':r'=>$r]);
    }
  }
  $pdo->commit();
  echo "Seeded/updated users.\n";
} catch (Throwable $e) {
  if ($pdo->inTransaction()) $pdo->rollBack();
  http_response_code(500);
  echo "Seeding failed: " . $e->getMessage();
}
