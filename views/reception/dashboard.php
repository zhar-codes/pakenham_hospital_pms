<?php
declare(strict_types=1);

// Guard: reception only.
require_once __DIR__ . '/../../includes/auth_guard.php';
require_auth_role('reception');

// Ensure PDO + repo
if (!isset($pdo) || !($pdo instanceof PDO)) {
  require_once __DIR__ . '/../../config/db.php';
}
require_once __DIR__ . '/../../lib/VisitRepo.php';

$title  = 'Reception · Dashboard';
$active = 'dashboard';
$menu   = 'reception';

// KPI defaults
$kpi_arrivals_today = '0';
$kpi_upcoming_appts = '0';
$kpi_open_tickets   = '0';

// Table rows for today's arrivals (via VIEW)
$arrivals = [];

try {
  // Arrivals today (view already limited to today)
  $kpi_arrivals_today = (string)($pdo->query("SELECT COUNT(*) FROM v_reception_arrivals_today")->fetchColumn() ?: '0');

  // Upcoming appointments (next 24h, ignoring Cancelled)
  $stmt = $pdo->query("
    SELECT COUNT(*) 
    FROM appointments 
    WHERE scheduled_at >= NOW() 
      AND scheduled_at < NOW() + INTERVAL 1 DAY
      AND status <> 'Cancelled'
  ");
  $kpi_upcoming_appts = (string)($stmt->fetchColumn() ?: '0');

  // Open tickets (if table exists)
  try {
    $kpi_open_tickets = (string)($pdo->query("SELECT COUNT(*) FROM tickets WHERE status='Open'")->fetchColumn() ?: '0');
  } catch (Throwable $e) {
    // leave default if tickets table is missing
  }

  // Arrivals list from read-only view
  $arrivals = VisitRepo::arrivalsToday($pdo);
} catch (Throwable $e) {
  $_SESSION['flash_error'] = 'Failed to load dashboard: ' . $e->getMessage();
}

// Layout header (provides $routeReception and nav)
require_once __DIR__ . '/../../includes/header.php';
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
              <?php if ($arrivals): ?>
                <?php foreach ($arrivals as $r): ?>
                  <tr>
                    <td><?= htmlspecialchars(date('H:i', strtotime($r['checkin_time']))) ?></td>
                    <td><?= htmlspecialchars($r['patient_name'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($r['clinician_name'] ?? '—') ?></td>
                    <td>
                      <?php
                        $st = (string)($r['status'] ?? 'Present');
                        $badge = 'success';
                        if ($st === 'Pending')   $badge = 'secondary';
                        if ($st === 'Cancelled') $badge = 'danger';
                      ?>
                      <span class="badge bg-<?= $badge ?>"><?= htmlspecialchars($st) ?></span>
                    </td>
                    <td class="text-muted"><?= htmlspecialchars($r['notes'] ?? '') ?></td>
                    <td class="text-end">
                      <!-- You can add links/actions here when you have visit IDs -->
                      <div class="btn-group btn-group-sm">
                        <a class="btn btn-outline-primary" href="<?= $routeReception ?>/checkin.php" title="New check-in">
                          <i class="bi bi-check2-circle"></i>
                        </a>
                        <a class="btn btn-outline-secondary" href="<?= $routeReception ?>/patients.php" title="Find patient">
                          <i class="bi bi-search"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-muted">No arrivals yet today.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
