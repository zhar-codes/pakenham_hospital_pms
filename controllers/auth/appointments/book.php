<?php declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../includes/auth_guard.php';
require_auth_roles(['reception','patient','admin']);

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../lib/AppointmentRepo.php';

// Redirect back to the right page based on role
$role = strtolower((string)($_SESSION['auth']['role'] ?? ''));
$redirect = $role === 'patient'
  ? base_url() . '/index.php?p=patient/appointments'
  : base_url() . '/index.php?p=reception/appointments';

try {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    throw new RuntimeException('Invalid request');
  }

  $patientId   = (int)($_POST['patient_id'] ?? 0);
  $clinicianId = (int)($_POST['clinician_id'] ?? 0);
  $whenRaw     = trim((string)($_POST['scheduled_at'] ?? '')); // from <input type="datetime-local">
  $reason      = trim((string)($_POST['reason'] ?? ''));
  $location    = trim((string)($_POST['location'] ?? ''));

  if ($patientId <= 0 || $clinicianId <= 0 || $whenRaw === '') {
    throw new RuntimeException('Missing patient, clinician, or date/time.');
  }

  // Normalize HTML datetime-local "YYYY-MM-DDTHH:MM" -> "YYYY-MM-DD HH:MM"
  $when = str_replace('T', ' ', substr($whenRaw, 0, 16));

  $newId = AppointmentRepo::book($pdo, $patientId, $clinicianId, $when, $reason, $location);
  $_SESSION['flash'] = "Appointment #$newId created.";
} catch (Throwable $e) {
  $_SESSION['flash_error'] = $e->getMessage();
}
// Audit: appointment booked
try {
  $who = (int)($_SESSION['auth']['id'] ?? 0);
  $det = "patient_id={$patientId}; clinician_id={$clinicianId}; when={$when}; reason=" . substr($reason,0,255);
  $ins = $pdo->prepare(
    "INSERT INTO audit_log (user_id, action, entity, entity_id, details, created_at)
     VALUES (?, 'book_appointment', 'appointment', ?, ?, NOW())"
  );
  $ins->execute([$who, (int)$newId, $det]);
} catch (Throwable $e) { /* ignore */ }


header('Location: ' . $redirect);
exit;
