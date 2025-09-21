<?php
// /views/clinician/dashboard.php
$title  = 'Clinician · Dashboard';
$user   = $user ?? 'User Name';
$active = 'clin_dashboard';   // highlights in clinician sidebar/top
$menu   = 'clinician';        // tells header.php to use clinician menu

require_once __DIR__ . '/../../includes/header.php'; // provides $routeClinician and loads nav
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
              <div class="h4 mb-0">—</div>
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
              <div class="text-muted small">Unread Messages</div>
              <div class="h4 mb-0">—</div>
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
          <a class="btn btn-outline-secondary btn-sm" href="<?= $routeClinician ?>/schedule.php">
            View full schedule
          </a>
        </div>

        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th style="width:120px;">Time</th>
                <th>Patient</th>
                <th style="width:180px;">Reason</th>
                <th style="width:120px;">Status</th>
                <th>Notes</th>
                <th class="text-end" style="width:120px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i<6; $i++): ?>
              <tr>
                <td>—</td>
                <td><a href="<?= $routeClinician ?>/patient_view.php?id=<?= $i ?>">—</a></td>
                <td>—</td>
                <td><span class="badge bg-secondary">—</span></td>
                <td class="text-muted">—</td>
                <td class="text-end">
                  <div class="btn-group btn-group-sm">
                    <a class="btn btn-outline-primary" href="<?= $routeClinician ?>/note_new.php?pid=<?= $i ?>"><i class="bi bi-journal-text"></i></a>
                    <a class="btn btn-outline-secondary" href="<?= $routeClinician ?>/appointment_edit.php?id=<?= $i ?>"><i class="bi bi-pencil"></i></a>
                  </div>
                </td>
              </tr>
              <?php endfor; ?>
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
