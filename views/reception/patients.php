<?php
$title  = 'Reception · Patients';
$user   = $user ?? 'User Name';
$active = 'patients';
$menu   = 'reception';
require_once __DIR__ . '/../../includes/header.php';
$q = trim($_GET['q'] ?? '');
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>
  <section class="col-lg-9">
    <div class="card mb-4"><div class="card-body">
      <form class="row g-3 align-items-end" method="get" action="<?= $routeReception ?>/patients.php">
        <div class="col-md-9">
          <label for="q" class="form-label">Search</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input id="q" name="q" class="form-control" placeholder="Name, phone, email…" value="<?= htmlspecialchars($q) ?>">
          </div>
        </div>
        <div class="col-md-3 d-flex gap-2">
          <button class="btn btn-primary w-100" type="submit"><i class="bi bi-funnel"></i> Apply</button>
        </div>
      </form>
    </div></div>

    <div class="card"><div class="card-body">
      <div class="d-flex justify-content-end mb-2">
        <a class="btn btn-primary btn-sm" href="<?= $routeReception ?>/patient_form.php"><i class="bi bi-person-plus"></i> New Patient</a>
      </div>
      <div class="table-responsive">
        <table class="table align-middle">
          <thead class="table-light">
            <tr>
              <th>Name</th><th style="width:130px;">DOB</th><th style="width:150px;">Phone</th>
              <th>Email</th><th style="width:130px;">Last Visit</th><th class="text-end" style="width:160px;">Actions</th>
            </tr>
          </thead>
          <tbody><?php for ($i=0; $i<10; $i++): ?>
            <tr>
              <td><a href="<?= $routeReception ?>/patient_form.php?id=<?= $i ?>">—</a></td>
              <td>—</td><td>—</td><td>—</td><td>—</td>
              <td class="text-end">
                <div class="btn-group btn-group-sm">
                  <a class="btn btn-outline-secondary" href="<?= $routeReception ?>/patient_form.php?id=<?= $i ?>"><i class="bi bi-pencil"></i></a>
                  <a class="btn btn-outline-success" href="<?= $routeReception ?>/appointment_form.php?pid=<?= $i ?>"><i class="bi bi-calendar-plus"></i></a>
                </div>
              </td>
            </tr><?php endfor; ?>
          </tbody>
        </table>
      </div>
      <nav class="mt-3" aria-label="Patients pagination">
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
