<?php declare(strict_types=1);

// Guard FIRST, before any output
require_once __DIR__ . '/../../includes/auth_guard.php';
require_auth_role('clinician');

// Ensure PDO + repos
if (!isset($pdo) || !($pdo instanceof PDO)) {
  require_once __DIR__ . '/../../config/db.php';
}
require_once __DIR__ . '/../../lib/ClinicianRepo.php';
require_once __DIR__ . '/../../lib/VisitRepo.php';

// Map session user -> clinicians.id
$userId = (int)($_SESSION['auth']['id'] ?? 0);
$clinicianId = ClinicianRepo::getClinicianIdByUser($pdo, $userId);
if (!$clinicianId) {
  $_SESSION['flash_error'] = 'No clinician profile linked to this account.';
  header('Location: ' . base_url() . '/index.php?p=public/login');
  exit;
}

// Load KPIs + today’s schedule via the repo
$kpis         = ClinicianRepo::getKpis($pdo, $clinicianId, $userId);
$scheduleRows = ClinicianRepo::getTodaySchedule($pdo, $clinicianId);

// Map of patient_id => open visit_id (today, no checkout)
$openVisits = VisitRepo::openVisitsForClinicianToday($pdo, $clinicianId);

// Page meta/state (before layout include)
$title  = 'Clinician · Dashboard';
$user   = $_SESSION['auth']['username'] ?? 'Clinician';
$active = 'clin_dashboard';   // your own flag for nav highlight

// Bring in the layout header (sets $baseUrl, nav, etc.)
include __DIR__ . '/../_layout_top.php';

// Role route prefix
$routeClinician = $baseUrl . '/index.php?p=clinician';
?>

<div class="row g-4">

  <?php if (file_exists(__DIR__ . '/_sidebar.php')) require __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <!-- Top KPIs -->
    <div class="row g-3">
      <div class="col-md-4">
        <div class="card"><div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Today’s Patients</div>
              <div class="h4 mb-0"><?= htmlspecialchars((string)($kpis['distinct_patients_today'] ?? '0')) ?></div>
            </div>
            <i class="bi bi-people h3 mb-0"></i>
          </div>
        </div></div>
      </div>
      <div class="col-md-4">
        <div class="card"><div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Next Appointment</div>
              <div class="h4 mb-0"><?= htmlspecialchars((string)($kpis['next_appt_time'] ?? '—')) ?></div>
            </div>
            <i class="bi bi-calendar2-week h3 mb-0"></i>
          </div>
        </div></div>
      </div>
      <div class="col-md-4">
        <div class="card"><div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Unread Messages</div>
              <div class="h4 mb-0"><?= htmlspecialchars((string)($kpis['unread_msgs'] ?? '0')) ?></div>
            </div>
            <i class="bi bi-envelope h3 mb-0"></i>
          </div>
        </div></div>
      </div>
    </div>

    <!-- My Schedule — Today -->
    <div class="card mt-3">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h1 class="h6 mb-0">My Schedule — Today</h1>
          <a class="btn btn-outline-secondary btn-sm" href="<?= $routeClinician ?>/schedule.php">View full schedule</a>
        </div>

        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th style="width:120px;">Time</th>
                <th>Patient</th>
                <th style="width:200px;">Reason</th>
                <th style="width:120px;">Status</th>
                <th class="text-end" style="width:160px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($scheduleRows): ?>
                <?php foreach ($scheduleRows as $r): ?>
                  <tr>
                    <td><?= htmlspecialchars($r['time'] ?? '') ?></td>
                    <td>
                      <a href="<?= $routeClinician ?>/patient_view.php?id=<?= (int)($r['patient_id'] ?? 0) ?>">
                        <?= htmlspecialchars($r['patient_name'] ?? '—') ?>
                      </a>
                    </td>
                    <td><?= htmlspecialchars($r['reason'] ?? '—') ?></td>
                    <td>
                      <?php
                        $status = (string)($r['status'] ?? '—');
                        $badge  = 'secondary';
                        if ($status === 'Scheduled')  $badge = 'info';
                        if ($status === 'Checked-in') $badge = 'success';
                        if ($status === 'Cancelled')  $badge = 'danger';
                      ?>
                      <span class="badge bg-<?= $badge ?>"><?= htmlspecialchars($status) ?></span>
                    </td>
                    <td class="text-end">
                      <div class="btn-group btn-group-sm">
                        <?php if (!empty($r['appointment_id'])): ?>
                          <a class="btn btn-outline-primary"
                             href="<?= $routeClinician ?>/appointments.php?show=<?= (int)$r['appointment_id'] ?>">
                            View
                          </a>
                        <?php endif; ?>

                        <?php
                          $pid = (int)($r['patient_id'] ?? 0);
                          $visitId = $openVisits[$pid] ?? null;
                        ?>
                        <?php if ($visitId): ?>
                          <form method="post" action="<?= $baseUrl ?>/index.php?p=visits/complete" class="d-inline">
                            <input type="hidden" name="visit_id" value="<?= (int)$visitId ?>">
                            <button type="submit" class="btn btn-success" title="Complete visit">Complete</button>
                          </form>
                        <?php endif; ?>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="5" class="text-muted">No appointments today.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="d-flex gap-2 mt-2">
          <a class="btn btn-primary" href="<?= $routeClinician ?>/patients.php">
            <i class="bi bi-people"></i> View Patients
          </a>
          <a class="btn btn-outline-secondary" href="<?= $routeClinician ?>/note_new.php">
            <i class="bi bi-journal-plus"></i> Write Note
          </a>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include __DIR__ . '/../_layout_bottom.php'; ?>
