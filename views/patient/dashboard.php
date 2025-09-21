<?php
// /views/patient/dashboard.php
$title  = 'Patient · Dashboard';
$user   = $user ?? 'User Name';
$active = 'pat_dashboard';   // highlights in patient sidebar/top
$menu   = 'patient';         // tells header.php to use patient menu

require_once __DIR__ . '/../../includes/header.php'; // provides $routePatient and loads nav
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
              <div class="fw-semibold"><?= htmlspecialchars($user) ?></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="border rounded p-3 h-100">
              <div class="text-muted small">Patient ID</div>
              <div class="fw-semibold">—</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="border rounded p-3 h-100">
              <div class="text-muted small">Email</div>
              <div class="fw-semibold">user@example.com</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="border rounded p-3 h-100">
              <div class="text-muted small">Phone</div>
              <div class="fw-semibold">—</div>
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
                <th style="width:160px;">Location</th>
                <th style="width:120px;">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i<4; $i++): ?>
              <tr>
                <td>—</td>
                <td>—</td>
                <td>—</td>
                <td>—</td>
                <td><span class="badge bg-secondary">—</span></td>
              </tr>
              <?php endfor; ?>
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
