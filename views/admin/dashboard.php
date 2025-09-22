<?php
declare(strict_types=1);

// Guard: only admins allowed on this page.
require __DIR__ . '/../../includes/auth_guard.php';
require_auth_role('admin');

// Page metadata / state
$title  = 'Admin · Dashboard';
$user   = $_SESSION['auth']['username'] ?? 'Admin';
$active = 'dashboard'; // highlights in navbar/sidebar

// Try to populate simple KPIs from DB if PDO ($pdo) is available.
// Safe defaults so the page never fatals.
$kpi_arrivals_today = '—';
$kpi_appts_today    = '—';
$kpi_open_tickets   = '—'; // placeholder until a tickets table exists

try {
    // If header.php (or other include) provides $pdo, we can query.
    if (isset($pdo) && $pdo instanceof PDO) {
        // Arrivals today = visits with a check-in today
        $kpi_arrivals_today = (string)(
            $pdo->query("SELECT COUNT(*) AS n
                         FROM visits
                         WHERE DATE(checkin_time) = CURRENT_DATE()")
                ->fetch()['n'] ?? '0'
        );

        // Appointments scheduled today
        $kpi_appts_today = (string)(
            $pdo->query("SELECT COUNT(*) AS n
                         FROM appointments
                         WHERE DATE(scheduled_at) = CURRENT_DATE()")
                ->fetch()['n'] ?? '0'
        );

        // If you later add a tickets table, replace this query.
        // $kpi_open_tickets = (string)(
        //     $pdo->query("SELECT COUNT(*) AS n FROM tickets WHERE status='Open'")
        //         ->fetch()['n'] ?? '0'
        // );
    }
} catch (Throwable $e) {
    // Leave KPIs as placeholders if anything fails.
}

// Layout header (sets $baseUrl, $routeAdmin, loads nav, etc.)
require_once __DIR__ . '/../../includes/header.php';
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
