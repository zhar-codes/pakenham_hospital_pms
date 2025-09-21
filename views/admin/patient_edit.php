<?php
// /views/admin/patient_edit.php
// If id is present -> Edit mode; else -> Add mode (placeholders only)
$id     = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : null;
$mode   = $id ? 'Edit' : 'Add';
$title  = "Admin · {$mode} Patient";
$user   = $user ?? 'User Name';
$active = 'patients';

require_once __DIR__ . '/../../includes/header.php'; // sets $routeAdmin & loads nav
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h1 class="h5 mb-0"><?= $mode ?> Patient</h1>
      <div class="d-flex gap-2">
        <a href="<?= $routeAdmin ?>/patients.php" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-arrow-left"></i> Back to Patients
        </a>
      </div>
    </div>

    <!-- Form -->
    <div class="card">
      <div class="card-body">
        <form class="row g-3" action="<?= $routeAdmin ?>/patient_save.php<?= $id ? '?id='.$id : '' ?>" method="post" enctype="multipart/form-data" novalidate>
          <?php if ($id): ?>
            <input type="hidden" name="id" value="<?= $id ?>">
          <?php endif; ?>

          <!-- Names -->
          <div class="col-md-6">
            <label for="first" class="form-label">First name</label>
            <input id="first" name="first_name" class="form-control" required value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>">
          </div>
          <div class="col-md-6">
            <label for="last" class="form-label">Last name</label>
            <input id="last" name="last_name" class="form-control" required value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>">
          </div>

          <!-- DOB / Phone / Email -->
          <div class="col-md-4">
            <label for="dob" class="form-label">DOB</label>
            <input id="dob" name="dob" type="date" class="form-control" value="<?= htmlspecialchars($_POST['dob'] ?? '') ?>">
          </div>
          <div class="col-md-4">
            <label for="phone" class="form-label">Phone</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-telephone"></i></span>
              <input id="phone" name="phone" type="tel" class="form-control" placeholder="e.g., 04xx xxx xxx" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
            </div>
          </div>
          <div class="col-md-4">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input id="email" name="email" type="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
          </div>

          <!-- Medicare / RFID / Check-in code -->
          <div class="col-md-4">
            <label for="medicare" class="form-label">Medicare #</label>
            <input id="medicare" name="medicare" class="form-control" placeholder="XXXX XXXX XXXX" value="<?= htmlspecialchars($_POST['medicare'] ?? '') ?>">
          </div>
          <div class="col-md-4">
            <label for="rfid" class="form-label">RFID UID</label>
            <input id="rfid" name="rfid_uid" class="form-control" placeholder="Tap card to fill…" value="<?= htmlspecialchars($_POST['rfid_uid'] ?? '') ?>">
          </div>
          <div class="col-md-4">
            <label for="checkin_code" class="form-label">Check-in Code</label>
            <input id="checkin_code" name="checkin_code" class="form-control" placeholder="e.g., PMS-9K2QF" value="<?= htmlspecialchars($_POST['checkin_code'] ?? '') ?>">
          </div>

          <!-- Address -->
          <div class="col-12">
            <label for="address" class="form-label">Address</label>
            <input id="address" name="address" class="form-control" value="<?= htmlspecialchars($_POST['address'] ?? '') ?>">
          </div>

          <!-- Notes -->
          <div class="col-12">
            <label for="notes" class="form-label">Notes</label>
            <textarea id="notes" name="notes" rows="4" class="form-control" placeholder="Allergies, accessibility needs…"><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
          </div>

          <!-- Attachments -->
          <div class="col-12">
            <label for="files" class="form-label">Attachments</label>
            <input id="files" name="files[]" type="file" class="form-control" multiple>
            <div class="form-text">PDF, JPG, PNG up to 5MB each.</div>
          </div>

          <!-- Status -->
          <div class="col-md-4">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-select">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>

          <!-- Actions -->
          <div class="col-12 d-flex gap-2">
            <button class="btn btn-primary" type="submit">
              <i class="bi bi-check2-circle"></i> Save
            </button>
            <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/patients.php">Cancel</a>
            <?php if ($id): ?>
              <a class="btn btn-outline-danger ms-auto" href="<?= $routeAdmin ?>/patient_delete.php?id=<?= $id ?>" onclick="return confirm('Delete this patient?');">
                <i class="bi bi-trash"></i> Delete
              </a>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>

    <!-- Optional: Recent appointments card -->
    <div class="card mt-4">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h2 class="h6 mb-0">Recent Appointments</h2>
          <a class="btn btn-outline-secondary btn-sm" href="<?= $routeAdmin ?>/appointments.php">View all</a>
        </div>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-light">
              <tr><th>Date</th><th>Time</th><th>Doctor</th><th>Status</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i<3; $i++): ?>
              <tr>
                <td>—</td><td>—</td><td>—</td>
                <td><span class="badge bg-secondary">—</span></td>
                <td class="text-end">
                  <div class="btn-group btn-group-sm">
                    <a class="btn btn-outline-primary" href="<?= $routeAdmin ?>/appointment_view.php?id=<?= $i ?>"><i class="bi bi-eye"></i></a>
                    <a class="btn btn-outline-secondary" href="<?= $routeAdmin ?>/appointment_edit.php?id=<?= $i ?>"><i class="bi bi-pencil"></i></a>
                  </div>
                </td>
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
