<?php
$title  = 'Reception · Profile';
$user   = $user ?? 'User Name';
$active = 'profile';
$menu   = 'reception';
require_once __DIR__ . '/../../includes/header.php';
?>
<div class="row g-4">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>
  <section class="col-lg-9">
    <div class="card mb-4"><div class="card-body">
      <h1 class="h6 mb-3">Profile</h1>
      <div class="row g-3">
        <div class="col-md-6"><div class="border rounded p-3"><div class="text-muted small">Name</div><div class="fw-semibold"><?= htmlspecialchars($user) ?></div></div></div>
        <div class="col-md-6"><div class="border rounded p-3"><div class="text-muted small">Role</div><div class="fw-semibold">Reception</div></div></div>
        <div class="col-md-6"><div class="border rounded p-3"><div class="text-muted small">Email</div><div class="fw-semibold">user@example.com</div></div></div>
        <div class="col-md-6"><div class="border rounded p-3"><div class="text-muted small">Phone</div><div class="fw-semibold">—</div></div></div>
      </div>
    </div></div>

    <div class="card"><div class="card-body">
      <h2 class="h6 mb-3">Change Password</h2>
      <form class="row g-3" action="#" method="post" novalidate>
        <div class="col-md-6"><label class="form-label" for="oldpw">Current password</label><input id="oldpw" name="oldpw" type="password" class="form-control" autocomplete="current-password"></div>
        <div class="col-md-6"></div>
        <div class="col-md-6"><label class="form-label" for="newpw">New password</label><input id="newpw" name="newpw" type="password" class="form-control" autocomplete="new-password"></div>
        <div class="col-md-6"><label class="form-label" for="confirmpw">Confirm new password</label><input id="confirmpw" name="confirmpw" type="password" class="form-control" autocomplete="new-password"></div>
        <div class="col-12 d-flex gap-2"><button class="btn btn-primary" type="submit"><i class="bi bi-check2-circle"></i> Save</button><a class="btn btn-outline-secondary" href="<?= $routeReception ?>/dashboard.php">Cancel</a></div>
      </form>
    </div></div>
  </section>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
