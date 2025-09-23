<?php
declare(strict_types=1);

// Guard: patients only.
require __DIR__ . '/../../includes/auth_guard.php';
require_auth_role('patient');

// Ensure PDO
if (!isset($pdo) || !($pdo instanceof PDO)) {
  require_once __DIR__ . '/../../config/db.php';
}

// Page metadata / state
$title  = 'Patient · Dashboard';
$active = 'pat_dashboard';
$menu   = 'patient';

$sessionUser  = $_SESSION['auth']['username'] ?? 'Patient';
$sessionEmail = $_SESSION['auth']['email'] ?? null;

// Defaults (safe placeholders)
$profile = [
  'patient_id' => '—',
  'name'       => $sessionUser,
  'email'      => $sessionEmail ?: '—',
  'phone'      => '—',
];

$appointments = []; // upcoming appointments from the view

try {
  // Map current user -> patient record
  $uid = (int)($_SESSION['auth']['id'] ?? 0);

  // Pull patient + contact info (optional user link)
  $sql = "
      SELECT p.id AS patient_id,
             CONCAT(p.first_name,' ',p.last_name) AS full_name,
             COALESCE(u.email, p.email) AS email,
             p.phone
      FROM patients p
      LEFT JOIN users u ON u.id = p.user_id
      WHERE p.user_id = :uid
      LIMIT 1
  ";
  $st = $pdo->prepare($sql);
  $st->execute([':uid' => $uid]);
  if ($row = $st->fetch()) {
    $profile['patient_id'] = (string)$row['patient_id'];
    $profile['name']       = $row['full_name'] ?: $profile['name'];
    $profile['email']      = $row['email']     ?: $profile['email'];
    $profile['phone']      = $row['phone']     ?: $profile['phone'];
  }

  // Upcoming appointments for this patient (via VIEW)
  if ($profile['patient_id'] !== '—') {
    $st = $pdo->prepare("
      SELECT
        appointment_id,
        patient_id,
        clinician_id,
        clinician_name,
        scheduled_at,
        DATE_FORMAT(scheduled_at, '%Y-%m-%d') AS d,
        DATE_FORMAT(scheduled_at, '%H:%i')     AS t,
        status
      FROM v_patient_upcoming_appointments
      WHERE patient_id = :pid
      ORDER BY scheduled_at
      LIMIT 10
    ");
    $st->execute([':pid' => (int)$profile['patient_id']]);
    $appointments = $st->fetchAll() ?: [];
  }
} catch (Throwable $e) {
  // Keep placeholders; avoid fatal on dashboard.
}

// Layout header (provides routes + nav)
require_once __DIR__ . '/../../includes/header.php';
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <!-- Profile summary -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h1 class="h6 mb-0">Profile Summary</h1>
          <a class="btn btn-outline-secondary btn-sm" href="<?= $routePatient ?>/profile.php">
            <i class="bi bi-person-lines-fill"></i> View Profile
          </a>
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <div class="border rounded p-3 h-100">
              <div class="text-muted small">Name</div>
              <div class="fw-semibold"><?= htmlspecialchars($profile['name']) ?></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="border rounded p-3 h-100">
              <div class="text-muted small">Patient ID</div>
              <div class="fw-semibold"><?= htmlspecialchars($profile['patient_id']) ?></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="border rounded p-3 h-100">
              <div class="text-muted small">Email</div>
              <div class="fw-semibold"><?= htmlspecialchars($profile['email']) ?></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="border rounded p-3 h-100">
              <div class="text-muted small">Phone</div>
              <div class="fw-semibold"><?= htmlspecialchars($profile['phone']) ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- My Appointments -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h2 class="h6 mb-0">My Appointments</h2>
          <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary btn-sm" href="<?= $routePatient ?>/appointments.php">
              <i class="bi bi-list-check"></i> View All
            </a>
            <a class="btn btn-primary btn-sm" href="<?= $routePatient ?>/appointments.php?action=new">
              <i class="bi bi-calendar-plus"></i> Book Appointment
            </a>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th style="width:130px;">Date</th>
                <th style="width:110px;">Time</th>
                <th>Doctor</th>
                <th style="width:120px;">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($appointments)): ?>
                <?php foreach ($appointments as $a): ?>
                  <tr>
                    <td><?= htmlspecialchars($a['d']) ?></td>
                    <td><?= htmlspecialchars($a['t']) ?></td>
                    <td><?= htmlspecialchars($a['clinician_name']) ?></td>
                    <td>
                      <?php
                        $st = (string)($a['status'] ?? '—');
                        $badge = 'secondary';
                        if ($st === 'Scheduled')  $badge = 'info';
                        if ($st === 'Checked-in') $badge = 'success';
                        if ($st === 'Cancelled')  $badge = 'danger';
                      ?>
                      <span class="badge bg-<?= $badge ?>"><?= htmlspecialchars($st) ?></span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="4" class="text-muted">No upcoming appointments.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="d-flex gap-2 mt-2">
          <a class="btn btn-primary" href="<?= $routePatient ?>/appointments.php?action=new">
            <i class="bi bi-calendar-plus"></i> Book appointment
          </a>
          <a class="btn btn-outline-secondary" href="<?= $routePatient ?>/helpdesk.php">
            <i class="bi bi-life-preserver"></i> Open Helpdesk
          </a>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
