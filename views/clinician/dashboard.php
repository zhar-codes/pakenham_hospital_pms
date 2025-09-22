<?php
declare(strict_types=1);

// Guard: clinicians only.
require __DIR__ . '/../../includes/auth_guard.php';
require_auth_role('clinician');

// Page metadata / state
$title  = 'Clinician · Dashboard';
$user   = $_SESSION['auth']['username'] ?? 'Clinician';
$active = 'clin_dashboard';   // highlights in clinician sidebar/top
$menu   = 'clinician';        // tells header.php to use clinician menu

// Defaults for KPIs
$kpi_patients_today = '—';
$kpi_next_appt      = '—';
$kpi_unread_msgs    = '—'; // placeholder until a messages table exists

// Data for schedule table
$schedule_rows = [];

// Try to fetch clinician_id and today’s data if PDO is available
try {
    if (isset($pdo) && $pdo instanceof PDO) {
        // 1) Find this clinician’s id via the logged-in user id
        $userId = (int)($_SESSION['auth']['id'] ?? 0);
        $stmt = $pdo->prepare("SELECT id FROM clinicians WHERE user_id = :uid LIMIT 1");
        $stmt->execute([':uid' => $userId]);
        $clinicianId = (int)($stmt->fetch()['id'] ?? 0);

        if ($clinicianId > 0) {
            // 2) KPI: Today’s distinct patients for this clinician
            $stmt = $pdo->prepare("
                SELECT COUNT(DISTINCT patient_id) AS n
                FROM appointments
                WHERE clinician_id = :cid
                  AND DATE(scheduled_at) = CURRENT_DATE()
            ");
            $stmt->execute([':cid' => $clinicianId]);
            $kpi_patients_today = (string)($stmt->fetch()['n'] ?? '0');

            // 3) KPI: Next appointment (time) today
            $stmt = $pdo->prepare("
                SELECT DATE_FORMAT(scheduled_at, '%H:%i') AS t
                FROM appointments
                WHERE clinician_id = :cid
                  AND DATE(scheduled_at) = CURRENT_DATE()
                  AND scheduled_at >= NOW()
                ORDER BY scheduled_at ASC
                LIMIT 1
            ");
            $stmt->execute([':cid' => $clinicianId]);
            $kpi_next_appt = (string)($stmt->fetch()['t'] ?? '—');

            // 4) Today’s schedule rows
            $stmt = $pdo->prepare("
                SELECT
                    a.id,
                    DATE_FORMAT(a.scheduled_at, '%H:%i') AS time,
                    CONCAT(p.first_name, ' ', p.last_name) AS patient,
                    a.reason,
                    a.status,
                    '' AS notes   -- placeholder; replace when you store clinician notes
                FROM appointments a
                JOIN patients p ON p.id = a.patient_id
                WHERE a.clinician_id = :cid
                  AND DATE(a.scheduled_at) = CURRENT_DATE()
                ORDER BY a.scheduled_at ASC, a.id ASC
                LIMIT 50
            ");
            $stmt->execute([':cid' => $clinicianId]);
            $schedule_rows = $stmt->fetchAll() ?: [];
        }

        // 5) Messages KPI placeholder – wire up when you add a messages table
        // $stmt = $pdo->prepare("SELECT COUNT(*) AS n FROM messages WHERE clinician_id=:cid AND is_read=0");
        // $stmt->execute([':cid' => $clinicianId]);
        // $kpi_unread_msgs = (string)($stmt->fetch()['n'] ?? '0');
    }
} catch (Throwable $e) {
    // Leave placeholders if anything fails; never fatal the page.
}

// Layout header (provides $routeClinician and loads nav)
require_once __DIR__ . '/../../includes/header.php';
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <!-- Top KPIs -->
    <div class="row g-3">
      <div class="col-md-4">
        <div class="card"><div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Today’s Patients</div>
              <div class="h4 mb-0"><?= htmlspecialchars($kpi_patients_today) ?></div>
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
              <div class="h4 mb-0"><?= htmlspecialchars($kpi_next_appt) ?></div>
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
              <div class="h4 mb-0"><?= htmlspecialchars($kpi_unread_msgs) ?></div>
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
                <th>Notes</th>
                <th class="text-end" style="width:120px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($schedule_rows)): ?>
                <?php foreach ($schedule_rows as $row): ?>
                  <tr>
                    <td><?= htmlspecialchars($row['time']) ?></td>
                    <td><a href="<?= $routeClinician ?>/patient_view.php?id=<?= (int)$row['id'] ?>"><?= htmlspecialchars($row['patient']) ?></a></td>
                    <td><?= htmlspecialchars($row['reason'] ?? '—') ?></td>
                    <td><span class="badge bg-secondary"><?= htmlspecialchars($row['status'] ?? '—') ?></span></td>
                    <td class="text-muted"><?= htmlspecialchars($row['notes'] ?? '—') ?></td>
                    <td class="text-end">
                      <div class="btn-group btn-group-sm">
                        <a class="btn btn-outline-primary" href="<?= $routeClinician ?>/note_new.php?appt=<?= (int)$row['id'] ?>"><i class="bi bi-journal-text"></i></a>
                        <a class="btn btn-outline-secondary" href="<?= $routeClinician ?>/appointment_edit.php?id=<?= (int)$row['id'] ?>"><i class="bi bi-pencil"></i></a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <?php for ($i=0; $i<3; $i++): ?>
                  <tr>
                    <td>—</td>
                    <td><a href="<?= $routeClinician ?>/patient_view.php?id=<?= $i ?>">—</a></td>
                    <td>—</td>
                    <td><span class="badge bg-secondary">—</span></td>
                    <td class="text-muted">—</td>
                    <td class="text-end">
                      <div class="btn-group btn-group-sm">
                        <a class="btn btn-outline-primary" href="<?= $routeClinician ?>/note_new.php"><i class="bi bi-journal-text"></i></a>
                        <a class="btn btn-outline-secondary" href="<?= $routeClinician ?>/appointment_edit.php"><i class="bi bi-pencil"></i></a>
                      </div>
                    </td>
                  </tr>
                <?php endfor; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="d-flex gap-2 mt-2">
          <a class="btn btn-primary" href="<?= $routeClinician ?>/patients.php"><i class="bi bi-people"></i> View Patients</a>
          <a class="btn btn-outline-secondary" href="<?= $routeClinician ?>/note_new.php"><i class="bi bi-journal-plus"></i> Write Note</a>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
