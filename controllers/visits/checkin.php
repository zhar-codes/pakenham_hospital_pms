<?php declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../includes/auth_guard.php';
require_auth_role('reception');

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../lib/VisitRepo.php';

$redirect = base_url() . '/index.php?p=reception/checkin';

try {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    throw new RuntimeException('Invalid request method');
  }

  $appointmentId = isset($_POST['appointment_id']) && $_POST['appointment_id'] !== '' ? (int)$_POST['appointment_id'] : null;
  $patientId     = isset($_POST['patient_id']) && $_POST['patient_id'] !== '' ? (int)$_POST['patient_id'] : null;
  $clinicianId   = isset($_POST['clinician_id']) && $_POST['clinician_id'] !== '' ? (int)$_POST['clinician_id'] : null;
  $note          = trim((string)($_POST['note'] ?? ''));

  if ($appointmentId) {
    $visitId = VisitRepo::checkInByAppointment($pdo, $appointmentId, $note);
  } elseif ($patientId && $clinicianId) {
    $visitId = VisitRepo::checkInByPatientClinician($pdo, $patientId, $clinicianId, $note);
  } else {
    throw new RuntimeException('Provide appointment_id OR patient_id + clinician_id.');
  }

  $_SESSION['flash'] = $visitId > 0 ? "Checked in (visit #$visitId)." : "Checked in.";
} catch (Throwable $e) {
  $_SESSION['flash_error'] = $e->getMessage();
}

// Audit: reception check-in
try {
  $who = (int)($_SESSION['auth']['id'] ?? 0);
  $entity = $appointmentId ? 'appointment' : 'patient';
  $entityId = $appointmentId ?: $patientId;
  $details = $appointmentId
    ? "visit_id={$visitId}; note=" . substr($note,0,255)
    : "visit_id={$visitId}; clinician_id={$clinicianId}; note=" . substr($note,0,255);

  $ins = $pdo->prepare(
    "INSERT INTO audit_log (user_id, action, entity, entity_id, details, created_at)
     VALUES (?, 'checkin', ?, ?, ?, NOW())"
  );
  $ins->execute([$who, $entity, (int)$entityId, $details]);
} catch (Throwable $e) { /* best-effort; ignore */ }
 
header('Location: ' . $redirect);
exit;
