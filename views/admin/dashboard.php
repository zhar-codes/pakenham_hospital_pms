<?php
// /views/admin/dashboard.php
$title  = 'Admin · Dashboard';
$user   = $user ?? 'User Name';
$active = 'dashboard';   // highlights Dashboard in navbar (if shown) and sidebar

require_once __DIR__ . '/../../includes/header.php'; // sets $baseUrl, $routeAdmin and loads /includes/nav.php
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <!-- Content canvas -->
  <section class="col-lg-9">
    <!-- Top KPIs -->
    <div class="row g-3">
      <div class="col-md-4">
        <div class="card"><div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Today’s Arrivals</div>
              <div class="h4 mb-0">—</div>
            </div>
            <i class="bi bi-person-walking h3 mb-0"></i>
          </div>
        </div></div>
      </div>
      <div class="col-md-4">
        <div class="card"><div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Appts Scheduled</div>
              <div class="h4 mb-0">—</div>
            </div>
            <i class="bi bi-calendar2-week h3 mb-0"></i>
          </div>
        </div></div>
      </div>
      <div class="col-md-4">
        <div class="card"><div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="text-muted small">Open Tickets</div>
              <div class="h4 mb-0">—</div>
            </div>
            <i class="bi bi-ticket-perforated h3 mb-0"></i>
          </div>
        </div></div>
      </div>
    </div>

    <!-- Recent activity -->
    <div class="card mt-3">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h2 class="h6 mb-0">Recent Activity</h2>
          <a href="<?= $routeAdmin ?>/audit.php" class="btn btn-outline-secondary btn-sm">
            View Audit
          </a>
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
          <a class="btn btn-primary" href="<?= $routeAdmin ?>/appointments.php"><i class="bi bi-plus-lg"></i> New Appointment</a>
          <a class="btn btn-outline-primary" href="<?= $routeAdmin ?>/patients.php"><i class="bi bi-person-plus"></i> New Patient</a>
          <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/tickets.php"><i class="bi bi-ticket-perforated"></i> New Ticket</a>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
