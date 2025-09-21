<?php
$title  = 'Reception · Appointments';
$user   = $user ?? 'User Name';
$active = 'appointments';
$menu   = 'reception';
require_once __DIR__ . '/../../includes/header.php';
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>
  <section class="col-lg-9">
    <div class="card mb-4"><div class="card-body">
      <form class="row g-3 align-items-end" method="get" action="<?= $routeReception ?>/appointments.php">
        <div class="col-md-3">
          <label class="form-label" for="date_from">From</label>
          <input id="date_from" name="from" type="date" class="form-control" value="<?= htmlspecialchars($_GET['from'] ?? '') ?>">
        </div>
        <div class="col-md-3">
          <label class="form-label" for="date_to">To</label>
          <input id="date_to" name="to" type="date" class="form-control" value="<?= htmlspecialchars($_GET['to'] ?? '') ?>">
        </div>
        <div class="col-md-3">
          <label class="form-label" for="doctor">Doctor</label>
          <select id="doctor" name="doctor" class="form-select"><option value="">All doctors</option><option>—</option></select>
        </div>
        <div class="col-md-3">
          <label class="form-label" for="status">Status</label>
          <select id="status" name="status" class="form-select">
            <option value="">All</option><option>Booked</option><option>Checked-in</option><option>Completed</option><option>Cancelled</option>
          </select>
        </div>
        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary" type="submit"><i class="bi bi-funnel"></i> Apply</button>
          <a class="btn btn-outline-secondary" href="<?= $routeReception ?>/appointments.php"><i class="bi bi-x-circle"></i> Clear</a>
          <a class="btn btn-success ms-auto" href="<?= $routeReception ?>/appointment_form.php"><i class="bi bi-calendar-plus"></i> New Appointment</a>
        </div>
      </form>
    </div></div>

    <div class="card"><div class="card-body">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead class="table-light">
            <tr>
              <th style="width:130px;">Date</th><th style="width:110px;">Time</th><th>Patient</th>
              <th style="width:160px;">Doctor</th><th style="width:120px;">Status</th>
              <th class="text-end" style="width:160px;">Actions</th>
            </tr>
          </thead>
          <tbody><?php for ($i=0; $i<8; $i++): ?>
            <tr>
              <td>—</td><td>—</td><td><a href="<?= $routeReception ?>/patients.php?id=<?= $i ?>">—</a></td>
              <td>—</td><td><span class="badge bg-secondary">—</span></td>
              <td class="text-end">
                <div class="btn-group btn-group-sm">
                  <a class="btn btn-outline-primary" href="#"><i class="bi bi-check2-circle"></i></a>
                  <a class="btn btn-outline-secondary" href="<?= $routeReception ?>/appointment_form.php?id=<?= $i ?>"><i class="bi bi-pencil"></i></a>
                  <a class="btn btn-outline-danger" href="#"><i class="bi bi-x-lg"></i></a>
                </div>
              </td>
            </tr><?php endfor; ?>
          </tbody>
        </table>
      </div>
      <nav class="mt-3" aria-label="Appointments pagination">
        <ul class="pagination pagination-sm mb-0">
          <li class="page-item disabled"><span class="page-link">Prev</span></li>
          <li class="page-item active"><span class="page-link">1</span></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
      </nav>
    </div></div>
  </section>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
