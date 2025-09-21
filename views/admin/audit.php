<?php
// /views/admin/audit.php
$title  = 'Admin · Audit';
$user   = $user ?? 'User Name';
$active = 'audit';  // highlights in top navbar (if shown) and the sidebar

require_once __DIR__ . '/../../includes/header.php'; // sets $baseUrl, $routeAdmin, loads nav config
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <!-- Filters -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h1 class="h6 mb-0">Filters</h1>
        </div>

        <form class="row g-3 align-items-end" method="get" action="<?= $routeAdmin ?>/audit.php">
          <div class="col-md-4">
            <label for="entity" class="form-label">Entity</label>
            <select id="entity" name="entity" class="form-select">
              <option value="">Any entity</option>
              <option>Appointment</option>
              <option>Patient</option>
              <option>User</option>
              <option>Ticket</option>
              <option>Settings</option>
            </select>
          </div>

          <div class="col-md-4">
            <label for="actor" class="form-label">User</label>
            <select id="actor" name="user" class="form-select">
              <option value="">Any user</option>
              <option>Admin —</option>
              <option>Reception —</option>
              <option>Doctor —</option>
            </select>
          </div>

          <div class="col-md-4">
            <label for="date" class="form-label">Date</label>
            <div class="input-group">
              <input id="date" name="date" type="date" class="form-control">
              <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
            </div>
          </div>

          <div class="col-12 d-flex gap-2">
            <button class="btn btn-primary"><i class="bi bi-funnel"></i> Apply</button>
            <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/audit.php"><i class="bi bi-x-circle"></i> Clear</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Audit log -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h2 class="h6 mb-0">Audit Log</h2>
          <div class="btn-group btn-group-sm">
            <a href="<?= $routeAdmin ?>/audit_export.php?fmt=csv" class="btn btn-outline-secondary"><i class="bi bi-download"></i> CSV</a>
            <a href="<?= $routeAdmin ?>/audit_export.php?fmt=json" class="btn btn-outline-secondary"><i class="bi bi-code"></i> JSON</a>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th style="width:180px;">Time</th>
                <th style="width:180px;">User</th>
                <th style="width:140px;">Action</th>
                <th style="width:180px;">Entity</th>
                <th>Details</th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i<6; $i++): ?>
              <tr>
                <td>—</td>
                <td>—</td>
                <td><span class="badge bg-secondary">—</span></td>
                <td>—</td>
                <td class="text-muted">—</td>
              </tr>
              <?php endfor; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination (placeholder) -->
        <nav aria-label="Audit pagination" class="mt-3">
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item disabled"><span class="page-link">Prev</span></li>
            <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </section>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
