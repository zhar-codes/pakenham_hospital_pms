<?php
// /views/admin/appointments.php
$title  = 'Admin · Appointments';
$user   = $user ?? 'User Name';
$active = 'appointments';

require_once __DIR__ . '/../../includes/header.php';
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <div class="d-flex align-items-center gap-2 mb-3">
      <div class="ms-auto btn-group" role="group" aria-label="View">
        <a href="<?= $routeAdmin ?>/appointments.php?view=list" class="btn btn-outline-primary">List</a>
        <a href="<?= $routeAdmin ?>/appointments.php?view=day"  class="btn btn-primary">Day view</a>
      </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h3 class="h6 mb-0">Filters</h3>
        </div>
        <form class="row g-3" method="get" action="<?= $routeAdmin ?>/appointments.php">
          <div class="col-md-6">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input name="q" class="form-control" placeholder="Search patient, doctor, reason…">
            </div>
          </div>
          <div class="col-md-3">
            <input type="date" name="date" class="form-control">
          </div>
          <div class="col-md-3">
            <select name="status" class="form-select">
              <option value="">All statuses</option>
              <option>Scheduled</option>
              <option>Arrived</option>
              <option>Completed</option>
              <option>Cancelled</option>
            </select>
          </div>
          <div class="col-12 d-flex gap-2">
            <button class="btn btn-primary"><i class="bi bi-funnel"></i> Apply</button>
            <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/appointments.php"><i class="bi bi-x-circle"></i> Clear</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Appointments table -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h3 class="h6 mb-0">Appointments</h3>
          <a class="btn btn-success btn-sm" href="#schedule"><i class="bi bi-plus-lg"></i> New</a>
        </div>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th>Date</th><th>Time</th><th>Patient</th><th>Doctor</th><th>Status</th><th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0;$i<6;$i++): ?>
              <tr>
                <td>—</td><td>—</td><td>—</td><td>—</td>
                <td><span class="badge bg-secondary">—</span></td>
                <td class="text-end">
                  <div class="btn-group btn-group-sm">
                    <a class="btn btn-outline-primary" href="<?= $routeAdmin ?>/appointment_view.php?id=<?= $i ?>"><i class="bi bi-eye"></i> View</a>
                    <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/appointment_edit.php?id=<?= $i ?>"><i class="bi bi-pencil"></i> Edit</a>
                  </div>
                </td>
              </tr>
              <?php endfor; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Doctor day view -->
    <div class="card mb-4">
      <div class="card-body">
        <h3 class="h6 mb-3">Doctor Day View <span class="text-muted">(09:00–17:00)</span></h3>
        <div class="row row-cols-2 row-cols-md-4 g-3">
          <div class="col"><div class="border rounded p-3 h-100">09:00 – 11:00<br><span class="text-muted small">—</span></div></div>
          <div class="col"><div class="border rounded p-3 h-100">11:00 – 13:00<br><span class="text-muted small">—</span></div></div>
          <div class="col"><div class="border rounded p-3 h-100">13:00 – 15:00<br><span class="text-muted small">—</span></div></div>
          <div class="col"><div class="border rounded p-3 h-100">15:00 – 17:00<br><span class="text-muted small">—</span></div></div>
        </div>
      </div>
    </div>

    <!-- Schedule appointment -->
    <div id="schedule" class="card">
      <div class="card-body">
        <h3 class="h6 mb-3">Schedule Appointment</h3>
        <form class="row g-3" action="<?= $routeAdmin ?>/appointment_save.php" method="post" novalidate>
          <div class="col-md-6">
            <label for="pat" class="form-label">Patient</label>
            <input id="pat" name="patient" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label for="doc" class="form-label">Doctor</label>
            <input id="doc" name="doctor" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label for="dt" class="form-label">Date / Time</label>
            <input id="dt" name="datetime" type="datetime-local" class="form-control is-invalid">
            <div class="invalid-feedback">Doctor already booked at this time</div>
          </div>
          <div class="col-md-6">
            <label for="reason" class="form-label">Reason</label>
            <input id="reason" name="reason" class="form-control">
          </div>
          <div class="col-12 d-flex gap-2">
            <button class="btn btn-primary" type="submit"><i class="bi bi-check2-circle"></i> Save</button>
            <button class="btn btn-outline-secondary" type="reset">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
