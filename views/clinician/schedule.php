<?php
// /views/clinician/arrivals_today.php
$title  = 'Clinician · Arrivals Today';
$user   = $user ?? 'User Name';
$active = 'clin_arrivals';   // highlight in clinician menu
$menu   = 'clinician';       // tell header.php to use clinician nav

require_once __DIR__ . '/../../includes/header.php'; // sets $routeClinician & loads nav
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <!-- Filters -->
    <div class="card mb-4">
      <div class="card-body">
        <form class="row g-3 align-items-end" method="get" action="<?= $routeClinician ?>/arrivals_today.php">
          <div class="col-md-4">
            <label for="doctor" class="form-label">Doctor</label>
            <select id="doctor" name="doctor" class="form-select">
              <option value="">Me</option>
              <option>All</option>
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
            <input id="date" name="date" type="date" class="form-control" value="<?= htmlspecialchars($_GET['date'] ?? '') ?>">
          </div>
          <div class="col-12 d-flex gap-2">
            <button class="btn btn-primary"><i class="bi bi-funnel"></i> Apply</button>
            <a class="btn btn-outline-secondary" href="<?= $routeClinician ?>/arrivals_today.php"><i class="bi bi-x-circle"></i> Today</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Doctor Day View -->
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h1 class="h6 mb-0">Doctor Day View (09:00–17:00)</h1>
          <span class="text-muted small"><?= date('l') ?></span>
        </div>

        <div class="row g-3">
          <?php
          // simple 4-block day segmentation placeholder
          $blocks = [
            '09:00 – 11:00',
            '11:00 – 13:00',
            '13:00 – 15:00',
            '15:00 – 17:00',
          ];
          foreach ($blocks as $b): ?>
            <div class="col-md-6">
              <div class="border rounded p-3 h-100">
                <div class="text-muted small mb-2"><?= $b ?></div>
                <div class="table-responsive">
                  <table class="table table-sm align-middle mb-0">
                    <thead class="table-light">
                      <tr>
                        <th style="width:100px;">Time</th>
                        <th>Patient</th>
                        <th style="width:110px;">Status</th>
                        <th class="text-end" style="width:90px;">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php for ($i=0; $i<2; $i++): ?>
                      <tr>
                        <td>—</td>
                        <td><a href="<?= $routeClinician ?>/patient_view.php?id=<?= $i ?>">—</a></td>
                        <td><span class="badge bg-secondary">—</span></td>
                        <td class="text-end">
                          <div class="btn-group btn-group-sm">
                            <a class="btn btn-outline-primary" href="<?= $routeClinician ?>/note_new.php?pid=<?= $i ?>"><i class="bi bi-journal-text"></i></a>
                            <a class="btn btn-outline-secondary" href="<?= $routeClinician ?>/appointment_edit.php?id=<?= $i ?>"><i class="bi bi-pencil"></i></a>
                          </div>
                        </td>
                      </tr>
                      <?php endfor; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
