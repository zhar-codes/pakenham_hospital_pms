<?php
$title  = 'Reception · Check-in';
$user   = $user ?? 'User Name';
$active = 'checkin';
$menu   = 'reception';
require_once __DIR__ . '/../../includes/header.php';
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>
  <section class="col-lg-9">
    <div class="card mb-4"><div class="card-body">
      <h1 class="h6 mb-2">Welcome</h1>
      <p class="text-muted mb-0">Scan QR or enter the 6-digit code to check in a patient.</p>
    </div></div>

    <div class="card mb-4"><div class="card-body">
      <form class="row g-3" method="post" action="<?= $routeReception ?>/checkin.php">
        <div class="col-md-6">
          <label for="code" class="form-label">Check-in code</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-hash"></i></span>
            <input id="code" name="code" class="form-control" placeholder="e.g., 123-456">
          </div>
        </div>
        <div class="col-md-6 d-flex align-items-end">
          <button class="btn btn-primary" type="submit"><i class="bi bi-door-open"></i> Check-in</button>
        </div>
      </form>
    </div></div>

    <div class="card"><div class="card-body">
      <h2 class="h6 mb-2">Recent Check-ins</h2>
      <div class="table-responsive">
        <table class="table align-middle">
          <thead class="table-light"><tr>
            <th style="width:130px;">Time</th><th>Patient</th><th style="width:160px;">Doctor</th><th style="width:140px;">Status</th>
          </tr></thead>
          <tbody><?php for ($i=0; $i<5; $i++): ?>
            <tr><td>—</td><td>—</td><td>—</td><td><span class="badge bg-success">Checked-in</span></td></tr>
          <?php endfor; ?></tbody>
        </table>
      </div>
    </div></div>
  </section>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
