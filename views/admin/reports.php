<?php
// /views/admin/reports.php
$title  = 'Admin · Reports';
$user   = $user ?? 'User Name';
$active = 'reports';

require_once __DIR__ . '/../../includes/header.php'; // sets $routeAdmin & loads nav
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <!-- Filters + Export -->
    <div class="card mb-4">
      <div class="card-body">
        <form class="row g-3 align-items-end" method="get" action="<?= $routeAdmin ?>/reports.php">
          <div class="col-md-3">
            <label class="form-label" for="from">From</label>
            <input id="from" name="from" type="date" class="form-control" value="<?= htmlspecialchars($_GET['from'] ?? '') ?>">
          </div>
          <div class="col-md-3">
            <label class="form-label" for="to">To</label>
            <input id="to" name="to" type="date" class="form-control" value="<?= htmlspecialchars($_GET['to'] ?? '') ?>">
          </div>
          <div class="col-md-3">
            <label class="form-label" for="doctor">Doctor</label>
            <select id="doctor" name="doctor" class="form-select">
              <option value="">All doctors</option>
              <option>—</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label" for="clinic">Clinic</label>
            <select id="clinic" name="clinic" class="form-select">
              <option value="">All clinics</option>
              <option>—</option>
            </select>
          </div>

          <div class="col-12 d-flex gap-2">
            <button class="btn btn-primary"><i class="bi bi-funnel"></i> Apply</button>
            <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/reports.php"><i class="bi bi-x-circle"></i> Clear</a>

            <div class="ms-auto d-flex gap-2">
              <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/reports_export.php?fmt=csv"><i class="bi bi-filetype-csv"></i> Export CSV</a>
              <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/reports_export.php?fmt=pdf"><i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Charts -->
    <div class="row g-4">
      <!-- Bookings per day -->
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h2 class="h6 mb-0">Bookings per day</h2>
              <span class="text-muted small">Line</span>
            </div>
            <div class="ratio ratio-21x9 border rounded">
              <!-- placeholder canvas (hook up Chart.js later if you like) -->
              <canvas id="chartBookings"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Arrivals rate -->
      <div class="col-lg-6">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h2 class="h6 mb-0">Arrivals rate</h2>
              <span class="text-muted small">Bar</span>
            </div>
            <div class="ratio ratio-4x3 border rounded">
              <canvas id="chartArrivals"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Tickets by status -->
      <div class="col-lg-6">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <h2 class="h6 mb-0">Tickets by status</h2>
              <span class="text-muted small">Pie</span>
            </div>
            <div class="ratio ratio-4x3 border rounded">
              <canvas id="chartTickets"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Optional: Summary table -->
    <div class="card mt-4">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h2 class="h6 mb-0">Summary</h2>
          <span class="text-muted small">Top-level metrics</span>
        </div>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th>Metric</th><th>Value</th><th>Period</th><th>Notes</th>
              </tr>
            </thead>
            <tbody>
              <tr><td>Total bookings</td><td>—</td><td>—</td><td class="text-muted">—</td></tr>
              <tr><td>Arrival rate</td> <td>—</td><td>—</td><td class="text-muted">—</td></tr>
              <tr><td>Tickets open</td> <td>—</td><td>—</td><td class="text-muted">—</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </section>
</div>

<!-- (Optional) stub setup for Chart.js if you decide to add it later -->
<script>
// Example: if you later include Chart.js, you can hydrate these canvases.
// <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
// then build charts targeting #chartBookings, #chartArrivals, #chartTickets
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
