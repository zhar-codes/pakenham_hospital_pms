<?php
declare(strict_types=1);

// Guard: only admins allowed on this page.
require __DIR__ . '/../../includes/auth_guard.php';
require_auth_role('admin');

// Page metadata / state
$title  = 'Admin · Dashboard';
$user   = $_SESSION['auth']['username'] ?? 'Admin';
$active = 'dashboard'; // highlights in navbar/sidebar

// Layout header (this usually boots the app/DB and sets $pdo)
require_once __DIR__ . '/../../includes/header.php';

// Ensure we actually have a PDO (fallback to config if header didn't set it)
if (!isset($pdo) || !($pdo instanceof PDO)) {
    // adjust path if your PDO is built somewhere else
    @require_once __DIR__ . '/../../config/db.php';
}

// ---- KPIs from read-only view v_admin_kpis ----
$kpi_arrivals_today = '—';
$kpi_appts_today    = '—';
$kpi_open_tickets   = '—';
$kpi_date           = date('Y-m-d');

try {
    if (isset($pdo) && $pdo instanceof PDO) {
        require_once __DIR__ . '/../../lib/DashboardRepo.php';
        $kpis = DashboardRepo::getAdminKpis($pdo);
        $kpi_arrivals_today = (string)($kpis['arrivals_today'] ?? '0');
        $kpi_appts_today    = (string)($kpis['appts_today']    ?? '0');
        $kpi_open_tickets   = (string)($kpis['open_tickets']   ?? '0');
        $kpi_date           = (string)($kpis['kpi_date']       ?? $kpi_date);
    }
} catch (Throwable $e) {
    // leave placeholders if anything fails
}
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <!-- Content canvas -->
  <section class="col-lg-9">
    <!-- Top KPIs -->
    <div class="row g-3">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <div class="text-muted small">Today’s Arrivals</div>
                <div class="h4 mb-0"><?= htmlspecialchars($kpi_arrivals_today) ?></div>
              </div>
              <i class="bi bi-person-walking h3 mb-0"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <div class="text-muted small">Appts Scheduled</div>
                <div class="h4 mb-0"><?= htmlspecialchars($kpi_appts_today) ?></div>
              </div>
              <i class="bi bi-calendar2-week h3 mb-0"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <div class="text-muted small">Open Tickets</div>
                <div class="h4 mb-0"><?= htmlspecialchars($kpi_open_tickets) ?></div>
              </div>
              <i class="bi bi-ticket-perforated h3 mb-0"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <small class="text-muted d-block mt-2">KPI date: <?= htmlspecialchars($kpi_date) ?></small>

    <!-- Recent activity (placeholder list; wire up when you add activity feed) -->
    <div class="card mt-3">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h2 class="h6 mb-0">Recent Activity</h2>
          <a href="<?= $routeAdmin ?>/audit.php" class="btn btn-outline-secondary btn-sm">View Audit</a>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">—</li>
          <li class="list-group-item">—</li>
          <li class="list-group-item">—</li>
        </ul>
      </div>
    </div>

    <!-- Quick actions -->
    <div class="card mt-3">
      <div class="card-body">
        <h2 class="h6 mb-3">Quick Actions</h2>
        <div class="d-flex flex-wrap gap-2">
          <a class="btn btn-primary" href="<?= $routeAdmin ?>/appointments.php">
            <i class="bi bi-plus-lg"></i> New Appointment
          </a>
          <a class="btn btn-outline-primary" href="<?= $routeAdmin ?>/patients.php">
            <i class="bi bi-person-plus"></i> New Patient
          </a>
          <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/tickets.php">
            <i class="bi bi-ticket-perforated"></i> New Ticket
          </a>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
