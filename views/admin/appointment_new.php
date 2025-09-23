<?php declare(strict_types=1);

// Ensure session + guard
require __DIR__ . '/../../includes/auth_guard.php';

$allowed = ['admin','reception','clinician'];
$role = strtolower((string)($_SESSION['auth']['role'] ?? ''));
if (!in_array($role, $allowed, true)) {
  header('Location: /pakenham_hospital_pms/views/public/login.php');
  exit;
}

// (Optional) simple CSRF token for the form
if (empty($_SESSION['csrf'])) {
  $_SESSION['csrf'] = bin2hex(random_bytes(16));
}

require __DIR__ . '/../../includes/header.php';
?>

<div class="container py-3">
  <h1 class="h5 mb-3">New Appointment</h1>

  <?php if (!empty($_SESSION['flash_error'])): ?>
    <div class="alert alert-danger">
      <?= htmlspecialchars($_SESSION['flash_error']); ?>
    </div>
    <?php unset($_SESSION['flash_error']); ?>
  <?php endif; ?>

  <form method="post" action="/pakenham_hospital_pms/controllers/appointments/create.php" class="row g-3">
    <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">

    <div class="col-md-4">
      <label class="form-label">Patient ID</label>
      <input name="patient_id" type="number" class="form-control" required>
    </div>

    <div class="col-md-4">
      <label class="form-label">Clinician ID</label>
      <input name="clinician_id" type="number" class="form-control" required>
    </div>

    <div class="col-md-4">
      <label class="form-label">Date &amp; Time</label>
      <input name="scheduled_at" type="datetime-local" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Reason</label>
      <input name="reason" type="text" maxlength="255" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">Location</label>
      <input name="location" type="text" maxlength="100" class="form-control">
    </div>

    <div class="col-12 d-flex gap-2">
      <button class="btn btn-primary">Book</button>
      <a class="btn btn-outline-secondary" href="/pakenham_hospital_pms/index.php?p=admin/appointments">Cancel</a>
    </div>
  </form>
</div>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
