<?php
// PakenhamH_Web_App/views/public/patient_register.php
$title = 'Register Patient — Pakenham Hospital';
include __DIR__ . '/../_layout_top.php';
$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<div class="row justify-content-center">
  <div class="col-md-8 col-lg-7">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="mb-3">Register as Patient</h3>
        <?php if ($flash): ?>
          <div class="alert alert-info"><?= htmlspecialchars($flash) ?></div>
        <?php endif; ?>
        <form method="post" action="<?= $baseUrl ?>/index.php?p=auth/register" novalidate>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">First name</label>
              <input class="form-control" name="first_name" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Last name</label>
              <input class="form-control" name="last_name" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Username</label>
              <input class="form-control" name="username" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Password</label>
              <input class="form-control" type="password" name="password" required>
            </div>
            <div class="col-12">
              <label class="form-label">Email</label>
              <input class="form-control" type="email" name="email">
            </div>
          </div>
          <button class="btn btn-success mt-3" type="submit">Create Account</button>
          <a class="btn btn-outline-secondary mt-3" href="<?= $baseUrl ?>/index.php?p=auth/login">Already have an account?</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../_layout_bottom.php'; ?>
