<?php
$title  = 'Reception · Appointment Form';
$user   = $user ?? 'User Name';
$active = 'appointments';
$menu   = 'reception';
require_once __DIR__ . '/../../includes/header.php';
$id  = $_GET['id']  ?? null;  // edit mode if present
$pid = $_GET['pid'] ?? null;  // preselect patient if provided
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>
  <section class="col-lg-9">
    <div class="card"><div class="card-body">
      <h1 class="h6 mb-3"><?= $id ? 'Edit' : 'New' ?> Appointment</h1>
      <form class="row g-3" method="post" action="<?= $routeReception ?>/appointments.php">
        <div class="col-md-6"><label class="form-label" for="date">Date</label><input id="date" name="date" type="date" class="form-control"></div>
        <div class="col-md-6"><label class="form-label" for="time">Time</label><input id="time" name="time" type="time" class="form-control"></div>
        <div class="col-md-6"><label class="form-label" for="patient">Patient</label>
          <select id="patient" name="patient" class="form-select"><option value="">Select…</option><option value="<?= htmlspecialchars($pid ?? '') ?>">—</option></select>
        </div>
        <div class="col-md-6"><label class="form-label" for="doctor">Doctor</label>
          <select id="doctor" name="doctor" class="form-select"><option value="">Select…</option><option>—</option></select>
        </div>
        <div class="col-md-6"><label class="form-label" for="clinic">Clinic</label>
          <select id="clinic" name="clinic" class="form-select"><option value="">Select…</option><option>—</option></select>
        </div>
        <div class="col-md-6"><label class="form-label" for="status">Status</label>
          <select id="status" name="status" class="form-select"><option>Booked</option><option>Checked-in</option><option>Completed</option><option>Cancelled</option></select>
        </div>
        <div class="col-12"><label class="form-label" for="reason">Reason</label><input id="reason" name="reason" class="form-control" placeholder="Brief reason"></div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary" type="submit"><i class="bi bi-check2-circle"></i> Save</button>
          <a class="btn btn-outline-secondary" href="<?= $routeReception ?>/appointments.php">Cancel</a>
        </div>
      </form>
    </div></div>
  </section>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
