<?php
// /views/clinician/patients.php
$title  = 'Clinician · Patients';
$user   = $user ?? 'User Name';
$active = 'clin_patients';   // highlight in clinician menu
$menu   = 'clinician';       // tell header.php to use clinician nav

require_once __DIR__ . '/../../includes/header.php'; // sets $routeClinician & loads nav
$q = trim($_GET['q'] ?? '');
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <!-- Header actions -->
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h1 class="h6 mb-0">Patients</h1>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-secondary btn-sm" href="<?= $routeClinician ?>/arrivals_today.php">
          <i class="bi bi-clipboard2-pulse"></i> Arrivals Today
        </a>
      </div>
    </div>

    <!-- Search -->
    <div class="card mb-4">
      <div class="card-body">
        <form class="row g-3" method="get" action="<?= $routeClinician ?>/patients.php">
          <div class="col-md-9">
            <label for="q" class="form-label">Search</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input id="q" name="q" class="form-control" placeholder="Name, phone, email…" value="<?= htmlspecialchars($q) ?>">
            </div>
          </div>
          <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Apply</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Patients table -->
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th>Name</th>
                <th style="width:130px;">DOB</th>
                <th style="width:150px;">Phone</th>
                <th>Email</th>
                <th style="width:130px;">Last Visit</th>
                <th class="text-end" style="width:160px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i<6; $i++): ?>
              <tr>
                <td><a href="<?= $routeClinician ?>/patient_view.php?id=<?= $i ?>">—</a></td>
                <td>—</td>
                <td>—</td>
                <td>—</td>
                <td>—</td>
                <td class="text-end">
                  <div class="btn-group btn-group-sm">
                    <a class="btn btn-outline-primary" href="<?= $routeClinician ?>/note_new.php?pid=<?= $i ?>"><i class="bi bi-journal-text"></i> Note</a>
                    <a class="btn btn-outline-secondary" href="<?= $routeClinician ?>/appointment_new.php?pid=<?= $i ?>"><i class="bi bi-calendar-plus"></i> Appt</a>
                  </div>
                </td>
              </tr>
              <?php endfor; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination (placeholder) -->
        <nav aria-label="Patients pagination" class="mt-3">
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item disabled"><span class="page-link">Prev</span></li>
            <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
