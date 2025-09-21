<?php
// /views/clinician/profile.php
$title  = 'Clinician · Profile / Settings';
$user   = $user ?? 'User Name';
$active = 'clin_profile';  // highlight in clinician menu
$menu   = 'clinician';     // use clinician top nav

require_once __DIR__ . '/../../includes/header.php'; // sets $routeClinician & loads nav
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <section class="col-lg-9">
    <!-- Profile summary (read-only) -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h1 class="h6 mb-0">Profile</h1>
          <a class="btn btn-outline-secondary btn-sm" href="<?= $routeClinician ?>/profile_edit.php">
            <i class="bi bi-pencil"></i> Edit Profile
          </a>
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <div class="border rounded p-3 h-100">
              <div class="text-muted small">Name</div>
              <div class="fw-semibold"><?= htmlspecialchars($user) ?></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="border rounded p-3 h-100">
              <div class="text-muted small">Role</div>
              <div class="fw-semibold">Clinician</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="border rounded p-3 h-100">
              <div class="text-muted small">Email</div>
              <div class="fw-semibold">user@example.com</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="border rounded p-3 h-100">
              <div class="text-muted small">Phone</div>
              <div class="fw-semibold">—</div>
            </div>
          </div>
          <div class="col-12">
            <div class="border rounded p-3">
              <div class="text-muted small">Specialty</div>
              <div class="fw-semibold">—</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Change password -->
    <div class="card mb-4">
      <div class="card-body">
        <h2 class="h6 mb-3">Change Password</h2>
        <form class="row g-3" action="<?= $routeClinician ?>/profile_password_save.php" method="post" novalidate>
          <div class="col-md-6">
            <label for="oldpw" class="form-label">Current password</label>
            <input id="oldpw" name="oldpw" type="password" class="form-control" autocomplete="current-password" required>
          </div>
          <div class="col-md-6"></div>

          <div class="col-md-6">
            <label for="newpw" class="form-label">New password</label>
            <input id="newpw" name="newpw" type="password" class="form-control" autocomplete="new-password" required>
            <div class="form-text">Use at least 8 characters with letters and numbers.</div>
          </div>
          <div class="col-md-6">
            <label for="confirmpw" class="form-label">Confirm new password</label>
            <input id="confirmpw" name="confirmpw" type="password" class="form-control" autocomplete="new-password" required>
          </div>

          <div class="col-12 d-flex gap-2">
            <button class="btn btn-primary" type="submit"><i class="bi bi-check2-circle"></i> Save</button>
            <a class="btn btn-outline-secondary" href="<?= $routeClinician ?>/profile.php">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
