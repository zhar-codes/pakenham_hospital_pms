<?php
// /views/patient/appointments.php
$title  = 'Patient · My Appointments';
$user   = $user ?? 'User Name';
$active = 'pat_appts';
$menu   = 'patient';

require_once __DIR__ . '/../../includes/header.php';
$action = $_GET['action'] ?? '';
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <?php if ($action === 'new'): ?>
      <!-- Book appointment (placeholder form) -->
      <div class="card">
        <div class="card-body">
          <h1 class="h6 mb-3">Book Appointment</h1>
          <form class="row g-3" action="<?= $routePatient ?>/appointments.php" method="post">
            <div class="col-md-6">
              <label class="form-label" for="date">Date</label>
              <input id="date" name="date" type="date" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="time">Time</label>
              <input id="time" name="time" type="time" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="doctor">Doctor</label>
              <select id="doctor" name="doctor" class="form-select">
                <option value="">Select…</option><option>—</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="clinic">Clinic</label>
              <select id="clinic" name="clinic" class="form-select">
                <option value="">Select…</option><option>—</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label" for="reason">Reason</label>
              <input id="reason" name="reason" class="form-control" placeholder="Brief reason">
            </div>
            <div class="col-12 d-flex gap-2">
              <button class="btn btn-primary" type="submit"><i class="bi bi-check2-circle"></i> Submit</button>
              <a class="btn btn-outline-secondary" href="<?= $routePatient ?>/appointments.php">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    <?php else: ?>
      <!-- Appointments list -->
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <h1 class="h6 mb-0">My Appointments</h1>
            <a class="btn btn-primary btn-sm" href="<?= $routePatient ?>/appointments.php?action=new">
              <i class="bi bi-calendar-plus"></i> Book Appointment
            </a>
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
                  <th class="text-end" style="width:120px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php for ($i=0; $i<6; $i++): ?>
                <tr>
                  <td>—</td><td>—</td><td>—</td><td>—</td>
                  <td><span class="badge bg-secondary">—</span></td>
                  <td class="text-end">
                    <div class="btn-group btn-group-sm">
                      <a class="btn btn-outline-secondary" href="#"><i class="bi bi-eye"></i></a>
                      <a class="btn btn-outline-secondary" href="#"><i class="bi bi-pencil"></i></a>
                    </div>
                  </td>
                </tr>
                <?php endfor; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </section>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
