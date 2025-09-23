<?php declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../includes/auth_guard.php';
require_auth_role('clinician');

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../lib/VisitRepo.php';

$redirect = base_url() . '/index.php?p=clinician/dashboard';

try {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new RuntimeException('Invalid request');
  $visitId = (int)($_POST['visit_id'] ?? 0);
  $note    = trim((string)($_POST['note'] ?? ''));
  if ($visitId <= 0) throw new RuntimeException('Missing visit_id');

  VisitRepo::complete($pdo, $visitId, $note);
  $_SESSION['flash'] = 'Visit completed.';
} catch (Throwable $e) {
  $_SESSION['flash_error'] = $e->getMessage();
}
// Audit: clinician completed visit
try {
  $who = (int)($_SESSION['auth']['id'] ?? 0);
  $ins = $pdo->prepare(
    "INSERT INTO audit_log (user_id, action, entity, entity_id, details, created_at)
     VALUES (?, 'complete_visit', 'visit', ?, ?, NOW())"
  );
  $ins->execute([$who, (int)$visitId, "note=" . substr($note,0,255)]);
} catch (Throwable $e) { /* ignore */ }

header('Location: ' . $redirect);
exit;
