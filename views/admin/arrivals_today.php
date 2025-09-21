<?php
// /views/admin/arrivals_today.php
$title  = 'Admin · Arrivals';
$user   = $user ?? 'User Name';
$active = 'arrivals';

require_once __DIR__ . '/../../includes/header.php';
$quick = $_GET['quick'] ?? 'today';
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <!-- Filters -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h1 class="h6 mb-0">Filter</h1>
        </div>

        <form class="row g-3 align-items-end" method="get" action="<?= $routeAdmin ?>/arrivals_today.php">
          <div class="col-md-4">
            <label for="doctor" class="form-label">Doctor</label>
            <select id="doctor" name="doctor" class="form-select">
              <option value="">All doctors</option>
              <option>Dr. —</option>
            </select>
          </div>

          <div class="col-md-4">
            <label for="clinic" class="form-label">Clinic</label>
            <select id="clinic" name="clinic" class="form-select">
              <option value="">All clinics</option>
              <option>—</option>
            </select>
          </div>

          <div class="col-md-4">
            <label for="date" class="form-label">Date</label>
            <div class="input-group">
              <input id="date" name="date" type="date" class="form-control">
              <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
            </div>
          </div>

          <!-- Toggle chips -->
          <div class="col-12 d-flex flex-wrap gap-2">
            <input type="radio" class="btn-check" name="quick" id="qDoctor" value="doctor" <?= $quick==='doctor'?'checked':'' ?>>
            <label class="btn btn-outline-secondary" for="qDoctor">Doctor</label>

            <input type="radio" class="btn-check" name="quick" id="qClinic" value="clinic" <?= $quick==='clinic'?'checked':'' ?>>
            <label class="btn btn-outline-secondary" for="qClinic">Clinic</label>

            <input type="radio" class="btn-check" name="quick" id="qToday" value="today" <?= $quick==='today'?'checked':'' ?>>
            <label class="btn btn-primary" for="qToday">Today</label>

            <div class="ms-auto d-flex gap-2">
              <button class="btn btn-primary"><i class="bi bi-funnel"></i> Apply</button>
              <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/arrivals_today.php"><i class="bi bi-x-circle"></i> Clear</a>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Arrivals table -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h2 class="h6 mb-0">Arrivals</h2>
        </div>

        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th style="width:120px;">Time</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th style="width:140px;">Status</th>
                <th>Notes</th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i<7; $i++): ?>
              <tr>
                <td>—</td>
                <td>—</td>
                <td>—</td>
                <td><span class="badge bg-secondary">—</span></td>
                <td class="text-muted">—</td>
              </tr>
              <?php endfor; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
