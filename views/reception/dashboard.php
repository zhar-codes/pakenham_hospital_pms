<?php
$title  = 'Reception · Dashboard';
$user   = $user ?? 'User Name';
$active = 'dashboard';
$menu   = 'reception';
require_once __DIR__ . '/../../includes/header.php';
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>
  <section class="col-lg-9">
    <div class="row g-3">
      <div class="col-md-4">
        <div class="card"><div class="card-body d-flex justify-content-between align-items-center">
          <div><div class="text-muted small">Arrivals Today</div><div class="h4 mb-0">—</div></div>
          <i class="bi bi-person-walking h3 mb-0"></i>
        </div></div>
      </div>
      <div class="col-md-4">
        <div class="card"><div class="card-body d-flex justify-content-between align-items-center">
          <div><div class="text-muted small">Upcoming Appts</div><div class="h4 mb-0">—</div></div>
          <i class="bi bi-calendar2-check h3 mb-0"></i>
        </div></div>
      </div>
      <div class="col-md-4">
        <div class="card"><div class="card-body d-flex justify-content-between align-items-center">
          <div><div class="text-muted small">Open Tickets</div><div class="h4 mb-0">—</div></div>
          <i class="bi bi-ticket-detailed h3 mb-0"></i>
        </div></div>
      </div>
    </div>

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
                <th style="width:120px;">Time</th><th>Patient</th><th style="width:160px;">Doctor</th>
                <th style="width:120px;">Status</th><th>Notes</th><th class="text-end" style="width:120px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i<6; $i++): ?>
              <tr>
                <td>—</td><td><a href="<?= $routeReception ?>/patients.php?id=<?= $i ?>">—</a></td><td>—</td>
                <td><span class="badge bg-secondary">—</span></td><td class="text-muted">—</td>
                <td class="text-end">
                  <div class="btn-group btn-group-sm">
                    <a class="btn btn-outline-primary" href="#"><i class="bi bi-check2-circle"></i></a>
                    <a class="btn btn-outline-secondary" href="#"><i class="bi bi-pencil"></i></a>
                  </div>
                </td>
              </tr><?php endfor; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
