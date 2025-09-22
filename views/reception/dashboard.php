<?php
declare(strict_types=1);

// Guard: reception only.
require __DIR__ . '/../../includes/auth_guard.php';
require_auth_role('reception');

$title  = 'Reception · Dashboard';
$active = 'dashboard';
$menu   = 'reception';

// KPI defaults
$kpi_arrivals_today = '—';
$kpi_upcoming_appts = '—';
$kpi_open_tickets   = '—'; // placeholder until a tickets table exists

// Table rows for today's arrivals
$arrivals = [];

try {
    if (isset($pdo) && $pdo instanceof PDO) {
        // Arrivals today = visits with checkin_time today
        $kpi_arrivals_today = (string)(
            $pdo->query("SELECT COUNT(*) AS n
                         FROM visits
                         WHERE DATE(checkin_time) = CURRENT_DATE()")
                ->fetch()['n'] ?? '0'
        );

        // Upcoming appointments (next 24h) – adjust window as you like
        $stmt = $pdo->prepare("
            SELECT COUNT(*) AS n
            FROM appointments
            WHERE scheduled_at BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 DAY)
        ");
        $stmt->execute();
        $kpi_upcoming_appts = (string)($stmt->fetch()['n'] ?? '0');

        // Today’s arrivals table
        $stmt = $pdo->prepare("
            SELECT
                DATE_FORMAT(v.checkin_time, '%H:%i')   AS time,
                CONCAT(p.first_name,' ',p.last_name)   AS patient,
                CONCAT(c.first_name,' ',c.last_name)   AS clinician,
                COALESCE(v.status, 'Present')          AS status,
                COALESCE(v.notes,  '')                 AS notes,
                p.id AS patient_id
            FROM visits v
            JOIN patients   p ON p.id = v.patient_id
            LEFT JOIN clinicians c ON c.id = v.clinician_id
            WHERE DATE(v.checkin_time) = CURRENT_DATE()
            ORDER BY v.checkin_time DESC, v.id DESC
            LIMIT 50
        ");
        $stmt->execute();
        $arrivals = $stmt->fetchAll() ?: [];

        // Tickets placeholder example (uncomment when you add tickets table)
        // $kpi_open_tickets = (string)(
        //     $pdo->query("SELECT COUNT(*) AS n FROM tickets WHERE status='Open'")
        //         ->fetch()['n'] ?? '0'
        // );
    }
} catch (Throwable $e) {
    // Keep placeholders; do not break the dashboard
}

require_once __DIR__ . '/../../includes/header.php'; // provides $routeReception and loads nav
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <!-- KPIs -->
    <div class="row g-3">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Arrivals Today</div>
              <div class="h4 mb-0"><?= htmlspecialchars($kpi_arrivals_today) ?></div>
            </div>
            <i class="bi bi-person-walking h3 mb-0"></i>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Upcoming Appts (24h)</div>
              <div class="h4 mb-0"><?= htmlspecialchars($kpi_upcoming_appts) ?></div>
            </div>
            <i class="bi bi-calendar2-check h3 mb-0"></i>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Open Tickets</div>
              <div class="h4 mb-0"><?= htmlspecialchars($kpi_open_tickets) ?></div>
            </div>
            <i class="bi bi-ticket-detailed h3 mb-0"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Arrivals Today -->
    <div class="card mt-3">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h1 class="h6 mb-0">Arrivals Today</h1>
          <a class="btn btn-outline-secondary btn-sm" href="<?= $routeReception ?>/checkin.php">
            <i class="bi bi-qr-code-scan"></i> Go to Check-in
          </a>
        </div>

        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th style="width:120px;">Time</th>
                <th>Patient</th>
                <th style="width:180px;">Doctor</th>
                <th style="width:120px;">Status</th>
                <th>Notes</th>
                <th class="text-end" style="width:120px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($arrivals)): ?>
                <?php foreach ($arrivals as $row): ?>
                  <tr>
                    <td><?= htmlspecialchars($row['time']) ?></td>
                    <td><a href="<?= $routeReception ?>/patients.php?id=<?= (int)$row['patient_id'] ?>">
                      <?= htmlspecialchars($row['patient']) ?>
                    </a></td>
                    <td><?= htmlspecialchars($row['clinician'] ?? '—') ?></td>
                    <td><span class="badge bg-secondary"><?= htmlspecialchars($row['status']) ?></span></td>
                    <td class="text-muted"><?= htmlspecialchars($row['notes']) ?></td>
                    <td class="text-end">
                      <div class="btn-group btn-group-sm">
                        <a class="btn btn-outline-primary" href="<?= $routeReception ?>/checkin_complete.php?pid=<?= (int)$row['patient_id'] ?>">
                          <i class="bi bi-check2-circle"></i>
                        </a>
                        <a class="btn btn-outline-secondary" href="<?= $routeReception ?>/visit_edit.php?pid=<?= (int)$row['patient_id'] ?>">
                          <i class="bi bi-pencil"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <?php for ($i=0; $i<6; $i++): ?>
                  <tr>
                    <td>—</td>
                    <td><a href="<?= $routeReception ?>/patients.php?id=<?= $i ?>">—</a></td>
                    <td>—</td>
                    <td><span class="badge bg-secondary">—</span></td>
                    <td class="text-muted">—</td>
                    <td class="text-end">
                      <div class="btn-group btn-group-sm">
                        <a class="btn btn-outline-primary" href="#"><i class="bi bi-check2-circle"></i></a>
                        <a class="btn btn-outline-secondary" href="#"><i class="bi bi-pencil"></i></a>
                      </div>
                    </td>
                  </tr>
                <?php endfor; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
